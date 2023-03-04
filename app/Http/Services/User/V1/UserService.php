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

    public function login($request)
    {
        try {
            $arr = array();
            foreach ($request as $key => $value) {
                $arr[$key] = $value;
            }
            $result = $this->api->auth('api/v1/users/login', $arr);
            if (isset($result['message'])) {
                throw new Exception($result['message']);
            } else {
                return session(['token' => $result['token']]);
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
                return self::login([$arr['email'],$arr['password']]);
            }
        } catch (Exception $err) {
            return $err;
        }
    }
}