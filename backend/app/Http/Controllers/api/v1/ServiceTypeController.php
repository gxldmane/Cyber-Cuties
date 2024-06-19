<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\api\v1\ServiceType\StoreRequest;
use App\Http\Requests\api\v1\ServiceType\UpdateRequest;
use App\Http\Resources\ServiceTypeResource;
use App\Models\Service;
use App\Models\ServiceType;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class ServiceTypeController extends Controller
{
    public function store(StoreRequest $request)
    {
        $data = $request->validated();
        $service = Service::query()->find($data['service_id']);

        if ($service->types()->count() > 4) {
            return response('Too many service types', Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        if ($service->cutie_id === Auth::user()->id) {
            $serviceType = $service->types()->create($data);
            return new ServiceTypeResource($serviceType);
        }
        return response('Forbidden', Response::HTTP_FORBIDDEN);
    }

    public function update(int $id, UpdateRequest $request)
    {
        $serviceType = ServiceType::query()->find($id);

        $data = $request->validated();

        $service = Service::query()->find($data['service_id']);

        if ($serviceType) {
            if ($service->cutie_id === Auth::user()->id) {
                $serviceType->update($data);
                return new ServiceTypeResource($serviceType);
            }
            return response('Forbidden', Response::HTTP_FORBIDDEN);
        }

        return response('Not found', Response::HTTP_NOT_FOUND);
    }

    public function destroy(int $id)
    {
        $serviceType = ServiceType::query()->find($id);

        $service = Service::query()->find($serviceType->service_id);

        if (!$serviceType) {
            return response('Service type not found', Response::HTTP_NOT_FOUND);
        }

        if ($service->cutie_id === Auth::user()->id) {
            $serviceType->delete();
            return response('Service type deleted', Response::HTTP_NO_CONTENT);
        }
        return response('Forbidden', Response::HTTP_FORBIDDEN);
    }
}
