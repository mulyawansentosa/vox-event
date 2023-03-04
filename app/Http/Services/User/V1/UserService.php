<?php
namespace App\Http\Services\User\V1;

use App\Helper\ApiVox;
use Exception;
use Illuminate\Support\Facades\Hash;

class UserService
{
    public $api;

    public function __construct()
    {
        $this->api = new ApiVox();
    }

    public function index()
    {
        try {
            $result = $this->api->get('api/v1/users/'.session('userId'));
            if (isset($result['message'])) {
                throw new Exception($result['message']);
            } else {
                return $result;
            }
        } catch (Exception $err) {
            return $err;
        }
    }

    public function update($request)
    {
        try {
            $result = $this->api->put('api/v1/users/'.session('userId'), $request);
            if (isset($result['message'])) {
                throw new Exception($result['message']);
            } else {
                return $result;
            }
        } catch (Exception $err) {
            return $err;
        }
    }

    public function delete()
    {
        try {
            $result = $this->api->delete('api/v1/users/'.session('userId'));
            if (isset($result['message'])) {
                throw new Exception($result['message']);
            } else {
                return $result;
            }
        } catch (Exception $err) {
            return $err;
        }
    }

    public function changePassword($request)
    {
        try {
            $result = $this->api->put('api/v1/users/'.session('userId').'/password', $request);
            if (isset($result['message'])) {
                throw new Exception($result['message']);
            } else {
                return $result;
            }
        } catch (Exception $err) {
            return $err;
        }
    }

    public function login($request)
    {
        try {
            $arr = array();
            foreach ($request as $key => $value) {
                $arr[$key] = $value;
            }
            $result = $this->api->auth('api/v1/users/login', $arr);
            if (isset($result['error'])) {
                throw new Exception($result['error']);
            } else {
                return session([
                    'token' => $result['token'],
                    'userId' => $result['id']
                ]);
            }
        } catch (Exception $err) {
            return $err;
        }
    }

    public function register($request)
    {
        try {
            $arr = array();
            foreach ($request as $key => $value) {
                $arr[$key] = $value;
            }
            $result = $this->api->auth('api/v1/users', $arr);
            if (isset($result["message"])) {
                throw new Exception($result["message"]);
            } else {
                return true;
            }
        } catch (Exception $err) {
            return $err;
        }
    }
}