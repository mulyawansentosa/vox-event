<?php

namespace App\Http\Controllers\User\Web\V1;

use Exception;
use App\Functions;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Http\Services\User\V1\UserService;
use App\Http\Requests\User\V1\UserLoginRequest;
use App\Http\Requests\User\V1\UserRegisterRequest;

class UserController extends Controller
{
    public function login(Request $request, UserService $service)
    {
        try {
            $rules = (new UserLoginRequest())->rules();
            $validation = Validator::make($request->all(),$rules);
            if ($validation->fails()) {
                return back()->withInput()->withErrors($validation->errors());
            }
            $result = $service->login($request->all());
            if (Functions::exception($result)) {
                throw new Exception($result->getMessage(), is_string($result->getCode()) ? (int)$result->getCode() : $result->getCode());
            } else {
                return view('v1.organizer.organizer_index');
            }
        } catch (Exception $err) {
            return back()->withInput()->with('error', $err->getMessage());
        }
    }

    public function register(Request $request, UserService $service)
    {
        try {
            $rules = (new UserRegisterRequest())->rules();
            $validation = Validator::make($request->all(),$rules);
            if ($validation->fails()) {
                return back()->withInput()->withErrors($validation->errors());
            }
            $result = $service->register($request->all());
            if (Functions::exception($result)) {
                throw new Exception($result->getMessage(), is_string($result->getCode()) ? (int)$result->getCode() : $result->getCode());
            } else {
                return redirect(route('admin.v1.dashboard'))->with('success','Login Berhasil');
            }
        } catch (Exception $err) {
            return back()->withInput()->with('error', $err->getMessage());
        }
    }
}
