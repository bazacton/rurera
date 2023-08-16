<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\UserMeta;
use App\Models\UserSubscriptions;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class ParentController extends Controller
{

    public function create_student(Request $request)
    {
        $data = $request->post();
        $locale = $data['locale'] ?? getDefaultLocale();

        $rules = [
            'full_name' => 'required',
            'email'     => 'required|email',
            'password'  => 'required',
        ];

        $validate = Validator::make($data, $rules);

        if ($validate->fails()) {
            return response()->json([
                'code'   => 422,
                'errors' => $validate->errors()
            ], 422);
        }

        $user = auth()->user();

        $userObj = User::create([
            'full_name'   => $data['full_name'],
            'role_name'   => 'user',
            'role_id'     => 1,
            'email'       => $data['email'],
            'password'    => User::generatePassword($data['password']),
            'status'      => 'active',
            'verified'    => true,
            'created_at'  => time(),
            'parent_type' => 'parent',
            'parent_id'   => $user->id,
        ]);

        return redirect()->route('panel_dashboard');
    }

    public function update_child(Request $request, $user_id)
    {
        $data = $request->post();
        $locale = $data['locale'] ?? getDefaultLocale();
        $userData = User::find($user_id);

        $rules = [
            'full_name' => 'required',
            'email'     => 'required|email',
            'password'  => 'required',
        ];

        $validate = Validator::make($data, $rules);

        if ($validate->fails()) {
            return response()->json([
                'code'   => 422,
                'errors' => $validate->errors()
            ], 422);
        }

        $user = auth()->user();

        $userObj = $userData->update([
            'full_name' => $data['full_name'],
            'email'     => $data['email'],
            'password'  => User::generatePassword($data['password']),
        ]);

        return redirect()->route('update_child', ['id' => $user_id]);
    }

    public function user(Request $request, $user_id)
    {
        $user = auth()->user();

        $userData = User::find($user_id);

        $data['pageTitle'] = 'Edit User';
        $data['userData'] = $userData;
        return view(getTemplate() . '.panel.parent.user_edit', $data);
    }

    public function switchUser(Request $request, $user_id)
    {
        $userData = User::find($user_id);
        $userObj = $userData->update([
            'is_from_parent' => 1,
        ]);
        Auth::loginUsingId($user_id, true);
        return redirect('/panel');
    }

    public function CancelSubscription(Request $request){
        $child_id = $request->post('child_id');
        $subscription = UserSubscriptions::where('status', 'active')
                        ->where('user_id', $child_id)->first();
        $userObj = $subscription->update([
                    'status' => 'inactive',
        ]);
        $userData = User::find($child_id);
        $userObj = $userData->update([
            'status' => 'inactive',
        ]);
        return response()->json([
            'code' => 200,
        ]);

    }





}
