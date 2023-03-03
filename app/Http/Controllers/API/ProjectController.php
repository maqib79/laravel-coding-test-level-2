<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;

class ProjectController extends Controller
{
    //
    public $successStatus = 200;

    public function index()
    {
        
        if(isset($_GET['q'])){
            $projects = Project::where('name','like',$_GET['q']);
        }else{
            $projects = Project::select('*');

        }
        if(isset($_GET['sortBy'])){
            $projects = $projects->orderBy($_GET['sortBy']);
        }else{
            $projects = $projects->orderBy('name','ASC');

        }
        $projects = $projects->paginate(); 
        
        return response()->json(['projects' => $projects], $this->successStatus);
    }

    public function details($id){
        $project = Project::find($id);
        if ($project) {

            return response()->json(['project' => $project], $this->successStatus);
        } else {
            return response()->json(['message' => "No project found"], 401);
        }
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
           
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }
        $input = $request->all();
        $input['created_by'] = Auth::user()->id;
        $project = Project::create($input);
        $success['name'] =  $project->name;
        return response()->json(['success' => $success, 'message' => "Project Created"], $this->successStatus);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }

        $project = Project::find($id);
        if ($project) {

            $input = $request->all();
            $input['created_by'] = Auth::user()->id;
            $project->update($input);
            $success['name'] =  $project->name;

            return response()->json(['success' => $success, 'message'=> "Project Updated"], $this->successStatus);
        } else {
            return response()->json(['message' => "No Project found"], 401);
        }
    }

    public function delete($id){
        Project::where('id',$id)->delete();
        return response()->json([ 'message'=> "Project Deleted"], $this->successStatus);

    }
}
