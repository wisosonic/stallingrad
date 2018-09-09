<?php

namespace App\Http\Controllers\Auth;

use Hash;
use Session ;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;

class RegisterController extends Controller
{


    use RegistersUsers;


    protected $redirectTo = '/';

    public function __construct()
    {
        $this->middleware('guest');
    }

    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $this->validator($request->all())->validate();
        
        $data = $request->all();
        array_shift($data);
        unset($data["email_confirmation"]);
        unset($data["password_confirmation"]);

        $user = new User();
        $user->email = $data['email'];
        $user->password = Hash::make($data["password"]);
        $user->fname = $data['fname'];
        $user->lname = $data['lname'];
        $user->save();

        $this->guard()->login($user);

        return redirect()->intended($this->redirectPath())->with(["accountcreated"=>"accountcreated"]);

    }
    
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);
    }
}
