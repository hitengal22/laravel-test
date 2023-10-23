<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tasks = Task::get()->toArray();
        $tasks = collect($tasks)->mapToGroups(function (array $item, int $key) {
            return [$item['priority'] => ['task' => $item['task'], 'id' => $item['id']]];
        });
        return view('task.index', compact('tasks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('task.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // validate field before uses
        $request->validate([
            'task' => 'required',
            'priority' => 'required'
        ]);

        try {
            DB::beginTransaction();

            // Store Record in database
            Task::create([
                'task' => $request->task,
                'priority' => $request->priority
            ]);

            // Commit query in database
            DB::commit();
            return redirect()->back()->with('success', 'Task created successfully!!');
        } catch (\Throwable $th) {
            Log::debug("LOGS IN CREATE TASK ");
            Log::debug($th);
            DB::rollBack();
            return redirect()->back()->with('fail', 'Something went wrong please try again!!');
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $task = Task::find($id);

        return view('task.edit', compact('task'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $task = Task::find($id);

        return view('task.edit', compact('task'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            DB::beginTransaction();
            Task::where('id', $id)->update([
                'priority' => $request->priority,
                'task' => $request->task
            ]);

            DB::commit();
            return redirect()->back()->with('success', 'Task update successfully');
        } catch (\Throwable $th) {
            Log::debug("UPDATE TASK ERROR");
            LOG::debug($th);
            DB::rollBack();
            return redirect()->back()->with('fail', 'Something went Wrong!!');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Task::find($id)->delete();
        return redirect()->back();
    }

    public function updatePriority(Request $request)
    {

        try {
            DB::beginTransaction();
            Task::where('id', $request->id)->update([
                'priority' => $request->priority
            ]);

            DB::commit();
            return response('Update Successfully', 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response('Something went wrong!!', 400);
        }

    }
}
