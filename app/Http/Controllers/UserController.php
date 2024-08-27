<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function show(User $user)
    {
        return response()->json($user);
    }

    public function projects($id)
    {
        $query = Project::query();
        if (request()->search) {
            $query->where("name", 'like', '%' . request()->search . '%');
        }
        $projects = $query->where("user_id", $id)->orderBy("id", "desc")->with("tasks")->get();
        return response()->json($projects);
    }
}
