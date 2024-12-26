<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ReminderMail;

class MailController extends Controller
{
    public function send()
    {
        Mail::to('example@example.com')->send(new ReminderMail());
        return view('welcome');
    }

    public function send2()
    {
        Mail::to('example@example.com')->send(new ReminderMail());

        return view("pages.class_list", compact("classes", "teachers"));

    }
}
