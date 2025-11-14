<?php

namespace App\Http\Controllers\Admin;

use App\Mail\ApprovalEmail;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
// use Illuminate\Console\View\Components\Alert;
use App\Http\Controllers\Controller; 
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;
use App\Services\{ListingService,CourseService};
use App\Models\{User,Project,Personal};

class AdminController extends Controller
{
    public function deactivatePromotion(Promotion $promotion)
    {
        // $promotion->load('promoted');
        $check = Promoted::where('promotion_id',$promotion->id)->first();
        if(empty($check)){
            $promotion->delete();
            return redirect()->back()->with('success', $promotion->name. ' was deleted!');
        }else{
            return redirect()->back()->with('error', 'Delete all promotions under '.$promotion->name .' to proceed!');
        }  
    }

    public function updatePromotion(Request $request, Promotion $promotion)
    {
        $promotion->name = $request->name;
        $promotion->description = $request->description;
        $promotion->price = $request->price;
        $promotion->days = $request->days;
        $promotion->save();

        return redirect()->back()->with('success', 'Promotion was Updated!');
        
    }

    public function promotionsIndex()
    {
        // $this->authorize('adminOnly', Promotion::class);

        return inertia('Admin/Promotions/Promotions',[
            'message'=>'Welcome Promotions',
            'promotions'=> Promotion::query()->withCount('promoted')->paginate(9)->withQueryString(),
        ]);
    }
    public function promoted(Promotion $promotion)
    {
        // $this->authorize('adminOnly', Promotion::class);

        return $promotion->load('promoted');

        // return inertia('Admin/Promotions/Promoted',[
        //     'message'=>'Welcome Promoted',
        //     'promotions'=> Promotion::query()->withCount('promoted')->paginate(9)->withQueryString(),
        // ]);
    }

    public function addPromotions(Request $request)
    {
        $this->authorize('adminOnly', Promotion::class);

        $request->validate([
            'price' => 'required',
            'days' => 'required',
            'name' => 'required',
            'description' => 'required',
        ]);

        $market = new Promotion;
        $market->name = $request->name;
        $market->description = $request->description;
        $market->days = $request->days;
        $market->price = $request->price;
        $market->save();

        return redirect()->back()->with('success', 'Promotion was Added!');
    }

