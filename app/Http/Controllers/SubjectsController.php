<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subjects;
use Illuminate\Support\Facades\Auth;
//use Illuminate\Support\Facades\DB;

class SubjectsController extends Controller
{
    public function saveSubjects(Request $request)
    {
        $request->validate([
            'subtitle' => 'required',
            'subdesc' => 'required',
            'subprice' => 'required',
            'subtlh' => 'required',
        ]);

        $newSubject = new Subjects();

        $newSubject->subject_title = $request->subtitle;
        $newSubject->subject_description = $request->subdesc;
        $newSubject->subject_price = $request->subprice;
        $newSubject->subject_total_learning_hours = $request->subtlh;
        $newSubject->tutor_id = Auth::guard('tutors')->user()->id;

        $newSubject->save();
        return redirect('subjects-list')->with('save', 'Success')->withErrors('error', 'Failed');
    }
}
