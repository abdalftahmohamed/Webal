<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Feature;
use App\Traits\GeneralTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FeatureController extends Controller
{
    use GeneralTrait;
    public function index(): JsonResponse
    {
        try {
            $Features = Feature::all();
            return response()->json(
                $Features
            );

        } catch (\Throwable $ex) {
            return $this->returnError($ex->getCode(), $ex->getMessage());
        }
    }

    public function store(Request $request): JsonResponse
    {
        try {
            $Feature = new Feature();
            $Feature->name = $request->name;
            $Feature->description = $request->description;
            $Feature->icon = $request->icon;
            $Feature->save();

            return response()->json([
                'message' => 'Feature created successfully',
                'Feature' => $Feature
//            $Feature
            ], 201);
        } catch (\Throwable $ex) {
            return $this->returnError($ex->getCode(), $ex->getMessage());
        }
    }

    public function update(Request $request, $id): JsonResponse
    {
        try {
            $Feature = Feature::find($id);
            if (!$Feature) {
                return $this->returnError('E004', 'this Id not found');
            }
            $Feature->name = $request->name;
            $Feature->description = $request->description;
            $Feature->icon = $request->icon;
            $Feature->save();
            return response()->json([
                'message' => 'notification Updated successfully',
                'Feature' => $Feature
            ]);
        } catch (\Throwable $ex) {
            return $this->returnError($ex->getCode(), $ex->getMessage());
        }

    }

    public function show($id): JsonResponse
    {
        try {
            $Feature = Feature::find($id);
            if (!$Feature) {
                return $this->returnError('E004', 'this Id not found');
            }
            return response()->json([
                $Feature
            ]);

        } catch (\Throwable $ex) {
            return $this->returnError($ex->getCode(), $ex->getMessage());
        }

    }

    public function destroy($id): JsonResponse
    {
        try {
            $Feature = Feature::find($id);
            if (!$Feature) {
                return $this->returnError('E004', 'this Id not found');
            }
            $Feature->delete();
            return response()->json([
                'status' => true,
                'message' => 'Request Information deleted Successfully',
            ]);
        } catch (\Throwable $ex) {
            return $this->returnError($ex->getCode(), $ex->getMessage());
        }
    }
}
