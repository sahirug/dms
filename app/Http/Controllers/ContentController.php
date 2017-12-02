<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ContentController extends Controller
{
    public function publicHome(Request $request){
        $data = [];
        $data['home'] = 1;
        $data['title'] = 'Home';
        if($request->session()->has('type')){
            switch ($this->getUserType()){
                case 'admin':
                    return redirect()->route('admin_home');
                case 'user':
                    return redirect()->route('user_home');
            }
        }
        return view('public.home', $data);
    }

    public function userHome(){
        $data = [];
        $data['username'] = $this->getUsername();
        $data['type'] = $this->getUserType();
        $data['home'] = 1;
        $data['title'] = 'Home';
        if(session()->has('status')){
            $data['status'] = session()->pull('status');
        }
        return view('user.home', $data);
    }

    public function adminHome(){
        $data = [];
        $data['username'] = $this->getUsername();
        $data['type'] = $this->getUserType();
        $data['home'] = 1;
        $data['title'] = 'Home';
        if(session()->has('status')){
            $data['status'] = session()->pull('status');
        }
        return view('admin.home', $data);
    }

    public function getUsername(){
        return session('username');
    }

    public function getUserType(){
        return session('type');
    }
}
