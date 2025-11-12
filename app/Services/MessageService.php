<?php
namespace App\Services;

use Illuminate\Support\Str;
use App\Jobs\ProcessEmailJob;
use App\Events\ChatMessageSent;
use App\Notifications\NewMessage;
use Google\Client as GoogleClient;
// use App\Services\PushNotificationService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use App\Notifications\SendPushNotification;
use App\Mail\NotifyMessageEmail; // comeback
use App\Models\{Message,Chat,User,MessageImage,Listing,DeviceToken};

class MessageService
{
   protected string $projectId;
    protected GoogleClient $googleClient;

    public function __construct()
    {
        $this->projectId = config('services.fcm.project_id');

        $this->googleClient = new GoogleClient();
        $this->googleClient->setAuthConfig(storage_path('app/firebase/Zenith IntelliScore-51731-firebase-adminsdk-fbsvc-e8a433af0a.json'));
        $this->googleClient->addScope('https://www.googleapis.com/auth/firebase.messaging');
    }

    public function createMessage(array $data)
    {
    
        $listing = Listing::where('id',$data['listing_id'])->first();

        if($data['chat_id'] == null){
            
            $check = Chat::where('listing_id',$data['listing_id'])->where('owner',$data['owner'])
            ->where('owner_type',$data['owner_type'])
            ->where('user1_id', Auth::id())
        ->where('user2_id', $data['to_user_id'])->first();

            if(empty($check)){
                $chat = Chat::create([
                    'user2_id' => $data['to_user_id'],
                    'user1_id' => Auth::id(),
                    'owner' => $data['owner'],
                    'owner_type' => $data['owner_type'],
                    'listing_id' => $data['listing_id'],
                ]);
    
                $message = new Message;
                $message->body = $data['message'];
                $message->user_id = Auth::id();
                $message->sender = true;
                $message->chat_id = $chat->id;
                $message->save();

                if (isset($data['image'])) {
                    foreach ($data['image'] as $file) {
                        $fileName = Str::random(16) . '.' . $file->getClientOriginalExtension();
                        $path = $file->storeAs('messages', $fileName, 'public');
        
                        $message->images()->save(
                            new MessageImage([
                                'filename' => $fileName,
                            ]),
                        );
                    }
                }

                // send notification
                $user = User::find($data['to_user_id']);
                $created = Auth::user();
                $user->notify(
                    new NewMessage($message,$created)
                );

                if($user->player_id != null){
                    $user->notify(new SendPushNotification(
                        $message->body,
                        'Message from '.$created->name,
                        $data['chat_id'], 
                        'chat-invite'
                    ));
                } else{
                    ProcessEmailJob::dispatch($user->email, $created->name, 'New Inbox Received', $message->body,
                        [
                            'url' => route('index'), 
                            'text' => 'Visit Zenith IntelliScore', 
                        ]
                    );
                }

                // comeback
                // 1. Generate a unique Agora channel name and token...
        $channelName = Str::random(12);
        // (generate your Agora token here)

        // live push
        event(new ChatMessageSent($message));

        // 2. Send the push invite
        // $this->sendMessagePush($user, $channelName, $user->name, $message->body, $chat->id, $listing->slug);

        return response()->json(['channelName' => $channelName]);

                // Mail::to($user->email)->send(new NotifyMessageEmail($user,$message,$created));

                return $message;

            } else{
                $message = new Message;
                $message->body = $data['message'];
                $message->user_id = Auth::id();
                $message->sender = true;
                $message->chat_id = $check->id;
                $message->save();

                if (isset($data['image'])) {
                    foreach ($data['image'] as $file) {
                        $fileName = Str::random(16) . '.' . $file->getClientOriginalExtension();
                        $path = $file->storeAs('messages', $fileName, 'public');
        
                        $message->images()->save(
                            new MessageImage([
                                'filename' => $fileName,
                            ]),
                        );
                    }
                }

                // send notification
                $user = User::find($data['to_user_id']);
                $created = Auth::user();
                $user->notify(
                    new NewMessage($message,$created)
                );

                if($user->player_id != null){
                    $user->notify(new SendPushNotification(
                        $message->body,
                        'Message from '.$created->name,
                        $data['chat_id'], 
                        'chat-invite'
                    ));
                } else{
                    ProcessEmailJob::dispatch($user->email, $created->name, 'New Inbox Received', $message->body,
                        [
                            'url' => route('index'), 
                            'text' => 'Visit Zenith IntelliScore', 
                        ]
                    );
                }

                 $channelName = Str::random(12);
        // (generate your Agora token here)

// live push
        event(new ChatMessageSent($message));
        // 2. Send the push invite
        // $this->sendMessagePush($user, $channelName, $user->name, $message->body, $check->id, $listing->slug);

                // comeback
                // Mail::to($user->email)->send(new NotifyMessageEmail($user,$message,$created));

                return $message;
            }
            
        } else{
            $message = new Message;
            $message->body = $data['message'];
            $message->user_id = Auth::id();
            $message->sender = true;
            $message->chat_id = $data['chat_id'];
            $message->save();

            if (isset($data['image'])) {
                foreach ($data['image'] as $file) {
                    $fileName = Str::random(16) . '.' . $file->getClientOriginalExtension();
                    $path = $file->storeAs('messages', $fileName, 'public');
    
                    $message->images()->save(
                        new MessageImage([
                            'filename' => $fileName,
                        ]),
                    );
                }
            }
            
            // send notification
            $user = User::find($data['to_user_id']);
            $created = Auth::user();
                $user->notify(
                    new NewMessage($message,$created)
                );

                if($user->player_id != null){
                    $user->notify(new SendPushNotification(
                        $message->body,
                        'Message from '.$created->name,
                        $data['chat_id'], 
                        'chat-invite'
                    ));
                } else{
                    ProcessEmailJob::dispatch($user->email, $created->name, 'New Inbox Received', $message->body,
                        [
                            'url' => route('index'), 
                            'text' => 'Visit Zenith IntelliScore', 
                        ]
                    );
                }
                

                 $channelName = Str::random(12);
        // (generate your Agora token here)

// live push
        event(new ChatMessageSent($message));
        // 2. Send the push invite
        // $this->sendMessagePush($user, $channelName, $user->name, $message->body, $data['chat_id'], $listing->slug);

              // comeback
                // Mail::to($user->email)->send(new NotifyMessageEmail($user,$message,$created));

            return $message;
        }
    }


