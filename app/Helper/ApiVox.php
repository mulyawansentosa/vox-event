<?php
namespace App\Helper;

use Exception;
use Illuminate\Support\Facades\Http;

class ApiVox
{
    public $host;

    public function __construct()
    {
        $this->host =  'https://api-sport-events.php6-02.test.voxteneo.com/';
    }

    public function auth($endpoint, $datas = [])
    {
        try {
            $response = Http::timeout(60)->withHeaders([
                'Content-Type' => 'application/json',
            ])->post("{$this->host}{$endpoint}", $datas);
            $result = json_decode($response->body(), true);
            return $result;
        } catch (Exception $err) {
            return $err;
        }
    }

    public function post($endpoint,$datas = [])
    {
        try {
            $response = Http::timeout(60)->withHeaders([
                'Authorization' => 'Bearer '.session('token'),
                'Content-Type' => 'application/json',
            ])->post("{$this->host}{$endpoint}", $datas);
            $result = json_decode($response->body(), true);
            return $result;
        } catch (Exception $err) {
            return $err;
        }
    }

    public function get($endpoint,$datas = [])
    {
        try {
            $response = Http::timeout(60)->withHeaders([
                'Authorization' => 'Bearer '.session('token'),
                'Content-Type' => 'application/json',
            ])->get("{$this->host}{$endpoint}", $datas);
            $result = json_decode($response->body(), true);
            return $result;
        } catch (Exception $err) {
            return $err;
        }
    }

    public function put($endpoint,$datas = [])
    {
        try {
            $response = Http::timeout(60)->withHeaders([
                'Authorization' => 'Bearer '.session('token'),
                'Content-Type' => 'application/json',
            ])->put("{$this->host}{$endpoint}", $datas);
            $result = json_decode($response->body(), true);
            return $result;
        } catch (Exception $err) {
            return $err;
        }
    }

    public function delete($endpoint,$datas = [])
    {
        try {
            $response = Http::timeout(60)->withHeaders([
                'Authorization' => 'Bearer '.session('token'),
                'Content-Type' => 'application/json',
            ])->delete("{$this->host}{$endpoint}", $datas);
            $result = json_decode($response->body(), true);
            return $result;
        } catch (Exception $err) {
            return $err;
        }
    }
}