<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateUpdateTask extends MainRequest
{
    public function rules(): array
    {
        return [
            "user_id" => "required|exists:users,id",
            "project_id" => "required|exists:projects,id",
            "name" => "required|string",
            "description" => "string",
            "status" => "string|in:backlog,wip,done,canceled",
        ];
    }
}
