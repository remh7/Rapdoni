<?php

namespace App\Http\Controllers;
use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function create(){
        return view('contact');
    }
    public function store(Request $request){
     $validated = $request->validate([
       'name'=>'required|string|max:255',
       'email'=>'required|email',
       'message'=>'required|string|min:10'
     ]);

     Contact::create($validated);
     return back()->with('success','پیام شما با موفقیت ثبت شد');
    }
}
