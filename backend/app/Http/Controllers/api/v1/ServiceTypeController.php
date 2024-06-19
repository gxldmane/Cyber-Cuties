<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\api\v1\ServiceType\StoreRequest;
use App\Http\Requests\api\v1\ServiceType\UpdateRequest;
use App\Http\Resources\ServiceTypeResource;
use App\Models\Service;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class ServiceTypeController extends Controller
{
    public function store(int $serviceId, StoreRequest $request)
    {
        $service = Service::query()->find($serviceId);
        $data = $request->validated();

        if ($service) {
            if ($service->cutie_id === Auth::user()->id) {
                $serviceType = $service->types()->create($data);
                return new ServiceTypeResource($serviceType);
            }
            return response('Forbidden', Response::HTTP_FORBIDDEN);
        }

        return response('Service not found', Response::HTTP_NOT_FOUND);
    }

    public function update(int $serviceId, int $id, UpdateRequest $request)
    {

        $service = Service::query()->find($serviceId);

        if (!$service) {
            return response('Service not found', Response::HTTP_NOT_FOUND);
        }

        $serviceType = $service->types()->find($id);

        $data = $request->validated();

        if ($service && $serviceType) {
            if ($service->cutie_id === Auth::user()->id) {
                $serviceType->update($data);
                return new ServiceTypeResource($serviceType);
            }
            return response('Forbidden', Response::HTTP_FORBIDDEN);
        }

        return response('Not found', Response::HTTP_NOT_FOUND);
    }

    public function destroy(int $serviceId, int $id)
    {
        $service = Service::query()->find($serviceId);

        if (!$service) {
            return response('Service not found', Response::HTTP_NOT_FOUND);
        }
        $serviceType = $service->types()->find($id);

        if (!$serviceType) {
            return response('Service type found', Response::HTTP_NOT_FOUND);
        }

        if ($service->cutie_id === Auth::user()->id) {
            $serviceType->delete();
            return response('Service type deleted', Response::HTTP_NO_CONTENT);
        }
        return response('Forbidden', Response::HTTP_FORBIDDEN);
    }
}
