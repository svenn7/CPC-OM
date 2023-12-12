<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Students;
use App\Models\Report;
use App\Models\User;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class StudentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $students = Students::where('status', 1)->orderBy('updated_at', 'desc')->get();
        return view('admin.students')->with('students', $students);
    }


    public function studentIndex()
    {
        $students = Students::orderBy('updated_at', 'desc')->get();
        return view('student.dashboard')->with('students', $students);
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

    public function changePassword(Request $request)
    {
        // Validation rules
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|different:current_password',
            'confirm_new_password' => 'required|same:new_password',
        ]);

        $user = Auth::user();
        if (!Hash::check($request->input('current_password'), $user->password)) {
            return redirect()->back()->withErrors(['current_password' => 'The current password is incorrect.']);
        }

        $user->password = bcrypt($request->input('new_password'));
        $user->save();

        return redirect()->back()->with('flash_message', 'Password changed successfully.');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_no' => 'required|numeric|digits:8|unique:users,id_no',
            'fname' => 'required|string|max:255',
            'mname' => 'nullable|string|max:255',
            'lname' => 'required|string|max:255',
            'gender' => 'required|in:male,female',
            'mobile' => 'required|numeric|string|digits:11',
            'birthdate' => 'required|date',
            'email' => 'required|email|unique:students,email',
            'course' => 'required|string|in:BSIT,BSHM,BSED,BEED',
            'year' => 'required|integer|in:1,2,3,4',
            'section' => 'required|string|in:A,B,C,D,E',
            'address' => 'nullable|string',
        ]);

        $student = Students::create([
            'id_no' => $request->input('id_no'),
            'fname' => $request->input('fname'),
            'mname' => $request->input('mname'),
            'lname' => $request->input('lname'),
            'gender' => $request->input('gender'),
            'mobile' => $request->input('mobile'),
            'birthdate' => $request->input('birthdate'),
            'email' => $request->input('email'),
            'course' => $request->input('course'),
            'year' => $request->input('year'),
            'section' => $request->input('section'),
            'address' => $request->input('address'),
        ]);

        $user = User::create([
            'id_no' => $student->id_no,
            'password' => Hash::make($student->lname),
            'stud_id' => $student->id
        ]);

        return redirect()->back()->with('flash_message', 'Student successfully added!');
    }

    public function updateProfilePicture(Request $request, $id)
    {
        // Find the student by ID
        $student = Students::find($id);

        // Check if the student exists
        if (!$student) {
            return redirect()->back()->with('error', 'Student not found');
        }

        // Check if a new profile picture file is uploaded
        if ($request->hasFile('profile_picture')) {
            // Get the uploaded file
            $file = $request->file('profile_picture');

            // Generate a unique filename based on the current timestamp and original file name
            $fileName = time() . '_' . $file->getClientOriginalName();

            // Store the file in the public/profile_pictures directory
            $file->storeAs('profile_pictures', $fileName, 'public');

            // Delete the old profile picture if it exists
            if ($student->profile_picture) {
                // Use Storage facade to delete the old file
                Storage::disk('public')->delete('profile_pictures/' . $student->profile_picture);
            }

            // Update the student's profile_picture attribute with the new filename
            $student->update(['profile_picture' => $fileName]);

            // Redirect back with a success message
            return redirect()->back()->with('flash_message', 'Profile picture updated successfully');
        } else {
            // Handle the case when no file is uploaded
            // You may want to consider whether you want to delete the existing profile picture in this case

            // Redirect back with an error message
            return redirect()->back()->with('error', 'No file uploaded');
        }
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
    // StudentsController.php
    public function edit($id)
    {
        $student = Students::find($id);
        return view('admin.edit')->with('student', $student);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // StudentsController.php
    public function update(Request $request, $id)
    {
        $request->validate([
            'id_no' => 'required|numeric|digits:8',
            'fname' => 'required|string|max:255',
            'mname' => 'nullable|string|max:255',
            'lname' => 'required|string|max:255',
            'gender' => 'required|in:male,female',
            'mobile' => 'required|numeric|digits:11',
            'birthdate' => 'required|date',
            'email' => [
                'required',
                'email',
                Rule::unique('students')->ignore($id),
            ],
            'course' => 'required|string|in:BSIT,BSHM,BSED,BEED',
            'year' => 'required|integer|in:1,2,3,4',
            'section' => 'required|string|in:A,B,C,D,E',
            'address' => 'required|string',
        ]);

        $student = Students::find($id);

        $originalAttributes = $student->getOriginal();

        if ($originalAttributes != $request->all()) {
            $student->update($request->all());
            return back()->with('flash_message', 'Student updated successfully');
        } else {
            return back()->with('flash_message', 'No changes detected.');
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $student = Students::find($id);

        if (!$student) {
            return redirect('/admin/students')->with('error_message', 'Student not found');
        }

        $reportCount = Report::where('student_id', $student->id)->count();

        if ($reportCount > 0) {
            return redirect('/admin/students')->with('error_message', 'Cannot delete student. It is associated with existing reports.');
        }

        if ($student->user) {
            $student->user->update(['status' => 0]);
        }

        $student->update(['status' => 0]);

        return redirect('/admin/students')->with('flash_message', 'Student deleted successfully');
    }
}