    public function sendMessagePush(User $receiver, string $channelName, $from, $message, $chatId, $listing): void
    {
        $accessToken = $this->googleClient->fetchAccessTokenWithAssertion()['access_token'];

        foreach ($receiver->deviceTokens as $dt) {
            // Cast all values in data to string
            $data = array_map('strval', [
                'type'        => 'chat-invite',
                'fromUser'    => auth()->id(),
                'channelName' => $channelName,
                'chatId' => $chatId,
                'listing' => $listing,
            ]);

            $payload = [
                'message' => [
                    'token'        => $dt->token,
                    'notification' => [
                    'title' => 'Message from '.$from,
                    'body'  => $message,    // leave $messageText untouched
                    ],
                    'data' => $data,
                ],
                ];

                $response = Http::withToken($accessToken)
                    ->post("https://fcm.googleapis.com/v1/projects/{$this->projectId}/messages:send", $payload);


                    if (! $response->successful()) {
    $status = $response->json('error.status');
    Log::warning("FCM push error {$status}", ['token'=>$dt->token]);

    if (in_array($status, ['UNREGISTERED','INVALID_ARGUMENT','NOT_FOUND'])) {
        DeviceToken::where('token',$dt->token)->delete();
    }
}

            Log::info('FCM v1 Push Sent', [
                'to'      => $dt->token,
                'status'  => $response->status(),
                'body'    => $response->body(),
                'channel' => $channelName,
            ]);

            if (!$response->successful()) {
                Log::error('FCM v1 Push Failed', [
                    'token' => $dt->token,
                    'error' => $response->body(),
                ]);
            }
        }
    }

}
