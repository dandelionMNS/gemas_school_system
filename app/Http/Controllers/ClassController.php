<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\User;
use App\Models\Classes;

class ClassController extends Controller
{
    public function index()
    {
        $classes = Classes::all();
        $teachers = User::where("type", "teacher")->get();
        return view("pages.class_list", compact("classes", "teachers"));
        // return redirect()->route("user.index")->with(compact("users"));
    }

    public function create(Request $request)
    {
        $class = new Classes();
        $class->grade_lvl = $request->input("grade_lvl");
        $class->name = $request->input("name");
        $class->teacher_id = $request->input("teacher_id");
        $class->save();


        return redirect()->back()->with("success", "");
    }

    public function update(Request $request, $id)
    {
        $class = Classes::findOrFail($id);
        $class->name = $request->input('name');
        $class->teacher_id = $request->input('teacher_id');
        $class->grade_lvl = $request->input('grade_lvl');
        $class->save();


        return redirect()->back()->with("success", "");
    }

    public function delete($id)
    {
        $course = Classes::findOrFail($id);
        $course->delete();

        return redirect()->back()->with("success", "");
    }
}
