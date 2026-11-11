<?php

namespace App\Http\Requests\Owner;

use Illuminate\Foundation\Http\FormRequest;

class StoreOccupancyRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isOwner() ?? false;
    }

    public function rules(): array
    {
        return [
            'room_id' => ['required', 'exists:rooms,id'],
            'user_id' => ['required', 'exists:users,id'],
            'agreed_price' => ['required', 'numeric', 'min:0'],
            'start_date' => ['required', 'date'],
        ];
    }
}