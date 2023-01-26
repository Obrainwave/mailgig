<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str;

use App\Models\User;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('user_auth', ['except' => ['login']]);
    }


    public function login(Request $request)
    {
        // dd($request->all());
        if($request->isMethod('post'))
        {
            try{
                $this->validate($request, [
                    'email' => 'bail|required|email',
                    'password' => 'bail|required'
                ]);

                if ($user = Auth::attempt([
                        'email' => $request->email,
                        'password' => $request->password
                    ]))
                {
                    // dd($user);
                    $user = User::where('id', Auth::user()->id)->first();

                    // dd($user->superAdmin());

                    if(!$user->isUser())
                    {
                        $request->session()->flush();
                        Auth::logout();
                        return redirect()->back()->with('danger', 'Invalid Login Details')->withInput();
                    }

                    // dd('Here');

                    if(!$user->isActive())
                    {
                        $request->session()->flush();
                        Auth::logout();
                        return redirect()->back()->with('danger', 'Sorry! Your account is inactive')->withInput();
                    }

                    if($user->suspend())
                    {
                        $request->session()->flush();
                        Auth::logout();
                        return redirect()->back()->with('danger', 'Your account has been suspended')->withInput();
                    }

                    $user->update([
                        'last_login_at' => Carbon::now()->toDateTimeString(),
                        'last_login_ip' => \Request::getClientIp(true)
                    ]);

                    return redirect()->route('user.dashboard')->with('success', 'You have successfully logged in');
                }

                return redirect()->back()->with('danger', 'Invalid Login Details')->withInput();
            } catch (ValidationException $e)
            {
                // dd($e);
                return redirect()->back()->with('danger', $e->validator->errors()->first())->withInput();
            } catch (\Exception $e)
            {
                // dd($e);
                return redirect()->back()->with('danger', $e->getMessage())->withInput();
            }
        }else{
            try 
            {
                return view('auth.login');
            } catch (\Exception $e)
            {
                return redirect()->back()->with('danger', $e->getMessage());
            }
        }
    }


    public function requestPasswordReset(Request $request)
    {
        if($request->isMethod('POST'))
        {
            try{
                $this->validate($request, [
                    'email' => 'bail|required|email',
                ]);

                $checkuser = User::where('email', $request->email)->where('suspend', 0)->where('admin', 1)->first();
                if($checkuser)
                {
                    $token = random_int(1000000, 9999999);
                    $user = $checkuser;
                    $checktoken = PasswordReset::where('email', $user->email)->first();
                    if($checktoken)
                    {
                        $checktoken->update([
                            'email' => $user->email,
                            'token' => $token,
                        ]);
                    }else{
                        PasswordReset::create([
                            'email' => $user->email,
                            'token' => $token,
                        ]);
                    }

                    try{
                        // Mail::to($user->email)->queue(new AdminPasswordReset($user, $token, 2));
                    } catch (\Exception $e)
                    {
                        Log::info($e->getMessage());
            
                    }
                    return redirect()->back()->with('success', 'A message has been sent to your email address. Please check your email to reset your password.');
                }else{
                    return redirect()->back()->with('danger', 'Sorry! The provided email cannot be found in our system.');
                }
            } catch (ValidationException $e)
            {
                return redirect()->back()->with('danger', $e->validator->errors()->first());
            } catch (\Exception $e)
            {
                return redirect()->back()->with('danger', $e->getMessage());
            }
        }else{
            try 
            {
                return view('admin.auth.requestpasswordreset');
            } catch (\Exception $e)
            {

            }
        }
    }


    public function confirmResetPassword(Request $request, $token)
    {
        if($request->isMethod('post'))
        {
            try
            {
                $this->validate($request, [
                    'email' => 'bail|required|email',
                    'new_password' => 'bail|required|min:6',
                    'confirm_password' => 'bail|required',
                ]);

                if($request->new_password != $request->confirm_password)
                {
                    return redirect()->back()->with('danger', 'Sorry! The new password does not match the confirm password');
                    
                }

                $checktoken = PasswordReset::where('email', $request->email)
                ->where('token', $token)->first();

                if($checktoken)
                {
                    $hasher = app()->make('hash');
                    $date = Carbon::parse($checktoken->updated_at);
                    $addonehour = $date->addHour(1);
                    if($addonehour >= Carbon::now())
                    {
                        $user = User::where('email', $checktoken->email)->first();
                        $user->password = $hasher->make($request->new_password);
                        $user->save();

                        $checktoken->delete();

                        // try{
                        //     $user->notify(new ConfirmResetPassword($user));
                        // }catch (\Exception $e) {
                        //     Log::critical($e->getMessage());
                            
                        // }

                        return redirect()->route('admin.login')->with('success', 'Your password has been updated successfully.');

                    }else{
                        return redirect()->back()->with('danger', 'Invalid token');
                    }
                }else{
                    return redirect()->back()->with('danger', 'Invalid token');
                }
            } catch (ValidationException $e)
            {
                return redirect()->back()->with('danger', $e->validator->errors()->first());
            } catch (\Exception $e)
            {
                return redirect()->back()->with('danger', $e->getMessage());
            }
        }else{
            try 
            {
                return view('admin.auth.confirmpasswordreset', compact('token'));
            } catch (\Exception $e)
            {
                Log::critical($e);
                return redirect()->back()->with('danger', $e->getMessage());
            }
        }
    }
}
