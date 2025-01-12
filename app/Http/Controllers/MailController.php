<?php

namespace App\Http\Controllers;

use App\Models\Feetype;
use App\Models\Student;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ReminderMail;

use App\Models\Parentt;


class MailController extends Controller
{

    public function sendReminders(Request $request)
    {
        $parent_id = $request->parent_id;
       
        $students = Student::where('parent_id', $parent_id)->get();
        $parent = Parentt::findOrFail($parent_id);

        $unpaidFees = [];

        foreach ($students as $student) {
            $unpaidFees[$student->id] = [];
            $feetypes = Feetype::where('grade_lvl', $student->class->grade_lvl)->orWhere('grade_lvl', 'all')->get();
            foreach ($feetypes as $feetype) {
                $transaction = Transaction::where('student_id', $student->id)
                    ->where('feetype_id', $feetype->id)
                    ->where('status', 'Diluluskan')
                    ->first();

                if (!$transaction) {
                    $unpaidFees[$student->id][] = $feetype->id;
                }
            }

            if (empty($unpaidFees[$student->id])) {
                unset($unpaidFees[$student->id]);
            }
        }


        if (!empty($unpaidFees)) {
            Mail::to($parent->user->email)->send(new ReminderMail($parent, $unpaidFees));
            return redirect()->back()->with("success", "");
            // return response()->json(['message' => 'Reminders sent successfully.']);
        }
        return redirect()->back()->with("failed", "");
        // return response()->json(['message' => 'No unpaid fees found.']);
    }


}
