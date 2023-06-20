<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\api\TeamRequest;
use App\Traits\GeneralTrait;
use App\Traits\ImageTrait;
use App\Models\Team;

class TeamController extends Controller
{
    use GeneralTrait;
    use ImageTrait;
    public function index()
    {
        try {
            $teams = Team::all();
            return response([
                $teams
            ]);
        } catch (\Throwable $ex) {
            return $this->returnError($ex->getCode(), $ex->getMessage());
        }
    }

    public function store(TeamRequest $request)
    {
        try {
            $team = new Team();
            $team->name = $request->name;
            $team->description = $request->description;
            $team->namesection = $request->namesection;
            $team->save();
            $team_image = $this->saveImage($request->image,'attachments/teams/'.$team->id);
            $team->image = $team_image;
            $team->save();
            return response()->json([
                'message' => 'Team created successfully',
                'client' => $team
            ],201);
        } catch (\Throwable $ex) {
            return $this->returnError($ex->getCode(), $ex->getMessage());
        }
    }


    public function update(TeamRequest $request, $id)
    {
        try {
            $team =Team::find($id);
            if (!$team){
                return $this->returnError('E004','this Id not found');
            }
            $team->name = $request->name;
            $team->description = $request->description;
            $team->namesection = $request->namesection;
            $team->save();
            if ($request->hasFile('image')) {
                $this->deleteFile('teams',$id);
                $team_image = $this->saveImage($request->image,'attachments/teams/'.$team->id);
                $team->image = $team_image;
                $team->save();
            }
            return response()->json([
                'message' => 'Team Updated successfully',
                'team' => $team
            ]);
        } catch (\Throwable $ex) {
            return $this->returnError($ex->getCode(), $ex->getMessage());
        }

    }

    public function show( $id)
    {
        try {
            $team =Team::find($id);
            if (!$team){
                return $this->returnError('E004','this Id not found');
            }
                return response()->json([
//                    'message' => 'Team Show successfully',
//                    'team' => $team
                    $team
                ]);
        } catch (\Throwable $ex) {
            return $this->returnError($ex->getCode(), $ex->getMessage());
        }

    }
    public function destroy($id)
    {
        try {
            $team = Team::find($id);
            if (!$team){
                return $this->returnError('E004','this Id not found');
            }
            $this->deleteFile('teams',$id);
            $team->delete();
            return response()->json([
                'status' => true,
                'message' => 'Request Information deleted Successfully',
            ]);

        } catch (\Throwable $ex) {
            return $this->returnError($ex->getCode(), $ex->getMessage());
        }
    }
}

