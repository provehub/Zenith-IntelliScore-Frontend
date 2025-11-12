<?php

namespace App\Http\Controllers\Settings;

use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Services\MessageService;
use App\Models\{User,Chat,Vendor};
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Http\Requests\Settings\ProfileUpdateRequest;

class ProfileController extends Controller
{

     public function destroyMobile(Request $request)
    {
        $request->validate([
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        if(method_exists($user, 'coach') && $user->coach){
            Gym::where('user_id', $user->id)->delete();
            Promoted::where('user_id', $user->id)->delete();
            DailyVisit::where('user_id', $user->id)->delete();
            Review::where('business_id', $user->id)->delete();
            Keyword::where('user_id', $user->id)->delete();
            Status::where('user_id', $user->id)->delete();
            // get chat 
            $chat = Chat::where('user2_id', $user->id)->first();
            if($chat){
                Message::where('chat_id', $chat->id)->delete();
                Chat::where('id', $chat->id)->delete();
            }
            

            CoachEvent::where('coach_id', $user->coach->id)->delete();

            $user->coach->deleteOrFail();
        }
        if(method_exists($user, 'gym') && $user->gym){
            Gym::where('user_id', $user->id)->delete();
            Promoted::where('user_id', $user->id)->delete();
            DailyVisit::where('user_id', $user->id)->delete();
            Review::where('business_id', $user->id)->delete();
            Keyword::where('user_id', $user->id)->delete();
            Status::where('user_id', $user->id)->delete();

            Message::where('user_id', $user->id)->delete();

            // get chat 
            $chat = Chat::where('user2_id', $user->id)->first();
            if($chat){
                Message::where('chat_id', $chat->id)->delete();
                Chat::where('id', $chat->id)->delete();
            }
            

            GymEvent::where('gym_id', $user->gym->id)->delete();

            $user->gym->deleteOrFail();
        }

        Bookmark::where('user_id', $user->id)->delete();
        Review::where('user_id', $user->id)->delete();
        // get chat 
        $chat = Chat::where('user1_id', $user->id)->first();
        if($chat){
            Message::where('chat_id', $chat->id)->delete();
            Chat::where('id', $chat->id)->delete();
        }
        
        
        // Auth::logout();
        $user->delete();

        // $request->session()->invalidate();
        // $request->session()->regenerateToken();

        return response()->json([
            'status' => 'success',
            'message' => 'Account Deleted',
        ]);

    }

     public function updateMobile(ProfileUpdateRequest $request)
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

    $user = Auth::user();
     $token = $user->createToken('api-token');
 
     return response()->json([
         'access_token' => $token->plainTextToken,
         'token_type' => 'Bearer',
         'user' => $user,
         'status' => 'success',
        'message' => 'Updated Successfully.',
     ]);
    }

    public function uploadPhoto(Request $request)
    {
        try {
            $user = Auth::user();

            if (!$request->hasFile('photo')) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'No photo uploaded.'
                ], 400);
            }

            $uploadedPhoto = $request->file('photo');
            $nameOfPhoto = 'profile_'.Str::random(6).'.'.$uploadedPhoto->getClientOriginalExtension(); 
            $path = $uploadedPhoto->storeAs('profiles', $nameOfPhoto, 'public');
            
            // personal 
            $user->personal()->updateOrCreate(
                [
                    'profile_image' => $nameOfPhoto
                    ]
            );


            $token = $user->createToken('api-token');
    
            return response()->json([
                'access_token' => $token->plainTextToken,
                'token_type' => 'Bearer',
                'user' => $user,
                'status' => 'success',
                'message' => 'Updated Successfully.',
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function markAsRead($id)
    {
        $user = Auth::user();
        $user->unreadNotifications->where('id', $id)->markAsRead();

        return response()->json($user);
        // return back()->with('success', 'Notification read.');
        // return response()->json(['success' => true]);
    }

    public function markAsReadAll()
    {
        $user = Auth::user();
    
        // Mark all unread notifications as read
        $user->unreadNotifications->markAsRead();
    
        return redirect()->back();
    }
    
    /**
     * Create a message.
     */
    public function createSend(Request $request, MessageService $messageService){

        // dd($request->all());
        $request->validate([
            'to_user_id' => 'required',
            'message' => 'required',
            'owner' => 'required',
            'owner_type' => 'required',
            'listing_id' => 'required',
        ]);

        $message = $messageService->createMessage($request->all());

        // dd($message);

        return response()->json($message);
    }

     /**
     * Create a message.
     */
    public function create(Request $request, MessageService $messageService){

        // dd($request->all());
        $request->validate([
            'to_user_id' => 'required',
            'message' => 'required',
            'listing_id' => 'required',
        ]);

        $message = $messageService->createMessage($request->all());

        // dd($message);

        return redirect()->back();
    }

    public function chats()
    {
        return Redirect::route('user.chat');
    }

    public function userChat()
    {
        $chats = Chat::with(['sender', 'receiver', 'oldestMessages.images'])
        ->where('user1_id', Auth::id())
        ->orWhere('user2_id', Auth::id())
        ->with('listing')
        ->latest()->get();
    
    $chatsArray = $chats->map(function ($chat) {
        // Manually resolve the owner
        if ($chat->owner_type === 'agent') {
            $chat->owner = Vendor::find($chat->owner)->load('user');
        } elseif ($chat->owner_type === 'parents') {
            $chat->owner = User::find($chat->owner)->first();
        }  elseif ($chat->owner_type === 'students') {
            $chat->owner = User::find($chat->owner)->first();
        } else {
            $chat->owner = null;
        }
    
        // Convert the chat instance to an array
        $chatArray = $chat->toArray();
    
        // Add the owner data to the chat array
        // Check if owner is not null and convert it to an array
        $chatArray['owner'] = $chat->owner ? $chat->owner->toArray() : null;
    
        return $chatArray;
    });
    

    // return $chatsArray;

        return inertia('Chat',[
            'chats' => $chatsArray,
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function updatePhoto(Request $request, User $user): RedirectResponse
    {
        if ($request->hasFile('photo')) {
            $uploadedPhoto = $request->file('photo')[0];
            $nameOfPhoto = 'profile_' . Str::random(6) . '.' . $uploadedPhoto->getClientOriginalExtension();
    
            // Store the image in the public storage
            $path = $uploadedPhoto->storeAs('profiles', $nameOfPhoto, 'public');
    
            // Ensure the user has a Personal record
            if (!$user->personal) {
                $user->personal()->create([
                    'profile_image' => $nameOfPhoto
                ]);
            } else {
                // Update the existing profile image in personals
                $oldPhoto = $user->personal->profile_image;
    
                // Delete the old profile photo if it exists
                if ($oldPhoto && Storage::disk('public')->exists("profiles/{$oldPhoto}")) {
                    Storage::disk('public')->delete("profiles/{$oldPhoto}");
                }
    
                // Update the profile image
                $user->personal->update(['profile_image' => $nameOfPhoto]);
            }
        }
    
        return to_route('profile.edit');
    }
    
    /**
     * Show the user's profile settings page.
     */
    public function edit(Request $request): Response
    {
        return Inertia::render('settings/Profile', [
            'mustVerifyEmail' => $request->user() instanceof MustVerifyEmail,
            'status' => $request->session()->get('status'),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return to_route('profile.edit');
    }

    /**
     * Delete the user's profile.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validate([
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
