<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Services\RankService;
use Symfony\Component\HttpFoundation\Response;

class RankController extends Controller
{
    public RankService $service;

    public function __construct(RankService $rankService)
    {
        $this->service = $rankService;
    }

    public function show(int $id)
    {
        $rank = $this->service->getRankById($id);

        if (!$rank) {
            return response('Rank not found', Response::HTTP_NOT_FOUND);
        }

        return $rank;
    }
}
