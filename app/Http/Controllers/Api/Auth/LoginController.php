<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */
	
	public function loginForm(Request $request){
		
		$navArray = getNavbarLinks();
		
		$form_fields = [];
		
		$data_array = array();
		$section_id = 0;
		$data_array[$section_id] = array(
			'section_id' => $section_id,
			'section_title' => '',
			'section_data' => array(),
		);
		
		
		$data_array[$section_id]['section_data'] = array(
			array(
				'field_name' => 'login_pin',
				'field_type' => 'text',
				'data_type' => 'numeric',
				'order' => 0,
				'required' => true,
				'min_limit' => 6,
				'label' => 'Login Pin',
				'icon' => url('/').'/store/1/default_images/password_field.svg',
				'data' => '',
			),
			
			array(
				'field_name' => 'submit',
				'field_type' => 'button',
				'data_type' => 'submit',
				'order' => 1,
				'required' => false,
				'label' => 'Submit',
				'icon' => '',
				'data' => '',
				'target_api' => "login",
			),
		);
		
		$response = array(
			'form' => $data_array,
		);
		
        
        return apiResponse2(1, 'retrieved', trans('api.public.retrieved'), $response);
    }

    public function login(Request $request)
    {
        $rules = [
            'login_pin' => 'required|string|numeric',
        ];
		

        validateParam($request->all(), $rules);

        return $this->attemptLogin($request);

    }
	
	public function social_login(Request $request)
    {
        $rules = [
            'email' => 'required|email',
        ];
		

        validateParam($request->all(), $rules);

        return $this->attemptSocialLogin($request);

    }

    public function username()
    {
        $email_regex = "/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,})$/i";

        if (empty($this->username)) {
            $this->username = 'mobile';
            if (preg_match($email_regex, request('username', null))) {
                $this->username = 'email';
            }
        }
        return $this->username;
    }

    protected function attemptLogin(Request $request)
    {
        $credentials = [
            'login_pin' => $request->get('login_pin')
        ];


		if (!$token = auth('api')->attempt($credentials)) {
        //if (!$token = Auth::loginUsingPin($credentials)) {
            return apiResponse2(0, 'incorrect', 'Incorrect Pin code!');
        }
        return $this->afterLogged($request, $token);
    }
	
    protected function attemptSocialLogin(Request $request)
    {
		$credentials = [
            'email' => $request->get('email')
        ];

		if (!$token = auth('api')->attempt($credentials)) {
        //if (!$token = Auth::loginUsingPin($credentials)) {
            return apiResponse2(0, 'incorrect', 'Incorrect Email Address!');
        }
        return $this->afterLogged($request, $token);
    }

    public function afterLogged(Request $request, $token, $verify = false)
    {
        $user = auth('api')->user();
		
        $profile_completion = [];
        $data['token'] = $token;
        $data['user_id'] = $user->id;
        $data['life_lines'] = $user->user_life_lines;
        $data['user_avatar'] = url('/').$user->avatar;
        $data['display_name'] = (isset( $user->display_name ) && $user->display_name != '')? $user->display_name : $user->first_name.' '.$user->last_name;
		$data['game_time'] = $user->game_time;
		
        if (!$user->get_full_name()) {
            $profile_completion[] = 'full_name';
            $data['profile_completion'] = $profile_completion;
        }

        return apiResponse2(1, 'login', trans('auth.login'), $data);


    }

    public function logout()
    {
        auth('api')->logout();
        if (!apiAuth()) {
            return apiResponse2(1, 'logout', trans('auth.logout'));
        }
        return apiResponse2(0, 'failed', trans('auth.logout.failed'));
    }


}
