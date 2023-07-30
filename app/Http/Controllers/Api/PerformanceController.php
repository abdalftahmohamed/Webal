<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\api\PerformanceRequest;
use App\Models\Month;
use App\Models\Performance;
use App\Traits\GeneralTrait;
use Illuminate\Http\JsonResponse;

class PerformanceController extends Controller
{

    use GeneralTrait;
    public function index():  JsonResponse
    {
        try {
            $performances = Performance::all();
            return response()->json([
                $performances
            ]);

        }catch (\Throwable $ex) {
            return $this->returnError($ex->getCode(), $ex->getMessage());
        }
    }

    public function store(PerformanceRequest $request):  JsonResponse
    {
        try {
            $month=Month::find($request->month_id);
            if (!$month){
                return $this->returnError('E004','this Id of month not found');
            }
            $performance = new Performance();
            $performance->sympol = $request->sympol;
            $performance->target = $request->target;
            $performance->reached = $request->reached;
            $performance->comment = $request->comment;
            $performance->month_id = $request->month_id;
            $performance->save();

            return response()->json([
                $performance
            ],201);
        } catch (\Throwable $ex) {
            return $this->returnError($ex->getCode(), $ex->getMessage());
        }
    }
    public function update(PerformanceRequest $request, $id):  JsonResponse
    {
        try {
            $performance =Performance::find($id);
            if (!$performance){
                return $this->returnError('E004','this Id not found');
            }
            $month=Month::find($request->month_id);
            if (!$month){
                return $this->returnError('E004','this Id of month not found');
            }
            $performance->sympol = $request->sympol;
            $performance->target = $request->target;
            $performance->reached = $request->reached;
            $performance->comment = $request->comment;
            $performance->month_id = $request->month_id;
            $performance->save();
            return response()->json([
                'message' => 'performance Updated successfully',
                'performance' => $performance
            ]);
        } catch (\Throwable $ex) {
            return $this->returnError($ex->getCode(), $ex->getMessage());
        }

    }

    public function show($month_id):  JsonResponse
    {
        try {
            $performance =Performance::where('month_id',$month_id)->get();
            if (!$performance){
                return $this->returnError('E004','this Id not found');
            }
            return response()->json([
//                    'message' => 'Team Show successfully',
//                    'performance' => $performance
                $performance
            ]);

        } catch (\Throwable $ex) {
            return $this->returnError($ex->getCode(), $ex->getMessage());
        }

    }
    public function destroy($id):  JsonResponse
    {
        try {
            $performance = Performance::find($id);
            if (!$performance){
                return $this->returnError('E004','this Id not found');
            }
            $performance->delete();
            return response()->json([
                'status' => true,
                'message' => 'Request Information deleted Successfully',
            ]);
        } catch (\Throwable $ex) {
            return $this->returnError($ex->getCode(), $ex->getMessage());
        }
    }

}

