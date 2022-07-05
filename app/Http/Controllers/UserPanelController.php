<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserPanelController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $data['user'] = Auth::user();
        $data['details'] = $data['user']->details;
        $data['clients'] = $data['user']->clients;
        $data['banks'] = $data['user']->banks;

        return view('user.index', $data);
    }
}
