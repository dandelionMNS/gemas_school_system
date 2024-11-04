<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view("pages.user_list", compact("users"));
        // return redirect()->route("user.index")->with(compact("users"));
    }

    public function updateType(Request $request, $id){
        $user = User::findOrFail($id);
        $user->type = $request->input('type');
        $user->save();
        return redirect()->back()->with("success","");
    }
}
    