<?php
namespace App\Http\Services\Organizer\V1;

use Exception;
use App\Helper\ApiVox;
use Illuminate\Support\Facades\Storage;

class OrganizerService
{
    public $api;

    public function __construct()
    {
        $this->api = new ApiVox();
    }

    public function index($request)
    {
        try {
            $result = $this->api->get('api/v1/organizers', ($request) ?? []);
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
            $data = [
                'organizerName' => $request->organizerName
            ];
            if ($request->has('imageLocation')) {
                $image_path = $request->file('imageLocation')->store('image', 'public_media');
                // $data['imageLocation'] = asset('media/'.$image_path);
                $data['imageLocation'] = 'media/'.$image_path;
            }
            $result = $this->api->post('api/v1/organizers', $data);
            if (isset($result['message'])) {
                throw new Exception($result['message']);
            } else {
                config(['event.organizerId' => $result['id']]);
                unlink(public_path('media/'.$image_path));
                return $result;
            }
        } catch (Exception $err) {
            return $err;
        }
    }

    public function edit($id, $request)
    {
        try {
            $result = $this->api->get('api/v1/organizers/'.$id);
            if (isset($result['message'])) {
                throw new Exception($result['message']);
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
            $data = [
                'organizerName' => $request->organizerName
            ];
            if ($request->has('imageLocation')) {
                $image_path = $request->file('imageLocation')->store('image', 'public_media');
                // $data['imageLocation'] = asset('media/'.$image_path);
                $data['imageLocation'] = 'media/'.$image_path;
            }
            $result = $this->api->put('api/v1/organizers/'.$id, $data);
            if (isset($result['message'])) {
                throw new Exception($result['message']);
            } else {
                unlink(public_path('media/'.$image_path));
                return $result;
            }
        } catch (Exception $err) {
            return $err;
        }
    }

    public function delete($id)
    {
        try {
            $result = $this->api->delete('api/v1/organizers/'.$id);
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
