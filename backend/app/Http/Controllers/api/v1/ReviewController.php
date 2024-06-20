<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\api\v1\Review\StoreRequest;
use App\Http\Requests\api\v1\Review\UpdateRequest;
use App\Models\Service;
use App\Services\ReviewService;

class ReviewController extends Controller
{
    public ReviewService $reviewService;

    public function __construct(ReviewService $reviewService)
    {
        $this->reviewService = $reviewService;
    }

    public function index(int $serviceId)
    {

        $service = Service::query()->find($serviceId);

        if (!$service) {
            return response('Service not found', 404);
        }

        return $this->reviewService->getAllReviewsOfService($service);
    }

    public function store(int $serviceId, StoreRequest $request)
    {
        $data = $request->validated();

        $service = Service::query()->find($serviceId);

        if (!$service) {
            return response('Service not found', 404);
        }

        return $this->reviewService->createReview($service, $data);
    }

    public function update(int $serviceId, int $reviewId, UpdateRequest $request)
    {
        $data = $request->validated();

        $service = Service::query()->find($serviceId);

        if (!$service) {
            return response('Service not found', 404);
        }

        $review = $service->reviews()->find($reviewId);

        if (!$review) {
            return response('Review not found', 404);
        }

        return $this->reviewService->updateReview($review, $data);
    }

    public function destroy(int $serviceId, int $reviewId)
    {
        $service = Service::query()->find($serviceId);

        if (!$service) {
            return response('Service not found', 404);
        }

        $review = $service->reviews()->find($reviewId);

        if (!$review) {
            return response('Review not found', 404);
        }

        $review->delete();

        return response(null, 204);
    }
}
