<?php

namespace App\Services;

use App\Http\Resources\RankResource;
use App\Models\Rank;

class RankService
{
    public function getRankById(int $id)
    {
        $rank = Rank::with('category')->find($id);

        if (!$rank) {
            return null;
        }

        return new RankResource($rank);
    }
}
