<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MapController extends Controller
{
    protected $user;

    function __construct(User $user)
    {
        $this->user = $user;
    }

    public function index()
    {
        $data['title'] = 'View Map';
        $data['onMap'] = 1;
        switch (session('type'))
        {
            case 'admin':
                $data['username'] = Auth::user()->username;
                $data['type'] = Auth::user()->type;
                $data['template'] = 'templates.admin_template';
                break;
            case 'user':
                $data['username'] = Auth::user()->username;
                $data['type'] = Auth::user()->type;
                $data['template'] = 'templates.user_template';
                break;
            default:
                $data['template'] = 'templates.public_template';
                break;
        }
        return view('public.view_map', $data);
    }
}