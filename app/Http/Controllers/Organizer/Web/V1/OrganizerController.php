<?php

namespace App\Http\Controllers\Organizer\Web\V1;

use Exception;
use App\Functions;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\Organizer\V1\OrganizerRequest;
use App\Http\Services\Organizer\V1\OrganizerService;

class OrganizerController extends Controller
{
    public function index(Request $request,  OrganizerService $service)
    {
        try {
            $result = $service->index($request->all());
            if (Functions::exception($result)) {
                throw new Exception($result->getMessage(), is_string($result->getCode()) ? (int)$result->getCode() : $result->getCode());
            } else {
                $datas = $result['data'];
                $pagination = $result['meta']['pagination'];
                return view('v1.organizer.index',compact('datas','pagination'));
            }
        } catch (Exception $err) {
            return back()->with('error', $err->getMessage());
        }
    }

    public function create()
    {
        return view('v1.organizer.create');
    }

    public function store(Request $request, OrganizerService $service)
    {
        try {
            $rules = (new OrganizerRequest())->rules();
            $validation = Validator::make($request->all(),$rules);
            if ($validation->fails()) {
                return back()->withInput()->withErrors($validation->errors());
            }
            $result = $service->store($request);
            if (Functions::exception($result)) {
                throw new Exception($result->getMessage(), is_string($result->getCode()) ? (int)$result->getCode() : $result->getCode());
            } else {
                return redirect(route('admin.v1.organizer.index'))->with('success','Store Organize Success');
            }
        } catch (Exception $err) {
            return back()->withInput()->with('error', $err->getMessage());
        }
    }

    public function edit($id, Request $request, OrganizerService $service)
    {
        try {
            $result = $service->edit($id, $request->all());
            if (Functions::exception($result)) {
                throw new Exception($result->getMessage(), is_string($result->getCode()) ? (int)$result->getCode() : $result->getCode());
            } else {
                $data = $result;
                return view('v1.organizer.edit',compact('data'));
            }
        } catch (Exception $err) {
            return back()->with('error', $err->getMessage());
        }
    }

    public function update($id, Request $request, OrganizerService $service)
    {
        try {
            $rules = (new OrganizerRequest())->rules();
            $validation = Validator::make($request->all(),$rules);
            if ($validation->fails()) {
                return back()->withInput()->withErrors($validation->errors());
            }
            $result = $service->update($id, $request);
            if (Functions::exception($result)) {
                throw new Exception($result->getMessage(), is_string($result->getCode()) ? (int)$result->getCode() : $result->getCode());
            } else {
                return redirect(route('admin.v1.organizer.edit',$id))->with('success','Update Organize Success');
            }
        } catch (Exception $err) {
            return back()->withInput()->with('error', $err->getMessage());
        }
    }

    public function delete($id, OrganizerService $service)
    {
        try {
            $result = $service->delete($id);
            if (Functions::exception($result)) {
                throw new Exception($result->getMessage(), is_string($result->getCode()) ? (int)$result->getCode() : $result->getCode());
            } else {
                return redirect(route('admin.v1.organizer.index'))->with('success', 'Delete Organize Success');
            }
        } catch (Exception $err) {
            return back()->with('error', $err->getMessage());
        }
    }
}
