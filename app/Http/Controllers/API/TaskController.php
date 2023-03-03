<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;

class TaskController extends Controller
{
    public $successStatus = 200;

    public function index()
    {
        $tasks = Task::all();
        return response()->json(['tasks' => $tasks], $this->successStatus);
    }
    public function details($id){
        $task = Task::find($id);
        if ($task) {

            return response()->json(['task' => $task], $this->successStatus);
        } else {
            return response()->json(['message' => "No task found"], 401);
        }
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'description' => 'required',
            'project_id' => 'required',
            'user_id' => 'required',
            
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }
        $input = $request->all();
        $input['created_by'] = Auth::user()->id;
        $task = Task::create($input);
        $success['name'] =  $task->title;
        return response()->json(['success' => $success, 'message' => "Task Created"], $this->successStatus);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'description' => 'required',
            'status_id' => 'required',
            'project_id' => 'required',
            'user_id' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }

        $task = Task::find($id);
        if ($task) {

            $input = $request->all();
            $input['created_by'] = Auth::user()->id;
            $task->update($input);
            $success['task'] =  $task;

            return response()->json(['success' => $success, 'message'=> "Task Updated"], $this->successStatus);
        } else {
            return response()->json(['message' => "No Task found"], 401);
        }
    }

    public function delete($id){
        Task::where('id',$id)->delete();
        return response()->json([ 'message'=> "Task Deleted"], $this->successStatus);

    }

    public function update_status(Request $request, $id){
        $validator = Validator::make($request->all(), [
            'status_id' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }

        $task = Task::find($id);
        if ($task) {
            if($task->user_id == Auth::user()->id || Auth::user()->role_id == 2){

                $task->status_id = $request->status_id; 
                $task->save();
    
                $success['name'] =  $task->name;
    
                return response()->json(['success' => $success, 'message'=> "Task Updated"], $this->successStatus);
            }else{
                
                return response()->json(['message' => "User Not Authorized"], 401);

            }
        } else {
            return response()->json(['message' => "No Task found"], 401);
        }
    }
}
