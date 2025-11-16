<?php

namespace App\Http\Controllers;

use App\Http\Requests\Task\ReorderTaskRequest;
use App\Http\Requests\Task\StoreTaskRequest;
use App\Http\Requests\Task\UpdateTaskRequest;
use App\Models\Project;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Display a listing of the tasks, filtered by project.
     */
    public function index(Request $request)
    {
        $projects = Project::all();

        $selectedProjectId = $request->integer('project_id')
            ?: optional($projects->first())->id;

        if (!$selectedProjectId) {
            return view('tasks.index', [
                'tasks' => collect(),
                'projects' => $projects,
                'selectedProjectId' => null,
            ]);
        }

        try {
            $tasks = Task::forProject($selectedProjectId);

            return view('tasks.index', [
                'tasks' => $tasks,
                'projects' => $projects,
                'selectedProjectId' => $selectedProjectId,
            ]);
        } catch (\Throwable $e) {

            return view('tasks.index', [
                'tasks' => collect(),
                'projects' => $projects,
                'selectedProjectId' => $selectedProjectId,
            ])->with('error', 'Unable to load tasks at this time.');
        }
    }


    /**
     * Store a newly created task in storage.
     */
    public function store(StoreTaskRequest $request)
    {
        $validated = $request->validated();

        try {
            Task::createWithNextPriority($validated);

            return back()->with('success', 'Task created successfully.');
        } catch (\Throwable $e) {
            return back()->with('error', 'Something went wrong while creating the task.');
        }
    }


    /**
     * Update the specified task (e.g., its name).
     */
    public function update(UpdateTaskRequest $request, Task $task)
    {
        $validated = $request->validated();

        try {
            $task->updateName($validated['name']);

            return back()->with('success', 'Task updated successfully.');
        } catch (\Throwable $e) {

            return back()->with('error', 'Something went wrong while updating the task.');
        }
    }

    /**
     * Remove the specified task from storage.
     */
    public function destroy(Task $task)
    {
        try {
            $task->delete();
            return back()->with('success', 'Task deleted successfully.');
        } catch (\Throwable $e) {
            return back()->with('error', 'Something went wrong while deleting the task.');
        }
    }


    /**
     * Reorder tasks based on drag-and-drop.
     */

    public function reorder(ReorderTaskRequest $request)
    {
        $taskIds = $request->validated()['taskIds'];

        try {
            Task::reorder($taskIds);

            return response()->json(['status' => 'success']);
        } catch (\Throwable $e) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Unable to reorder tasks at this time.',
            ], 500);
        }
    }}
