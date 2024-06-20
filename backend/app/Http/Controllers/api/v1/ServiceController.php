<?php

namespace App\Http\Controllers\api\v1;

use App\Actions\AddServiceCoverAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\api\v1\Service\StoreRequest;
use App\Http\Requests\api\v1\Service\UpdateRequest;
use App\Http\Resources\Service\ServiceFullResource;
use App\Http\Resources\Service\ServiceResource;
use App\Models\Service;
use App\Services\ServiceService;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class ServiceController extends Controller
{
    public ServiceService $service;

    public function __construct(ServiceService $service)
    {
        $this->service = $service;
    }

    public function show(int $id)
    {
        $service = Service::query()->find($id);

        return new ServiceFullResource($service);
    }

    public function store(StoreRequest $request)
    {
        $user = Auth::user();

        $data = $request->validated();

        $service = $this->service->store($data, $user, new AddServiceCoverAction());

        return new ServiceResource($service);
    }

    public function update(UpdateRequest $request, int $id)
    {
        $service = Service::query()->find($id);
        $data = $request->validated();

        if ($service) {
            if ($service->cutie_id === Auth::user()->id) {
                $service = $this->service->update($data, $service, new AddServiceCoverAction());
                return new ServiceResource($service);
            }
            return response('Forbidden', Response::HTTP_FORBIDDEN);
        }

        return response('Service not found', Response::HTTP_NOT_FOUND);
    }

    public function destroy(int $id)
    {
        $service = Service::query()->find($id);

        if ($service) {
            if ($service->cutie_id === Auth::user()->id) {
                $service->delete();
                return response('Service deleted', Response::HTTP_NO_CONTENT);
            }
            return response('Forbidden', Response::HTTP_FORBIDDEN);
        }
        return response('Service not found', Response::HTTP_NOT_FOUND);
    }
}
