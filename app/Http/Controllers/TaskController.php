<?php

namespace App\Http\Controllers;

use App\Models\Tasks;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class TaskController extends Controller
{
    public function index()
    {
        $lowPriorityTask = Tasks::where('priority','Low')->orderBy('updated_at','desc')->get();
        $mediumPriorityTask = Tasks::where('priority','Medium')->orderBy('updated_at','desc')->get();
        $highPriorityTask = Tasks::where('priority','High')->orderBy('updated_at','desc')->get();
        $data = [
            'lowPriorityTask' => $lowPriorityTask,
            'mediumPriorityTask' => $mediumPriorityTask,
            'highPriorityTask' => $highPriorityTask
        ]; 
    	return view('task-index',$data);
    }

    public function addTask()
    {
        return view('task-form');
    }

    public function store(Request $request) {
        
        $request->validate([
            'name' => 'required|string|max:255',
            'priority' => 'required',
            'image' => 'nullable|image|mimes:png,jpg,jpe'
        ]);

        if($request->hasFile('image')){
            $file = $request->file('image');
            $fileName = time().'_'.$file->getClientOriginalName();
            $file->storeAs('task-image',$fileName,'public');
        }

        $task = new Tasks();
        $task->name = trim($request->name);
        $task->description = trim($request->description);
        $task->priority = $request->priority;
        $task->image = $fileName ?? '';
        $task->completed = false;
        if($task->save()) {
            Session::flash('success','Task Added Successfully');
            return redirect('/');
        } else {
            Session::flash('error','Task Not Added. PLease try again.');
            return redirect()->back();
        }
    }

    public function updateTaskPriority(Request $request) {
        try {
            $task = Tasks::find($request->task_id);
            $task->priority = $request->task_new_priority;
            $task->save();
            return redirect()->back();
        } catch (\Exception $e) {

        }
    }

    public function editTask(Request $request) {
        $task = Tasks::find($request->task_id);
        if(empty($task)) {
            Session::flash('error','Task not found');
            return redirect()->back();
        }
        return view('edit-task',['task'=>$task]);
    }

    public function updateTask(Request $request) {
        $request->validate([
            'name' => 'required|string|max:255',
            'priority' => 'required',
            'image' => 'nullable|image|mimes:png,jpg,jpe'
        ]);
        $task = Tasks::find($request->task_id);
        
        if($request->hasFile('image')){
            $file = $request->file('image');
            $fileName = time().'_'.$file->getClientOriginalName();
            $file->storeAs('task-image',$fileName,'public');
            $path =storage_path('task-image/'.$task->image);
            if(file_exists($path))
                unlink($path);
        }
        $task->name = trim($request->name);
        $task->description = trim($request->description);
        $task->priority = $request->priority;
        if($request->hasFile('image')){
            $task->image = $fileName;
        }
        $task->completed = $request->completed;
        if($task->save()) {
            Session::flash('success','Task Updated Successfully');
            return redirect('/');
        } else {
            Session::flash('error','Task Not Added. PLease try again.');
            return redirect()->back();
        }
    }

    public function deleteTask(Request $request) {
        $task = Tasks::find($request->task_id);
        if($task->delete()) {
            return 1;
        } else {
            return 0;
        }
    }
}
