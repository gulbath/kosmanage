<?php

namespace App\Http\Requests\Owner;

use Illuminate\Foundation\Http\FormRequest;

class StoreRoomRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isOwner() ?? false;
    }

    public function rules(): array
    {
        return [
            'room_number' => ['required', 'string', 'max:20', 'unique:rooms,room_number'],
            'type' => ['required', 'string', 'max:50'],
            'price' => ['required', 'numeric', 'min:0'],
            'description' => ['nullable', 'string'],
            'facilities' => ['nullable', 'string'],
            'status' => ['required', 'in:available,occupied,maintenance'],
        ];
    }
}