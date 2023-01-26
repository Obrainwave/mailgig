<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\EmailRequest;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str;

use App\Models\User;
use App\Services\EmailService;

class EmailController extends Controller
{
    /**
     * @var EmailService
     */
    protected $emailService;

    /**
     * EmailController constructor
     * 
     * @param EmailService $email
     */
    public function __construct(EmailService $emailService)
    {
        $this->emailService = $emailService;
    }


    public function allEmailAccount()
    {
        try 
        {
            $emails = $this->emailService->getAll();
            return view('user.mail.emailaccounts', compact('emails'));
        } catch (\Exception $e)
        {
            dd($e);
            return redirect()->back()->with('danger', $e->getMessage());
        }
    }


    public function saveEmailAccount(Request $request)
    {
        try 
        {
            // dd($request->all());
            $this->validate($request, [
                'name' => 'required|string|max:100',
                'email' => 'required|string|email|max:255|unique:email_accounts',
                'company_name' => 'nullable|string|max:100',
                'account_type' => 'required|digits_between:0,1',
                'status' => 'nullable|boolean',
            ]);

            $user_id = Auth::user()->id;

            $data = $request->except(['_token']);
            $data['user_id'] = $user_id;

            $this->emailService->saveEmail($data);
            
            return redirect()->back()->with('success', 'Email Account created successfully');
        } catch (ValidationException $e)
        {
            // dd($e->validator->errors()->first());
            return redirect()->back()->with('danger', $e->validator->errors()->first())->withInput();
        } catch (\Exception $e)
        {
            // dd($e);
            return redirect()->back()->with('danger', $e->getMessage())->withInput();
        }
    }


    public function sentMail(Request $request)
    {
        try 
        {
            
            return view('user.mail.sentmail');
        } catch (\Exception $e)
        {
            return redirect()->back()->with('danger', $e->getMessage());
        }
    }

    
    public function sendMail()
    {
        try 
        {
            
            return view('user.mail.sendmail');
        } catch (\Exception $e)
        {
            return redirect()->back()->with('danger', $e->getMessage());
        }
    }
}
