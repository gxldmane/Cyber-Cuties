<?php

namespace App\Services;

use App\Actions\AddServiceCoverAction;
use App\Models\Service;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class ServiceService
{
    public function store(array $data, User $user, AddServiceCoverAction $addCoverAction)
    {
        $cover = $data['image'];
        unset($data['image']);
        $data['cutie_id'] = $user->id;
        $service = Service::query()->create($data);
        $addCoverAction->handle($cover, $service);

        return $service;
    }

    public function update(array $data, Service|Model|Builder|Collection $service, AddServiceCoverAction $addCoverAction)
    {

        $cover = $data['image'];
        unset($data['image']);
        $service->update($data);
        $addCoverAction->handle($cover, $service);

        return $service;

    }
}
