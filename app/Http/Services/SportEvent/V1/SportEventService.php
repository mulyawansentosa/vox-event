<?php
namespace App\Http\Services\SportEvent\V1;

use Exception;
use Carbon\Carbon;
use App\Helper\ApiVox;

class SportEventService
{
    public $api;

    public function __construct()
    {
        $this->api = new ApiVox();
    }

    public function index($request)
    {
        try {
            $result = $this->api->get('api/v1/sport-events', ($request) ?? []);
            if (isset($result['message'])) {
                throw new Exception($result['message']);
            } else {
                return $result;
            }
        } catch (Exception $err) {
            return $err;
        }
    }

    public function create()
    {
        try {
            $result = $this->api->get('api/v1/organizers', ['perPage' => 9999999]);
            if (isset($result['message'])) {
                throw new Exception($result['message']);
            } else {
                return $result;
            }
        } catch (Exception $err) {
            return $err;
        }
    }

    public function store($request)
    {
        try {
            $arr = array();
            foreach ($request as $key => $value) {
                if ($key == 'eventDate') {
                    $arr[$key] = Carbon::parse($value)->toDateString();
                } else if ($key == 'organizerId') {
                    $arr[$key] = (int)$value;
                } else {
                    $arr[$key] = $value;
                }
            }
            $result = $this->api->post('api/v1/sport-events', $arr);
            if (isset($result['message'])) {
                throw new Exception($result['message']);
            } else {
                putenv('EVENT_ID='.$result['id']);
                return $result;
            }
        } catch (Exception $err) {
            return $err;
        }
    }

    public function edit($id, $request)
    {
        try {
            $result['data'] = $this->api->get('api/v1/sport-events/'.$id);
            $result['refs'] = $this->api->get('api/v1/organizers', ['perPage' => 9999999]);
            if (isset($result['data']['message'])) {
                throw new Exception($result['data']['message']);
            } else if (isset($result['refs']['message'])) {
                throw new Exception($result['refs']['message']);
            } else {
                return $result;
            }
        } catch (Exception $err) {
            return $err;
        }
    }

    public function update($id, $request)
    {
        try {
            $arr = array();
            foreach ($request as $key => $value) {
                if ($key == 'eventDate') {
                    $arr[$key] = Carbon::parse($value)->toDateString();
                } else if ($key == 'organizerId') {
                    $arr[$key] = (int)$value;
                } else {
                    $arr[$key] = $value;
                }
            }
            $result = $this->api->put('api/v1/sport-events/'.$id, $arr);
            if (isset($result['message'])) {
                throw new Exception($result['message']);
            } else {
                return $result;
            }
        } catch (Exception $err) {
            return $err;
        }
    }

    public function delete($id)
    {
        try {
            $result = $this->api->delete('api/v1/sport-events/'.$id);
            if (isset($result['message'])) {
                throw new Exception($result['message']);
            } else {
                return $result;
            }
        } catch (Exception $err) {
            return $err;
        }
    }
}