    /**
     * Activate the specified vendor.
     *
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function deactivate(Vendor $vendor, User $user)
    {
        $vendor->status = 3;
        $vendor->save();        

        // $user->user_type = 12;
        // $user->save();

        Mail::to($user->email)->send(new ApprovalEmail($user,$vendor->name));

        return redirect()->back()->with('success', 'Agent was De-activated!');
    }

     /**
     * Activate the specified vendor.
     *
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function activate(Vendor $vendor, User $user)
    {
        $vendor->status = 1;
        $vendor->save();

        // $user->user_type = 10;
        // $user->save();

        Mail::to($user->email)->send(new ApprovalEmail($user,$vendor->name));

        return redirect()->back()->with('success', 'Agent was activated!');
    }
    
    public function agents()
    {
        return inertia('Admin/Vendors/Vendors',[
            'message'=>'Agents',
            'vendors' => Project::paginate(9)->withQueryString(),
        ]);
    }

    public function assignClassToStudents(Request $request, Student $student)
    {
        $request->validate([
            'school_classes' => 'required|array',
        ]);

        // Add student to each class in the array
        foreach ($request->input('school_classes') as $schoolClass) {
            $student->studentclass()->save(
                new StudentClass([
                    'school_class_id' => $schoolClass['id'],
                    'current_class' => 0,
                    'academic_session' => $request->academic_session,
                ])
            );
        }


        return redirect()->back()->with('success', $request->name.' was assigned new class!');
    }

    // paid
    public function paid($id) {
        $update = Review::where('id',$id)->first();
        $update->booking_id = 1;
        $update->save();

        return redirect()->back()->with('success', 'Successfully marked as paid!');

        // $user = User::find($update->user_id);

        // $destination = Destination::where('slug',$update->booking_slug)->first();

        // send SMS
        // $phone = $user->phone;
        // Check if the phone starts with '0' and remove it
        // if (substr($phone, 0, 1) === '0') {
        //     $phone = substr($phone, 1);
        // }
        // Prefix with +234
        // $phone = '234' . $phone;
        // $smsService = new SmsService();
        // $response = $smsService->sendSmsTermii($phone, 'Payment confirmed'.$destination->destination_name);

        // send Email
        
        // $datau = [
        //     'subject' => 'Congratulations',
        //     'm' => 'Congratulations',
        //     'ma' => 'Congratulations.',
        //     'ad_title' => $destination->destination_name,
        //     'advertiser_name' => $user->name, 
        // ];
        // Mail::to($user->email)->send(new \App\Mail\Ad($datau));

        // Session::flash('success', ' has been notified via email and SMS.'); 
        // Alert::success('Success', ' has been notified via email and SMS.');
        // return redirect()->route('admin.dashboard'); 
        // return back();
    }


    
    public function deletePhoto(Photo $photo)
    {
        Storage::disk('public')->delete('photos/' . $photo->filename);
        $photo->delete();
        return redirect()->back()->with('success', 'Image was deleted!');
    }




    public function destroyAirport(Request $request, SelectedAirport $selectedairport)
    {
        
        // Finally, delete the airport
        $selectedairport->delete();
        return redirect()->back()->with('success', 'Airport deleted successfully!');
    }


    public function siteSlider(Request $request) 
    { 
        // dd($request->all());

        $request->validate([
            'image.*' => 'required|mimes:jpeg,jpg,png', // Validate each image in the array
        ]);

        if ($request->has('image')) {
            foreach ($request->image as $file) {
                $fileName = time() . '_' . Str::random(6) . '.' . $file->getClientOriginalExtension();
                $path = $file->storeAs('photos', $fileName, 'public');
                
                $photo = new Photo([
                    'filename' => $fileName,
                    'place' => 'slider',
                ]);
                $photo->save();
            }

            return redirect()->back()->with('success', 'Images added to your slider!');
        }

        return redirect()->back()->with('error', 'Please upload images to proceed!');
    }

    public function dashboard()
    {
        return inertia('Admin/Index',[
            'message'=>'Welcome Admin',
            'time' => $this->getTime(),
            'users' => User::all()->count(),
            'payments' => 0,
            'listings' => 0,
            'agents' => Project::all()->count(),
        ]);
    }

    

    public function donations()
    {
        return inertia('Admin/Users/Students',[
            'message'=>'Students',
            'donated' => Payment::where('status', 'success')->sum('amount'),
            'donated_count' => Payment::where('status', 'success')->count(),
            'payments' => Payment::where('status', 'success')
            ->orderBy('created_at', 'desc') // Sorting by latest
            ->paginate(9)
            ->withQueryString()
        ]);
    }

    public function teachers()
    {
        // return User::where('user_type', 'teachers')->with('teacher.teacherclass.schoolclass')->orderBy('name', 'asc')
        // ->get();
        return inertia('Admin/Teachers/Teachers',[
            'message'=>'Teachers',
            'teachers'=> User::where('user_type', 'teachers')->with('teacher.teacherclass.schoolclass')->orderBy('name', 'asc')
            ->get(),
            'teachers_count' => User::where('user_type', 'teachers')->count(),
        ]);
    }

    public function teachersSubjects(User $user)
    {
        $teacher = $user->teacher;

        return inertia('Admin/Teachers/Subjects',[
            'message'=>'Teacher Subjects',
            'datum'=> TeacherSubject::where('teacher_id', $teacher->id)->with('classsubject','teachers.user')->get(),
            'data' => $teacher->load('user'),
            'count' => $teacher->teachersubject->count(),
        ]);
    }

    public function classSubject(SchoolClass $schoolclass)
    {
        // return SchoolClassSubject::where('school_class_id', $schoolclass->id)->with('classsubject','schoolclass')->get();

        return inertia('Admin/Class/Subjects',[
            'message'=>'Class Subjects',
            'datum'=> SchoolClassSubject::where('school_class_id', $schoolclass->id)->with('classsubject','schoolclass')->get(),
            'data' => $schoolclass,
            'count' => $schoolclass->count(),
        ]);
    }

    public function assignSubjectsToSchoolClass(Request $request, SchoolClass $schoolclass)
    {
        $request->validate([
            'class_subjects' => 'required|array',
        ]);

        // dd($request->all());

        foreach ($request->input('class_subjects') as $classSubjects) {
            $schoolclass->schoolclasssubject()->save(
                new SchoolClassSubject([
                    'class_subject_id' => $classSubjects['id'],
                ])
            );
        }

        return redirect()->back()->with('success', $request->name.' was assigned subjects!');
    }

    public function assignSubjectsToTeachers(Request $request, Teacher $teacher)
    {
        $request->validate([
            'class_subjects' => 'required|array',
        ]);

        // dd($request->all());

        foreach ($request->input('class_subjects') as $classSubjects) {
            $teacher->teacherclass()->save(
                new TeacherSubject([
                    'class_subject_id' => $classSubjects['id'],
                ])
            );
        }

        return redirect()->back()->with('success', $request->name.' was assigned subjects!');
    }



    public function teachersClasses(User $user)
    {
        $teacher = $user->teacher;

        return inertia('Admin/Teachers/Classes',[
            'message'=>'Teacher Classes',
            'datum'=> TeacherClass::where('teacher_id', $teacher->id)->with('schoolclass','teachers.user')->get(),
            'count' => $teacher->teacherclass->count(),
        ]);
    }

    public function assignClassToTeachers(Request $request, Teacher $teacher)
    {
        $request->validate([
            'school_classes' => 'required|array',
        ]);

        // Add teacher to each class in the array
        foreach ($request->input('school_classes') as $schoolClass) {
            $teacher->teacherclass()->save(
                new TeacherClass([
                    'school_class_id' => $schoolClass['id'],
                    'current_class' => $schoolClass['id'],
                    'academic_session' => academic_session(),
                ])
            );
        }

        return redirect()->back()->with('success', $request->name.' was assigned new classes!');
    }


    public function registerTeachers(Request $request)
    {
        $request->validate([
            'school_classes' => 'required',
            'gender' => 'required',
            'countries' => 'required',
            'states' => 'required',
            'cities' => 'required',
            'name' => 'required|string|max:255',
            'email' => 'required|string|lowercase|email|max:255|unique:'.User::class,
            'password' => ['required', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'user_type' => 'teachers',
        ]);

        event(new Registered($user));

        
        
        // create personal

        $user->personal()->save(
            new Personal([
                'gender' => $request->gender,
                'country_id' => $request->input('countries.id'),
                'state_id' => $request->input('states.id'),
                'city_id' => $request->input('cities.id'),
            ]),
        );

        // create teacher 
    
        $teacher = new Teacher();
        $teacher->user_id = $user->id;
        $teacher->save();

        // add teacher to class
        $teacher->teacherclass()->save(
            new TeacherClass([
                'school_class_id' => $request->input('school_classes.id'),
                'current_class' => $request->input('school_classes.id'),
                'academic_session' => academic_session(),
            ]),
        );

        return redirect()->back()->with('success', $request->name.' was Registered!');
    }

    public function parents()
    {
        return inertia('Admin/Users/Parents',[
            'message'=>'Parents',
            'parents'=> User::where('user_type', 'parents')->orderBy('name', 'asc')
            ->get(),
            'parents_count' => User::where('user_type', 'parents')->count(),
        ]);
    }

    public function parentStudents($parent)
    {
        $parent = StudentParent::where('user_id',$parent)->with('user')->first();

        return inertia('Admin/Users/ParentStudents',[
            'message'=>'Parent Students',
            'students'=> Student::where('student_parent_id',$parent->id)->with('user')->latest()
            ->get(),
            'students_count' => Student::where('student_parent_id',$parent->id)->count(),
            'parent' => $parent,
        ]);
    }

    public function users()
    {
        // $this->authorize('adminOnly', User::class);

        return inertia('Admin/Users/Users',[
            'message'=>'Users',
            'users'=> User::where('id', '!=', 1)->orderBy('name', 'asc')
            ->get(),
            'users_count' => User::count(),
        ]);
        // return inertia('Admin/Users/Users',[
        //     'message'=>'Users',
        //     'users'=> User::where('user_type', '=', 12)->orderBy('name', 'asc')
        //     ->get(),
        //     'users_count' => User::where('user_type', '=', 12)->count(),
        // ]);
    }

    public function subjects()
    {
        return inertia('Admin/Subject/Subjects',[
            'message'=>'Class Subject',
            'datum'=> ClassSubject::orderBy('name', 'asc')->get(),
            'count' => ClassSubject::count(),
        ]);
    }

    public function addClassSubject(Request $request)
    {
        
        if ($request->hasFile('image')) {
            foreach ($request->file('image') as $file) {
                $fileName = Str::random(16).'.'.$file->getClientOriginalExtension();
                
                $path = $file->storeAs('subjects', $fileName, 'public');

                $class = new ClassSubject;
                $class->name = $request->name;
                $class->description = $request->description;
                $class->photo = $fileName;
                $category->save();
            }

            return redirect()->back()->with('success', $request->name.' was Added!');
        }
       

        $class = new ClassSubject;
        $class->name = $request->name;
        $class->description = $request->description;
        $class->save();

        return redirect()->back()->with('success', $request->name.' was Added!');
    }

    public function updateClassSubject(Request $request, ClassSubject $classsubject)
    {
        
        if ($request->hasFile('image')) {
            foreach ($request->file('image') as $file) {
                $fileName = Str::random(16).'.'.$file->getClientOriginalExtension();
                
                $path = $file->storeAs('subjects', $fileName, 'public');

                
                $classsubject->name = $request->name;
                $classsubject->description = $request->description;
                $classsubject->photo = $fileName;
                $classsubject->save();
            }

            return redirect()->back()->with('success', $request->name.' was Updated!');
        }
       

        
        $classsubject->name = $request->name;
        $classsubject->description = $request->description;
        $classsubject->save();

        return redirect()->back()->with('success', $request->name.' was Updated!');
    }


    public function classes()
    {
        return inertia('Admin/Class/Classes',[
            'message'=>'Classes',
            'datum'=> SchoolClass::orderBy('name', 'asc')->get(),
            'count' => SchoolClass::count(),
        ]);
    }

    public function classTimetable(SchoolClass $schoolclass)
    {
        return inertia('Admin/Class/Timetable',[
            'message'=>'Timetable',
            'schoolclass' => $schoolclass,
            'calendar' => Timetable::where('school_class_id',$schoolclass->id)->get(),
        ]);
    }

    public function postCalendar(Request $request, SchoolClass $schoolclass){ 
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'start' => 'required',
            'end' => 'required',
        ]);
        
        if($request->has('id')){
            $check = Timetable::where('id',$request->id)->first();
            $check->title = $request->title;
            $check->description = $request->description;
            $check->types = $request->types;
            $check->start = $request->start;
            $check->end = $request->end;
            $check->save();

            return redirect()->back()->with('success', 'Timetable have been added to your class!');

        }
         // Save the calendar
         $schoolclass->calendars()->save(
            new Timetable([
                'title' => $request->title,
                'description' => $request->description,
                'types' => $request->types,
                'start' => $request->start,
                'end' => $request->end,
            ]),
        );
        

        return redirect()->back()->with('success', 'Timetable have been added to your school!');
    }
    

    public function deleteCalendar(Timetable $timetable)
    {
        $calendar->delete();
        return redirect()->back()->with('success', 'Timetable was deleted!');
    }

    public function addSchoolClass(Request $request)
    {
        
        if ($request->hasFile('image')) {
            foreach ($request->file('image') as $file) {
                $fileName = Str::random(16).'.'.$file->getClientOriginalExtension();
                
                $path = $file->storeAs('classes', $fileName, 'public');

                $class = new SchoolClass;
                $class->name = $request->name;
                $class->description = $request->description;
                $class->photo = $fileName;
                $category->save();
            }

            return redirect()->back()->with('success', $request->name.' was Added!');
        }
       

        $class = new SchoolClass;
        $class->name = $request->name;
        $class->description = $request->description;
        $class->save();

        return redirect()->back()->with('success', $request->name.' was Added!');
    }

    public function updateSchoolClass(Request $request, SchoolClass $schoolclass)
    {
        
        if ($request->hasFile('image')) {
            foreach ($request->file('image') as $file) {
                $fileName = Str::random(16).'.'.$file->getClientOriginalExtension();
                
                $path = $file->storeAs('classes', $fileName, 'public');

                
                $schoolclass->name = $request->name;
                $schoolclass->description = $request->description;
                $schoolclass->photo = $fileName;
                $schoolclass->save();
            }

            return redirect()->back()->with('success', $request->name.' was Updated!');
        }
       

        
        $schoolclass->name = $request->name;
        $schoolclass->description = $request->description;
        $schoolclass->save();

        return redirect()->back()->with('success', $request->name.' was Updated!');
    }

    public function exams()
    {
        return inertia('Admin/Exam/Exams',[
            'message'=>'Exams',
            'datum'=> Exam::orderBy('name', 'asc')->get(),
            'count' => Exam::count(),
        ]);
    }

    public function addExam(Request $request)
    {
        // dd($request->all());
        if ($request->hasFile('image')) {
            foreach ($request->file('image') as $file) {
                $fileName = Str::random(16).'.'.$file->getClientOriginalExtension();
                
                $path = $file->storeAs('exams', $fileName, 'public');

                $exam = new Exam;
                $exam->school_class_id = $request->input('data1.id');
                $exam->name = $request->name;
                $exam->timer = $request->timer;
                $exam->per_mark = $request->per_mark;
                $exam->total_marks = $request->total_marks;
                $exam->show_answer = $request->input('show_answer', false);
                $exam->cost_for_exam = $request->cost_for_exam;
                $exam->description = $request->description;
                $exam->photo = $fileName;
                $exam->save();
            }

            return redirect()->back()->with('success', $request->name.' exam was Added!');
        }
       

        $exam = new Exam;
        $exam->school_class_id = $request->input('data1.id');
        $exam->name = $request->name;
        $exam->timer = $request->timer;
        $exam->per_mark = $request->per_mark;
        $exam->total_marks = $request->total_marks;
        $exam->show_answer = $request->input('show_answer', false);
        $exam->cost_for_exam = $request->cost_for_exam;
        $exam->description = $request->description;
        $exam->save();

        return redirect()->back()->with('success', $request->name.' exam was Added!');
    }

    public function updateExam(Request $request, Exam $exam)
    {
         // Validate the request
        $request->validate([
            'school_class' => 'required',
        ]);
        
        if ($request->hasFile('image')) {
            foreach ($request->file('image') as $file) {
                $fileName = Str::random(16).'.'.$file->getClientOriginalExtension();
                
                $path = $file->storeAs('exams', $fileName, 'public');

                
                $exam->school_class_id = $request->input('school_class.id');
                $exam->name = $request->name;
                $exam->timer = $request->timer;
                $exam->per_mark = $request->per_mark;
                $exam->total_marks = $request->total_marks;
                $exam->show_answer = $request->input('show_answer', false);
                $exam->cost_for_exam = $request->cost_for_exam;
                $exam->description = $request->description;
                $exam->photo = $fileName;
                $exam->save();
            }

            return redirect()->back()->with('success', $request->name.' exam was Updated!');
        }
       

            
            $exam->school_class_id = $request->input('school_class.id');
            $exam->name = $request->name;
            $exam->timer = $request->timer;
            $exam->per_mark = $request->per_mark;
            $exam->total_marks = $request->total_marks;
            $exam->show_answer = $request->input('show_answer', false);
            $exam->cost_for_exam = $request->cost_for_exam;
            $exam->description = $request->description;
            $exam->save();

            return redirect()->back()->with('success', $request->name.' exam was Updated!');
        
       
    }

    public function examQuestions(Exam $exam)
    {
        $exam->load('questions');
        return inertia('Admin/Question/Question',[
            'message'=>'Exam Questions',
            'datum'=> $exam,
            'count' => $exam->questions->count(),
        ]);
    }

    public function singleTakenExam($studentexam)
    {
        // return $studentexam = StudentExam::where('id',$studentexam)->with('studentsexamsanswer.questions')->get();
        return inertia('Admin/Exam/SingleTakenExam',[
            'message'=>'Single Taken Exams',
            'datum'=> $studentexam = StudentExam::where('id',$studentexam)->with('studentsexamsanswer.questions')->get(),
            'count' => $studentexam->count(),
        ]);
    }

    public function takenExams(Exam $exam)
    {
        $studentexam = StudentExam::where('exam_id',$exam->id)->with('student.user')->get();
        return inertia('Admin/Exam/TakenExams',[
            'message'=>'Taken Exams',
            'datum'=> $studentexam,
            'count' => $studentexam->count(),
        ]);
    }

    public function addQuestion(Request $request, Exam $exam)
    {
        // dd($request->all());
    
        DB::beginTransaction();
    
        try {
            if ($request->hasFile('image')) {
                foreach ($request->file('image') as $file) {
                    $fileName = Str::random(16) . '.' . $file->getClientOriginalExtension();
                    $file->storeAs('questions', $fileName, 'public');
    
                    $exam->questions()->save(
                        new Question([
                            'question' => $request->question,
                            'question_type' => (bool) ($request->input('question_type') ?? false),
                            'option_a' => $request->option_a,
                            'option_b' => $request->option_b,
                            'option_c' => $request->option_c,
                            'option_d' => $request->option_d,
                            'option_e' => $request->option_e,
                            'option_f' => $request->option_f,
                            'video' => $request->video,
                            'audio' => $request->audio,
                            'answer' => $request->answer,
                            'codes' => $request->codes,
                            'explanation' => $request->explanation,
                            'photo' => $fileName,
                        ])
                    );
                }
            } else {
                $exam->questions()->save(
                    new Question([
                        'question' => $request->question,
                        'question_type' => (bool) ($request->input('question_type') ?? false),
                        'option_a' => $request->option_a,
                        'option_b' => $request->option_b,
                        'option_c' => $request->option_c,
                        'option_d' => $request->option_d,
                        'option_e' => $request->option_e,
                        'option_f' => $request->option_f,
                        'video' => $request->video,
                        'audio' => $request->audio,
                        'answer' => $request->answer,
                        'codes' => $request->codes,
                        'explanation' => $request->explanation,
                    ])
                );
            }
    
            DB::commit();
            return redirect()->back()->with('success', 'Question was added!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'There was an error adding the question: ' . $e->getMessage());
        }
    }

    public function updateQuestion(Request $request, Question $question)
    {
        
        DB::beginTransaction();

        try {
            
            if ($request->hasFile('image')) {
                foreach ($request->file('image') as $file) {
                    $fileName = Str::random(16) . '.' . $file->getClientOriginalExtension();
                    $file->storeAs('questions', $fileName, 'public');
                    $question->photo = $fileName;
                }
            }

            // Update the question with new data
            $question->question = $request->question;
            $question->question_type = (bool) ($request->input('question_type') ?? false);
            $question->option_a = $request->option_a;
            $question->option_b = $request->option_b;
            $question->option_c = $request->option_c;
            $question->option_d = $request->option_d;
            $question->option_e = $request->option_e;
            $question->option_f = $request->option_f;
            $question->video = $request->video;
            $question->audio = $request->audio;
            $question->answer = $request->answer;
            $question->codes = $request->codes;
            $question->explanation = $request->explanation;

            // Save the updated question
            $question->save();

            DB::commit();
            return redirect()->back()->with('success', 'Question was updated!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'There was an error updating the question: ' . $e->getMessage());
        }
    }
 
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // 
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function getTime()
    {
        return now()->toTimeString();
    }


    public function category()
    {

        return inertia('Admin/Category/Category',[
            'message'=>'Welcome Category',
            'categories'=> Category::query()->paginate(9)->withQueryString(),
        ]);
    }
    public function subCategory(Category $category)
    {
        return inertia('Admin/Category/SubCategory',[
            'message'=>'Welcome SubCategory',
            'category'=> $category,
            'subcategories'=> $category->subcategory()->paginate(9)->withQueryString(),
        ]);
    }

    public function addSubCategory(Category $category, Request $request)
    {
        $category->subcategory()->save(new SubCategory([
            'name' => $request->name,
            'description' => $request->description,
        ]));
        
        return redirect()->back();
    }

    public function addCategory(Request $request)
    {
        if ($request->hasFile('image')) {
            foreach ($request->file('image') as $file) {
                $fileName = time().'.'.$file->getClientOriginalExtension();
                
                $path = $file->storeAs('categories', $fileName, 'public');

                $category = new Category;
                $category->name = $request->name;
                $category->description = $request->description;
                $category->image = $fileName;
                $category->seo = json_encode([$request->name, $request->description, "Sitename"]);
                $category->slug = Str::slug($request->name);
                $category->save();
            }
        }
        // $request->validate([
        //     'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        // ]);

        
        return redirect()->back();
        // dd($request->all());
    }

    public function deactivateCategory(Category $category)
    {
        $check = Listing::where('category_id',$category->id)->first();
        if(empty($check)){
            $category->status = 1;
            $category->save();
            return redirect()->back()->with('success', $category->name. ' was De-activated!');
        }else{
            return redirect()->back()->with('error', 'Delete all listings under '.$category->name .' to proceed!');
        }  
    }

    public function deleteCategory(Category $category)
    {
        $check = Listing::where('category_id',$category->id)->first();
        if(empty($check)){
            if ($category->image) {
                Storage::disk('public')->delete('categories/' . $category->image);
            }
            // Delete the category
            $category->delete();
            return redirect()->back()->with('success', $category->name. ' was deleted!');
        }else{
            return redirect()->back()->with('error', 'Delete all listings under '.$category->name .' to proceed!');
        } 
        
    }

    public function deleteSubCategory(SubCategory $subcategory)
    {
        $check = Listing::where('sub_category_id',$subcategory->id)->first();
        if(empty($check)){
            if ($subcategory->image) {
                Storage::disk('public')->delete('categories/subcategories' . $category->image);
            }
            // Delete the category
            $subcategory->delete();
            return redirect()->back()->with('success', $subcategory->name. ' was deleted!');
        }else{
            return redirect()->back()->with('error', 'Delete all listings under '.$subcategory->name .' to proceed!');
        } 
        
    }

    public function updateCategory(Request $request, Category $category)
    {
        

        $category->name = $request->name;
        $category->description = $request->description;
        if ($request->hasFile('image')) {
            $uploadedImage = $request->file('image')[0];
            $fileName = time().'.'.$uploadedImage->getClientOriginalExtension();  
            $path = $uploadedImage->storeAs('categories', $fileName, 'public');
            $category->image = $fileName;
        }
        $category->seo = json_encode([$request->name, $request->description, "Sitename"]);
        $category->slug = Str::slug($request->name);
        $category->save();

        return redirect()->back();
        
    }

    public function updateSubCategory(Request $request, SubCategory $subcategory)
    {
        

        $subcategory->name = $request->name;
        $subcategory->description = $request->description;
        if ($request->hasFile('image')) {
            $uploadedImage = $request->file('image')[0];
            $fileName = time().'.'.$uploadedImage->getClientOriginalExtension();  
            $path = $uploadedImage->storeAs('categories', $fileName, 'public');
            $subcategory->image = $fileName;
        }
        $subcategory->seo = json_encode([$request->name, $request->description, "Sitename"]);
        $subcategory->slug = Str::slug($request->name);
        $subcategory->save();

        return redirect()->back();
        
    }

  
    public function listings(Request $request)
    {
        $filters = [
            'pending' => $request->boolean('pending'),
            'deleted' => $request->boolean('deleted'),
            'by' => $request->input('by'),
            'order' => $request->input('order'),
        ];

        $listings = Listing::latest()->with('owner','images')
        ->filter($filters)
        ->paginate(9)
        ->withQueryString()
        ->tap(function ($listings) {
            $listings->each(function ($listing) {
                $listing->images->each(function ($image) {
                    $image->filename = asset("storage/listings/{$image->filename}");
                });
            });
        });

        return inertia('Admin/Listing/All',[
            'message'=>'My listings',
            'filters' => $filters,
            'listings' => $listings,
        ]);
    }

   

    // comeback
    public function approveListing(Listing $listing)
    {
        $listing->deleteOrFail();
        return redirect()->back()->with('success', 'Listing was Un-Published!');
    }

    public function newListing()
    {
        return inertia('Admin/Listing/NewProduct',['message'=>'Welcome Listing']);
    }

    public function editListing(Listing $listing)
    {
        return inertia('Admin/Listing/Edit',
        [
            'message' => 'Edit Listing',
            'listing' => $listing,
        ]);
    }

    public function createListing(Request $request, ListingService $listingService)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'price' => 'required',
            'weight' => 'required',
            'quantity' => 'required',
            'category_id' => 'required',
            'sub_category_id' => 'required',
            'image' => 'required',
            // 'image.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // dd($request->all());

        $listing = $listingService->createListing($request->all());

        return redirect()->back();
    }

    public function createCourse(Request $request, CourseService $courseService)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'price' => 'required',
            'duration' => 'required',
            'school_class_id' => 'required',
            'image' => 'required',
            // 'image.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // dd($request->all());

        $listing = $courseService->createListing($request->all());

        return redirect()->back();
    }

     /**
     * deactivate Listing
     *
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function deactivateListing(Listing $listing)
    {
        $listing->status = 0;
        $listing->save();
        return redirect()->back()->with('success', 'Listing was Deactivated!');
    }
     /**
     * activate Listing.
     *
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function activateListing(Listing $listing)
    {
        $listing->status = 1;
        $listing->save();
        return redirect()->back()->with('success', 'Listing was Activated!');
    }

}
