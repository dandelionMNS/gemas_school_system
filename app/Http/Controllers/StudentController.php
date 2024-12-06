<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Classes;
use App\Models\FeeType;
use App\Models\Transaction;


class StudentController extends Controller
{
    public function index()
    {
        $students = Student::all();
        return view("dashboard", compact("students"));
    }

    public function addPage()
    {
        $classes = Classes::all()->sortBy('grade_lvl');
        return view("pages.stud_details", compact("classes", ));
    }

    public function create(Request $request)
    {
        $student = new Student();
        $student->name = $request->input("name");
        $student->class_id = $request->input("class_id");
        $student->nric = $request->input("nric");
        $student->birthday = $request->input("birthday");
        $student->birth_cert = $request->input("birth_cert");
        $student->parent_id = $request->input("parent_id");
        $student->save();

        return redirect("dashboard")->with("success", "");
    }

    public function details($id)
    {
        $classes = Classes::all()->sortBy('grade_lvl');
        $stud_details = Student::find($id);
        $feetypes = FeeType::all();
        $transactions = Transaction::where('student_id', $id)->get();
        return view("pages.stud_details", compact("classes", "stud_details", "feetypes", "transactions"));
    }

    public function update(Request $request, $id)
    {
        $student = Student::find($id);
        $student->name = $request->input("name");
        $student->class_id = $request->input("class_id");
        $student->nric = $request->input("nric");
        $student->birthday = $request->input("birthday");
        $student->birth_cert = $request->input("birth_cert");
        $student->parent_id = $request->input("parent_id");
        $student->save();

        return redirect()->back()->with("success", "");
    }

    public function destroy($id)
    {
        Student::find($id)->delete();
        return redirect("dashboard")->with("success", "");
    }

}
