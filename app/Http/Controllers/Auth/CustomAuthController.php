<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Cookie;

class CustomAuthController extends Controller
{

    public function __construct()
    {
//        $this->middleware('guest');
    }

    public function login()
    {
        if (Request::isMethod('post'))
            return $this->checkLogin();

        if (Auth::user()) {
            return redirect('/back');
        }

        $view = 'auth.login';

        if (strpos(url()->previous(), '/back') != 0) {
            session()->put('backUrl', url()->previous());
        } else {
            session()->put('backUrl', url('/back'));
        }

        return view($view, get_defined_vars());
    }

    public function register()
    {

        if (Request::isMethod('post'))
            return $this->checkRegister();

        $admin_user = User::get();

        if (count($admin_user) != 0) {
            return redirect($this->lang()['lang'] . '/back/auth/login');
        }

        $view = 'auth.register';

        return view($view, get_defined_vars());
    }


    public function checkLogin()
    {
        $messages = array();
        $item = Validator::make(Input::all(), [
            'login' => 'required|min:3',
            'password' => 'required|min:4',
        ]);

        if ($item->fails())
            $messages = $item->messages();

        if (count($messages))
            return response()->json([
                'status' => false,
                'messages' => $messages,
            ]);

        if (!Auth::attempt(array('login' => Input::get('login'), 'password' => Input::get('password'))))
            return response()->json([
                'status' => false,
                'messages' => [Lang::get('variables.user_not_exist', array(), $this->lang()['lang'])],
            ]);

//        if (Session::has('backUrl')) {
//            return response()->json([
//                'status' => true,
//                'messages' => [Lang::get('variables.login_success_full', array(), $this->lang()['lang'])],
//                'redirect' => url(Session::get('backUrl')),
//            ]);
//        }

        return response()->json([
            'status' => true,
            'messages' => [trans('variables.login_success_full')],
            'redirect' => url('/back'),
        ]);

    }


    public function checkRegister()
    {
        $messages = array();
        $item = Validator::make(Input::all(), [
            'name' => 'required',
            'login' => 'required|min:3',
            'email' => 'required|email',
            'password' => 'required|min:4',
            'repeat_password' => 'required|same:password',
        ]);

        if ($item->fails())
            $messages = $item->messages();

        if (count($messages))
            return response()->json([
                'status' => false,
                'messages' => $messages,
            ]);

        $find_user = User::where('email', '=', Input::get('email'))->first();

        if ($find_user)
            return response()->json([
                'status' => false,
                'messages' => [Lang::get('variables.user_exist', array(), $this->lang()['lang'])],
            ]);

        User::create([
            'name' => Input::get('name'),
            'login' => Input::get('login'),
            'email' => Input::get('email'),
            'password' => bcrypt(Input::get('password')),
            'remember_token' => Input::get('_token'),
            'admin_user_group_id' => 1,

        ]);

        return response()->json([
            'status' => true,
            'messages' => [Lang::get('variables.register_success_full', array(), $this->lang()['lang'])],
            'redirect' => url($this->lang()['lang'] . '/back/auth/login'),
        ]);
    }

    public function logout()
    {
        Auth::logout();

        return redirect('/');
    }
}
