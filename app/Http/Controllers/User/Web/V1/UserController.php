<?php

namespace App\Http\Controllers\User\Web\V1;

use Exception;
use App\Functions;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Http\Services\User\V1\UserService;
use App\Http\Requests\User\V1\UserLoginRequest;
use App\Http\Requests\User\V1\UserUpdateRequest;
use App\Http\Requests\User\V1\UserRegisterRequest;
use App\Http\Requests\User\V1\UserChangePassRequest;

class UserController extends Controller
{
    public function index(UserService $service)
    {
        try {
            $result = $service->index();
            if (Functions::exception($result)) {
                throw new Exception($result->getMessage(), is_string($result->getCode()) ? (int)$result->getCode() : $result->getCode());
            } else {
                $data = $result;
                return view('v1.user.index',compact('data'));
            }
        } catch (Exception $err) {
            return back()->withInput()->with('error', $err->getMessage());
        }
    }

    public function update(Request $request, UserService $service)
    {
        try {
            $rules = (new UserUpdateRequest())->rules();
            $validation = Validator::make($request->all(),$rules);
            if ($validation->fails()) {
                return back()->withInput()->withErrors($validation->errors());
            }
            $result = $service->update($request->all());
            if (Functions::exception($result)) {
                throw new Exception($result->getMessage(), is_string($result->getCode()) ? (int)$result->getCode() : $result->getCode());
            } else {
                return redirect(route('admin.v1.user.index'))->with('success','Update Success');
            }
        } catch (Exception $err) {
            return back()->withInput()->with('error', $err->getMessage());
        }
    }

    public function delete(Request $request, UserService $service)
    {
        try {
            $result = $service->delete();
            if (Functions::exception($result)) {
                throw new Exception($result->getMessage(), is_string($result->getCode()) ? (int)$result->getCode() : $result->getCode());
            } else {
                $request->session()->flush();
                return redirect(url('/'))->with('success','Delete User Success');
            }
        } catch (Exception $err) {
            return back()->withInput()->with('error', $err->getMessage());
        }
    }

    public function changePassword(Request $request, UserService $service)
    {
        try {
            $rules = (new UserChangePassRequest())->rules();
            $validation = Validator::make($request->all(),$rules);
            if ($validation->fails()) {
                return back()->withInput()->withErrors($validation->errors());
            }
            $result = $service->changePassword($request->all());
            if (Functions::exception($result)) {
                throw new Exception($result->getMessage(), is_string($result->getCode()) ? (int)$result->getCode() : $result->getCode());
            } else {
                return redirect(route('admin.v1.user.index'))->with('success','Change Password Success');
            }
        } catch (Exception $err) {
            return back()->withInput()->with('error', $err->getMessage());
        }
    }

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
                return redirect(route('admin.v1.organizer.index'))->with('success','Login Success');
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
                return redirect(url('/'))->with('success','Register Success, Please Login');
            }
        } catch (Exception $err) {
            return back()->withInput()->with('error', $err->getMessage());
        }
    }

    public function logout(Request $request)
    {
        try {
            $request->session()->flush();
            return redirect(url('/'))->with('success','Logout Success');
        } catch (Exception $err) {
            return back()->withInput()->with('error', $err->getMessage());
        }
    }
}
