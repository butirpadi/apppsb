<?php

namespace App\Controllers;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of LoginController
 *
 * @author eries
 */
class LoginController extends \BaseController {

    public function index() {

        if (!\Auth::guest()) {
            //jika user sudah login redirect ke halaman home
            return \Redirect::to('home');
        }else{
            return \View::make('login.index');
        }
    }

    public function auth() {
        $creds = array(
            'username' => \Input::get('username'),
            'password' => \Input::get('password')
        );

        try {
            \Illuminate\Support\Facades\Auth::attempt($creds);

            //set user log session
            //$user = Toddish\Verify\Models\User::where('username', '=', \Input::get('username'))->first();
            $user = \Toddish\Verify\Models\User::where('username', \Input::get('username'))->first();

            if ($user->can('psb_access')) {
                \Session::put('onuser_id', $user->id);
                \Session::put('onusername', $user->username);
                \Session::put('islogin', true);

                return \Redirect::to('home');
            } else {
                return \Redirect::to('login\logout');
            }
        } catch (\Exception $e) {
            
            if(\Request::ajax()){
                return 'loginerror';
            }else{
                Return \Redirect::to('login')->withErrors('loginerror');  //->with('login_errors',true);
            }
            //return Response::error('404');
        }
    }

    public function logout() {
        \Illuminate\Support\Facades\Auth::logout();
        \Session::flush();
        return \Redirect::to('login');
    }

}
