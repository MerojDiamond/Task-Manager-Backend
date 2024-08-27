<?php

namespace App\Http\Requests;

class CreateUpdateProject extends MainRequest
{
    public function rules(): array
    {
        return [
            "user_id" => "required|exists:users,id",
            "name" => "required|string",
            "description" => "string",
        ];
    }
}
