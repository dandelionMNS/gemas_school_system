<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests; 
use App\Models\Feetype;

class FeeTypeController extends Controller
{
    public function index()
    {
        $feetypes = Feetype::all(); 
        return view("pages.feetype_list", compact("feetypes"));
    }

    public function create(Request $request)
    {
        $feetype = new Feetype();
        $feetype->name = $request->input("name");
        $feetype->amount = $request->input("amount");
        $feetype->due = $request->input("due");
        $feetype->save();

        return redirect()->back()->with("success", "");
    }

    public function update(Request $request, $id)
    {
        $feetype = Feetype::findOrFail($id);
        $feetype->name = $request->input('name');
        $feetype->amount = $request->input("amount");
        $feetype->due = $request->input("due");
        $feetype->save();

        return redirect()->back()->with("success", "");
    }

    public function delete($id)
    {
        $feetype = Feetype::findOrFail($id);
        $feetype->delete();

        return redirect()->back()->with("success", "");
    }
}
