<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\NotificationRepository;

class NotificationApiController extends Controller
{
    public function __construct
    (
        private NotificationRepository $notificationRepository,
    )
    {
    }

    public function getNotifications(Request $request)
    {
        try {
            $params = $request->all();

            $notifications = $this->notificationRepository->where('is_active', 1);

            $notifications = $notifications->get()->makeHidden(['id', 'is_active']);

            return response()->json(['data' => $notifications, 'message' => 'Success get data.']);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Failed to get data.'], 500);
        }
    }
}
