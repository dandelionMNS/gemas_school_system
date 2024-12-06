<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Transaction;
use App\Models\Feetype;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
        $transaction->status = "pending";
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

    public function approve($transaction_id){
        $transaction = Transaction::find($transaction_id);
        $transaction->status = "Approved";
        $transaction->save();
        return redirect()->back()->with('success', 'Transaction Approved.');
    }

    public function reject($transaction_id){
        $transaction = Transaction::find($transaction_id);
        $transaction->status = "Rejected";
        $transaction->save();
        return redirect()->back()->with('success', 'Transaction Rejected.');
    }



}