<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Resources\TasksResource;
use App\Models\Task;
use Illuminate\Http\Request;
use App\Traits\HttpResponses;
use Illuminate\Support\Facades\Auth;

class TasksController extends Controller
{

       use HttpResponses;

    public function index()
    {
        return TasksResource::collection(
            Task::where('id' , Auth::user()->id)->get()
        );
    }


    public function store(StoreTaskRequest $request)
    {
        //
        $request->validated($request->all());
        $task = Task::create([
            'user_id'=> Auth::user()->id ,
            'name'=> $request->name ,
            'description'=> $request->description ,
            'priority'=> $request->priority ,
        ]);

        if($task){
            return new TasksResource($task);
        }
        else{

        return  $this->error(null , 'something went wrong' , null);

        }

    }

    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        //
    }


    public function update(Request $request, $id)
    {
        //
    }


    public function destroy($id)
    {
        //


    }
}
