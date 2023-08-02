<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Role;
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




}
