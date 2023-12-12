<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use App\Models\User;
use App\Models\Officers;
use App\Models\Students;

class AccountsController extends Controller
{
    public function index()
    {
        $activeOfficers = Officers::where('status', 1)->orderBy('created_at', 'desc')->get();
        $inactiveOfficers = Officers::where('status', 0)->orderBy('created_at', 'desc')->get();

        return view('/admin/officers', ['officers' => $activeOfficers, 'inactiveOfficers' => $inactiveOfficers]);
    }

    public function promoteStudent(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id_no',
        ]);

        $student = Students::where('id_no', $request->input('student_id'))->first();

        if (!$student) {
            return redirect()->back()->with('error', 'No student found with this ID number');
        }

        $existingOfficer = Officers::where('id_no', substr($student->id_no, -4))->first();

        if ($existingOfficer) {
            return redirect()->back()->with('error', 'This student is already an Officer');
        }

        $existingUser = User::where('id_no', substr($student->id_no, -4))->first();

        if ($existingUser) {
            return redirect()->back()->with('error', 'User already exists for this student');
        }

        // Check if the student is already an officer
        $existingPromotion = Officers::where('id_no', $student->id_no)->first();

        if ($existingPromotion) {
            return redirect('/admin/officers')->with('error', 'This student is already promoted to an officer');
        }

        $officer = Officers::create([
            'id_no' => substr($student->id_no, -4),
            'fname' => $student->fname,
            'mname' => $student->mname,
            'lname' => $student->lname,
            'gender' => $student->gender,
            'mobile' => $student->mobile,
            'birthdate' => $student->birthdate,
            'position' => 'Student',
            'email' => $student->email,
            'address' => $student->address,
            'profile_picture' => $student->profile_picture,
        ]);

        $user = User::create([
            'id_no' => substr($student->id_no, -4),
            'password' => Hash::make($student->lname),
            'officer_id' => $officer->id,
            'role' => 'officer',
        ]);

        return redirect('/admin/officers')->with('flash_message', 'Student promoted to officer successfully');
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_no' => 'required|numeric|unique:officers,id_no',
            'fname' => 'required|string|max:255',
            'mname' => 'nullable|string|max:255',
            'lname' => 'required|string|max:255',
            'gender' => 'required|in:male,female',
            'mobile' => 'required|numeric|string|digits:11',
            'birthdate' => 'required|date',
            'position' => 'required',
            'email' => 'required|email|unique:officers,email',
            'address' => 'nullable|string',
        ]);

        $officer = Officers::create([
            'id_no' => $request->input('id_no'),
            'fname' => $request->input('fname'),
            'mname' => $request->input('mname'),
            'lname' => $request->input('lname'),
            'gender' => $request->input('gender'),
            'mobile' => $request->input('mobile'),
            'birthdate' => $request->input('birthdate'),
            'position' => $request->input('position'),
            'email' => $request->input('email'),
            'address' => $request->input('address'),
        ]);

        $user = User::create([
            'id_no' => $officer->id_no,
            'password' => Hash::make($officer->lname),
            'officer_id' => $officer->id,
            'role' => 'officer',
        ]);

        return redirect('/admin/officers')->with('flash_message', 'Officer Successfully Added');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'id_no' => 'required|numeric',
            'fname' => 'required|string|max:255',
            'mname' => 'nullable|string|max:255',
            'lname' => 'required|string|max:255',
            'gender' => 'required|in:male,female',
            'mobile' => 'required|numeric|digits:11',
            'birthdate' => 'required|date',
            'position' => 'required',
            'email' => [
                'required',
                'email',
                Rule::unique('students')->ignore($id),
            ],
            'address' => 'required|string',
        ]);

        $officer = Officers::find($id);

        $originalAttributes = $officer->getOriginal();

        if ($originalAttributes != $request->all()) {
            $officer->update($request->all());
            return back()->with('flash_message', 'Student updated successfully');
        } else {
            return back()->with('flash_message', 'No changes detected.');
        }
    }

    public function restore($id)
    {
        $officer = Officers::find($id);

        if (!$officer) {
            return redirect('/admin/officers')->with('error_message', 'Officer not found');
        }

        // Check if officer has a user
        if ($officer->user) {
            // Update the user's status to 1 to restore
            $officer->user->update(['status' => 1]);
        }

        // Update the officer's status to 1 to restore
        $officer->update(['status' => 1]);

        return redirect('/admin/officers')->with('flash_message', 'Officer restored successfully');
    }

    public function destroy($id)
    {
        $officer = Officers::find($id);

        if (!$officer) {
            return redirect('/admin/officers')->with('error_message', 'Officer not found');
        }

        if ($officer->user) {
            $officer->user->update(['status' => 0]);
        }

        $officer->update(['status' => 0]);

        return redirect('/admin/officers')->with('flash_message', 'Officer removed successfully');
    }
}
