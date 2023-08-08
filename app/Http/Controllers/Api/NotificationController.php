<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\api\NotificationRequest;
use App\Models\Notification;
use App\Models\Notificationcreate;
use App\Traits\GeneralTrait;
use App\Traits\ImageTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\URL;

class NotificationController extends Controller
{
    use GeneralTrait;
    use ImageTrait;

    public function index(): JsonResponse
    {
        try {
            $notifications = Notificationcreate::all();
            return response()->json([
                "status"=>true,
                "data"=>$notifications
            ]);

        } catch (\Throwable $ex) {
            return $this->returnError($ex->getCode(), $ex->getMessage());
        }
    }

    public function store(NotificationRequest $request): JsonResponse
    {
        try {
            $notification = new Notificationcreate();
            $notification->name = $request->name;
            $notification->description = $request->description;
            $notification->send_time = $request->send_time;
            $notification->save();
            if ($request->hasFile('image')) {
                //image save
                $notification_image = $this->saveImage($request->image,'attachments/notification/image/'.$notification->id);
                $notification->image = $notification_image;
                $notification->save();
            }
            if ($request->hasFile('video')) {
                //video save
                $notification_video = $this->saveVideo($request->video,'attachments/notification/video/'.$notification->id);
                $notification->video = $notification_video;
                $notification->save();
            }
            $notification->image=URL::asset('attachments/notification/image/'.$notification->id.'/'.$notification->image);
            $notification->video=URL::asset('attachments/notification/video/'.$notification->id.'/'.$notification->video);
            return response()->json([
                "status"=>true,
                'message' => 'Notification created successfully',
                'Notification' => $notification
            ], 201);
        } catch (\Throwable $ex) {
            return $this->returnError($ex->getCode(), $ex->getMessage());
        }
    }

    public function update(NotificationRequest $request, $id): JsonResponse
    {
        try {
            $notification = Notificationcreate::find($id);
            if (!$notification) {
                return $this->returnError('E004', 'this Id not found');
            }
            $notification->name = $request->name;
            $notification->description = $request->description;
            $notification->send_time = $request->send_time;
            $notification->save();

            if ($request->hasFile('image')) {
                //image save
                $this->deleteFile('notification/image', $notification->id);
                $notification_image = $this->saveImage($request->image,'attachments/notification/image/'.$notification->id);
                $notification->image = $notification_image;
                $notification->save();
            }
            if ($request->hasFile('video')) {
                //video save
                $this->deleteFile('notification/video', $notification->id);
                $notification_video = $this->saveVideo($request->video,'attachments/notification/video/'.$notification->id);
                $notification->video = $notification_video;
                $notification->save();
            }
            $notification->image=URL::asset('attachments/notification/image/'.$notification->id.'/'.$notification->image);
            $notification->video=URL::asset('attachments/notification/video/'.$notification->id.'/'.$notification->video);
            return response()->json([
                "status"=>true,
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
            $notification = Notificationcreate::find($id);
            if (!$notification) {
                return $this->returnError('E004', 'this Id not found');
            }
            $notification->image=URL::asset('attachments/notification/image/'.$notification->id.'/'.$notification->image);
            $notification->video=URL::asset('attachments/notification/video/'.$notification->id.'/'.$notification->video);
            return response()->json([
                    "status"=>true,
                    'message' => 'Team Show successfully',
                    'notification' => $notification,
            ]);

        } catch (\Throwable $ex) {
            return $this->returnError($ex->getCode(), $ex->getMessage());
        }

    }

    public function destroy($id): JsonResponse
    {
        try {
            $notification = Notificationcreate::find($id);
            if (!$notification) {
                return $this->returnError('E004', 'this Id not found');
            }
            $this->deleteFile('notification/image', $notification->id);
            $this->deleteFile('notification/video', $notification->id);
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
