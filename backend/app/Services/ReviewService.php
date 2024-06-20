<?php

namespace App\Services;

use App\Http\Resources\ReviewResource;
use App\Models\Review;
use App\Models\Service;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Foundation\Application;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Auth;
use Spatie\QueryBuilder\QueryBuilder;
use Symfony\Component\HttpFoundation\Response;

class ReviewService
{
    public function getAllReviewsOfService(Service $service): AnonymousResourceCollection
    {
        $reviews = QueryBuilder::for($service->reviews())
            ->allowedFilters(['type'])
            ->defaultSort('-created_at')
            ->allowedSorts('rating')
            ->paginate(6);
        return ReviewResource::collection($reviews);
    }

    public function createReview(Service $service, array $data)
    {
        if ($service->alreadyReviewedBy(Auth::user())) {
            return response('Already reviewed', Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $data['user_id'] = Auth::user()->id;

        if ($data['rating'] <= 3) {
            $data['type'] = 'negative';
        }

        if ($data['rating'] >= 4) {
            $data['type'] = 'positive';
        }

        $review = $service->reviews()->create($data);

        return new ReviewResource($review);
    }

    public function updateReview(Review $review, array $data): Application|\Illuminate\Http\Response|ReviewResource|\Illuminate\Contracts\Foundation\Application|ResponseFactory
    {
        if ($review->user_id !== Auth::user()->id) {
            return response('Unauthorized', Response::HTTP_UNAUTHORIZED);
        }

        if ($data['rating'] <= 3) {
            $data['type'] = 'negative';
        }

        if ($data['rating'] >= 4) {
            $data['type'] = 'positive';
        }

        $review->update($data);

        return new ReviewResource($review);

    }
}
