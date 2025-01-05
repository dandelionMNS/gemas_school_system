<?php

namespace App\Http\Controllers;

use App\Models\Parentt;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Classes;
use App\Models\FeeType;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;

use Barryvdh\DomPDF\Facade\Pdf;


class StudentController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $students = Student::query()
            ->when($search, function ($query, $search) {
                $query->where('name', 'like', "%{$search}%");
            })
            ->with('class')
            ->get();

        $teachers = Teacher::all();
        $classes = Classes::all();

        return view("pages.stud_list", compact('students', 'teachers', 'classes', 'search'));
    }

    public function class_teach(Request $request)
    {
        $search = $request->input('search');
    
        $students = Student::query()
            ->when($search, function ($query, $search) {
                $query->where('name', 'like', "%{$search}%");
            })
            ->with('class')
            ->get();
    
        $teacher = Teacher::where('user_id', Auth::id())->first();
        $class_teaches  = Classes::where('teacher_id', $teacher->id)->get();
        $feetypes = FeeType::all();
    
        return view("pages.teached_class", compact('students', 'teacher', 'feetypes', 'class_teaches', 'search'));
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

    public function print_record($id)
    {
        $student = Student::find($id);
        $class = Classes::find($student->class_id);
        $parent = User::find(Parentt::find($student->parent_id)?->user_id);
        $feetypes = FeeType::all();
        $transactions = Transaction::where('student_id', $id)->get();


        // Generate the PDF using the blade view
        $pdf = Pdf::loadView('print.stud_record', [
            'class' => $class,
            'student' => $student,
            'parent' => $parent,
            'feetypes' => $feetypes,
            'transactions' => $transactions,
        ]);

        // Download the PDF file
        return $pdf->download("student_record?id={$student->id}.pdf");
    }


}
