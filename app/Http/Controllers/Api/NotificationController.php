<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\api\NotificationRequest;
use App\Models\Notification;
use App\Traits\GeneralTrait;
use App\Traits\ImageTrait;
use Illuminate\Http\JsonResponse;

class NotificationController extends Controller
{
    use GeneralTrait;
    use ImageTrait;

    public function index(): JsonResponse
    {
        try {
            $notifications = Notification::all();
            return response()->json([
//                "status"=>true,
                $notifications
            ]);

        } catch (\Throwable $ex) {
            return $this->returnError($ex->getCode(), $ex->getMessage());
        }
    }

    public function store(NotificationRequest $request): JsonResponse
    {
        try {
            $notification = new Notification();
            $notification->name = $request->name;
            $notification->number = $request->number;
            $notification->datesend = $request->datesend;
            $notification->description = $request->description;
            $notification->save();
            if ($request->hasFile('image')) {
                //image save
                $notification_image = $this->saveImage($request->image,'attachments/notification/'.$notification->id);
                $notification->image = $notification_image;
                $notification->save();
            }
            if ($request->hasFile('video')) {
                //video save
                $notification_video = $this->saveVideo($request->video,'attachments/notification/'.$notification->id);
                $notification->video = $notification_video;
                $notification->save();
            }

            return response()->json([
                'message' => 'Notification created successfully',
                'Notification' => $notification
//            $notification
            ], 201);
        } catch (\Throwable $ex) {
            return $this->returnError($ex->getCode(), $ex->getMessage());
        }
    }

    public function update(NotificationRequest $request, $id): JsonResponse
    {
        try {
            $notification = Notification::find($id);
            if (!$notification) {
                return $this->returnError('E004', 'this Id not found');
            }
            $notification->name = $request->name;
            $notification->number = $request->number;
            $notification->datesend = $request->datesend;
            $notification->description = $request->description;
            $notification->save();
            if ($request->hasFile('image')) {
                //image save
                $notification_image = $this->saveImage($request->image,'attachments/notification/'.$notification->id);
                $notification->image = $notification_image;
                $notification->save();
            }
            if ($request->hasFile('video')) {
                //video save
                $notification_video = $this->saveVideo($request->video,'attachments/notification/'.$notification->id);
                $notification->video = $notification_video;
                $notification->save();
            }

            return response()->json([
                'message' => 'notification Updated successfully',
                'notification' => $notification
            ]);
        } catch (\Throwable $ex) {
            return $this->returnError($ex->getCode(), $ex->getMessage());
        }

    }

    public function show($id): JsonResponse
    {
        try {
            $notification = Notification::find($id);
            if (!$notification) {
                return $this->returnError('E004', 'this Id not found');
            }
            return response()->json([
//                    'message' => 'Team Show successfully',
//                    'notification' => $notification
                $notification
            ]);

        } catch (\Throwable $ex) {
            return $this->returnError($ex->getCode(), $ex->getMessage());
        }

    }

    public function destroy($id): JsonResponse
    {
        try {
            $notification = Notification::find($id);
            if (!$notification) {
                return $this->returnError('E004', 'this Id not found');
            }
            $this->deleteFile('notification', $notification->id);
            $notification->delete();
            return response()->json([
                'status' => true,
                'message' => 'Request Information deleted Successfully',
            ]);
        } catch (\Throwable $ex) {
            return $this->returnError($ex->getCode(), $ex->getMessage());
        }
    }

}
