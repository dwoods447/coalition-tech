<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //

        $tasks = Task::all();
         return response()->json(["tasks" => $tasks]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        //

        $task = new Task();
        $title = strip_tags($request->title);
        $content = strip_tags($request->content);
        $task->title = $title;
        $task->content = $content;
        $task->save();

        return response()->json(["response"]);
    }


    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
      $task = Task::find($request->task_id);  
      return response()->json(["task" => $task]);
    }

    /**
     * Update the resource.
     */
    public function edit(Request $request)
    {
        //
       $task = Task::find($request->task_id);
       if(!isset($task)) return response()->json(['message' => 'error message'], 500);
       if(isset($request->title)){
             $title = strip_tags($request->title);
             $task->title = $title;
        }
        if(isset($request->content)){
             $content = strip_tags($request->content);
             $task->content = $content;
        }
        $task->save();
        return response()->json(["task" => $task]);
    }

  
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        //
        $task = Task::find($request->task_id);
        $task->delete();
    }
}
