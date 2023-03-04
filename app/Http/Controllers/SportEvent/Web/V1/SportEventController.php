<?php

namespace App\Http\Controllers\SportEvent\Web\V1;

use Exception;
use App\Functions;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\SportEvent\V1\SportEventRequest;
use App\Http\Services\SportEvent\V1\SportEventService;

class SportEventController extends Controller
{
    public function index(Request $request,  SportEventService $service)
    {
        try {
            $result = $service->index($request->all());
            if (Functions::exception($result)) {
                throw new Exception($result->getMessage(), is_string($result->getCode()) ? (int)$result->getCode() : $result->getCode());
            } else {
                $datas = $result['data'];
                $pagination = $result['meta']['pagination'];
                return view('v1.sportEvent.index',compact('datas','pagination'));
            }
        } catch (Exception $err) {
            return back()->with('error', $err->getMessage());
        }
    }

    public function create(SportEventService $service)
    {
        try {
            $result = $service->create();
            if (Functions::exception($result)) {
                throw new Exception($result->getMessage(), is_string($result->getCode()) ? (int)$result->getCode() : $result->getCode());
            } else {
                $refs = $result['data'];
                return view('v1.sportEvent.create',compact('refs'));
            }
        } catch (Exception $err) {
            return back()->with('error', $err->getMessage());
        }
        return view('v1.sportEvent.create');
    }

    public function store(Request $request, SportEventService $service)
    {
        try {
            $rules = (new SportEventRequest())->rules();
            $validation = Validator::make($request->all(),$rules);
            if ($validation->fails()) {
                return back()->withInput()->withErrors($validation->errors());
            }
            $result = $service->store($request->all());
            if (Functions::exception($result)) {
                throw new Exception($result->getMessage(), is_string($result->getCode()) ? (int)$result->getCode() : $result->getCode());
            } else {
                return redirect(route('admin.v1.sport-events.index'))->with('success','Store Sport Event Success');
            }
        } catch (Exception $err) {
            return back()->withInput()->with('error', $err->getMessage());
        }
    }

    public function edit($id, Request $request, SportEventService $service)
    {
        try {
            $result = $service->edit($id, $request->all());
            if (Functions::exception($result)) {
                throw new Exception($result->getMessage(), is_string($result->getCode()) ? (int)$result->getCode() : $result->getCode());
            } else {
                $data = $result['data'];
                $refs = $result['refs']['data'];
                return view('v1.sportEvent.edit',compact('data','refs'));
            }
        } catch (Exception $err) {
            return back()->with('error', $err->getMessage());
        }
    }

    public function update($id, Request $request, SportEventService $service)
    {
        try {
            $rules = (new SportEventRequest())->rules();
            $validation = Validator::make($request->all(),$rules);
            if ($validation->fails()) {
                return back()->withInput()->withErrors($validation->errors());
            }
            $result = $service->update($id, $request->all());
            if (Functions::exception($result)) {
                throw new Exception($result->getMessage(), is_string($result->getCode()) ? (int)$result->getCode() : $result->getCode());
            } else {
                return redirect(route('admin.v1.sport-events.edit',$id))->with('success','Update Sport Event Success');
            }
        } catch (Exception $err) {
            return back()->withInput()->with('error', $err->getMessage());
        }
    }

    public function delete($id, SportEventService $service)
    {
        try {
            $result = $service->delete($id);
            if (Functions::exception($result)) {
                throw new Exception($result->getMessage(), is_string($result->getCode()) ? (int)$result->getCode() : $result->getCode());
            } else {
                return redirect(route('admin.v1.sport-events.index'))->with('success', 'Delete Sport Event Success');
            }
        } catch (Exception $err) {
            return back()->with('error', $err->getMessage());
        }
    }
}
