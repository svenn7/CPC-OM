<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Violation;
use App\Models\Report;
use Illuminate\Validation\Rule;

class ViolationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $violations = Violation::where('status', 1)->orderBy('updated_at', 'desc')->get();
        return view('admin.violations')->with('violations', $violations);
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
        $request->validate([
            'violation' => [
                'required',
                'string',
                'max:255',
                Rule::unique('violations', 'violation')
                    ->where(function ($query) {
                        // Ignore violations with a status of 0
                        $query->where('status', '!=', 0);
                    })
                    ->ignore($request->id),
            ],
        ], [
            'violation.unique' => 'Violation already exists!',
        ]);

        Violation::updateOrCreate(['id' => $request->id], $request->all());

        return redirect()->back()->with('flash_message', 'Violation Successfully Added!');
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
    // In ViolationController.php

    public function edit(Violation $violation)
    {
        $violation = Violation::find($id);
        return view('admin.edit')->with('violations', $violation);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Violation $violation)
    {
        $violation->violation = $request->input('violation');
        $violation->save();

        return redirect('/admin/violations')->with('flash_message', 'Violation updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Violation $violation)
    {
        $reportCount = Report::where('violation_id', $violation->id)->count();

        if ($reportCount > 0) {
            return redirect('/admin/violations')->with('error_message', 'Cannot delete violation. It is associated with existing reports.');
        }

        // Update the status to 0 instead of deleting
        $violation->update(['status' => 0]);

        return redirect('/admin/violations')->with('flash_message', 'Violation status deleted successfully');
    }
}
