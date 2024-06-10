<?php

namespace App\Services;

use App\Data\RankData;
use App\Models\Rank;

class RankService
{
    public function getRankById(int $id): ?RankData
    {
        $rank = Rank::find($id);

        if (!$rank) {
            return null;
        }

        return RankData::from($rank)->wrap('data');
    }
}
