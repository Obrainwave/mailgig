<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str;

use App\Models\User;

class AccountController extends Controller
{
    public function dashboard()
    {
        try 
        {
            
            return view('user.dashboard');
        } catch (\Exception $e)
        {
            return redirect()->back()->with('danger', $e->getMessage());
        }
    }
}
