<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUpdateProject;
use App\Models\Project;
use App\Models\Task;

class ProjectController extends Controller
{
    public function show($id)
    {
        $project = Project::with("tasks")->find($id);
        return response()->json($project);
    }

    public function create(CreateUpdateProject $request)
    {
        $project = Project::create($request->validated());
        return response()->json($project);
    }

    public function update(Project $project, CreateUpdateProject $request)
    {
        $project->update($request->validated());
        return response()->json($project);
    }

    public function delete(Project $project)
    {
        $status = $project->delete();
        return response()->json([
            "status" => $status
        ]);
    }

    public function createTask($project_id,CreateUpdateProject $request)
    {
        $task = Task::create(array_merge($request->validated(), [
            "project_id" => $project_id
        ]));
        return response()->json($task);
    }

    public function updateTask($project_id, Task $task, CreateUpdateProject $request)
    {
        if ($task->project_id != $project_id) {
            return response()->isNotFound();
        }
        $task->update($request->validated());
        return response()->json($task);
    }

    public function deleteTask($project_id, Task $task)
    {
        if ($task->project_id != $project_id) {
            return response()->isNotFound();
        }
        $status = $task->delete();
        return response()->json([
            "status" => $status
        ]);
    }
}
