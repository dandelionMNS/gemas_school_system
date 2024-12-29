<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Transaction;
use App\Models\Classes;
use App\Models\Feetype;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;

class TransactionController extends Controller
{
    public function addPage($student_id, $feetype_id)
    {
        $feetype = Feetype::find($feetype_id);
        $student = Student::find($student_id);
        return view("pages.transaction_create", compact("feetype", "student"));
    }

    public function create(Request $request)
    {
        $request->validate([
            'student_id' => 'required|integer',
            'feetype_id' => 'required|integer',
            'receipt' => 'required|file|mimes:pdf,zip,jpg,jpeg,png|max:20480' // Limit file size to 2MB
        ]);

        $transaction = new Transaction();
        $transaction->student_id = $request->input('student_id');
        $transaction->feetype_id = $request->input('feetype_id');
        $transaction->ref_url = "pending...";
        $transaction->status = "Belum Diproses";
        $transaction->save();

        if ($request->hasFile('receipt')) {
            $file = $request->file('receipt');

            $dateTime = Carbon::now()->format('YmdHis');
            $studentId = $transaction->student_id;
            $transactionId = $transaction->id;
            $fileExtension = $file->getClientOriginalExtension();
            $fileName = "{$dateTime}_{$studentId}_{$transactionId}.{$fileExtension}";

            $filePath = "receipts/{$fileName}";
            Storage::putFileAs('receipts', $file, $fileName);

            $transaction->ref_url = $filePath;
            $transaction->save();
        }

        return redirect()->route('student.details', ['id' => $transaction->student_id])
            ->with('success', 'Transaction created and receipt uploaded successfully.');
    }

    public function download($encodedPath)
    {
        $filePath = base64_decode($encodedPath);

        if (Storage::exists($filePath)) {
            return Storage::download($filePath);
        }
        return redirect()->back()->with('error', 'File not found.');
    }

    public function destroy($transaction_id)
    {
        $transaction = Transaction::find($transaction_id);

        if (!$transaction) {
            return redirect()->back()->with('error', 'Transaction not found.');
        }

        $filePath = $transaction->ref_url;
        if ($filePath && Storage::exists($filePath)) {
            Storage::delete($filePath);
        }

        $transaction->delete();
        return redirect()->back()->with('success', 'Transaction Deleted.');
    }

    public function approve($transaction_id)
    {
        $transaction = Transaction::find($transaction_id);
        $transaction->status = "Diluluskan";
        $transaction->save();
        return redirect()->back()->with('success', 'Transaction Approved.');
    }

    public function reject($transaction_id)
    {
        $transaction = Transaction::find($transaction_id);
        $transaction->status = "Ditolak";
        $transaction->save();
        return redirect()->back()->with('success', 'Transaction Rejected.');
    }

    // ================== [ Monthly Record ] ==================


    public function record_index()
    {
        $classes = Classes::all();
        $current = date('Y-m');

        return view('pages.record', compact('classes', 'current' ));
    }

    public function record_find(Request $request)
    {
        $class_id = $request->input('class_id');
        $month = $request->input('month');

        $query = Transaction::query();

        if ($class_id !== 'all') {
            $query->whereHas('student', function ($query) use ($class_id) {
                $query->where('class_id', $class_id);
            });
        }

        $transactions = $query->whereYear('created_at', substr($month, 0, 4))
            ->whereMonth('created_at', substr($month, 5, 2))
            ->get();

        $classes = Classes::all();
        $current = $month;

        return view('pages.record', compact('transactions', 'classes', 'class_id', 'current'));
    }

    // Checkpoint

    public function print_record(Request $request)
    {
        $class_id = $request->input('class_id', 'all');

        $month = $request->input('month');

        $query = Transaction::query();

        if ($class_id !== 'all') {
            $query->whereHas('student', function ($query) use ($class_id) {
                $query->where('class_id', $class_id);
            });
        }

        $transactions = $query->whereYear('created_at', substr($month, 0, 4))
            ->whereMonth('created_at', substr($month, 5, 2))
            ->get();

        if ($class_id != 'all') {
            $class = Classes::find($class_id);
        } else {
            $class = (object) [
                'grade_lvl' => '-',
                'name' => '', 
            ];
        }
        // Generate the PDF using the blade view
        $pdf = Pdf::loadView('pages.record_print', [
            'transactions' => $transactions,
            'class' => $class,
            'month' => $month,
        ]);

        // Download the PDF file
        return $pdf->download('monthly_records_' . $month . '.pdf');
    }

}