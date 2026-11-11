<?php

namespace App\Services;

use App\Models\ActivityLog;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class ActivityLogger
{
    public static function log(string $action, ?Model $model = null, array $changes = []): void
    {
        // Keamanan: Pastikan data sensitif tidak pernah ikut tercatat di log
        unset($changes['password'], $changes['remember_token'], $changes['_token']);

        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => $action,
            'model_type' => $model ? get_class($model) : null,
            'model_id' => $model ? $model->getKey() : null,
            'changes' => !empty($changes) ? $changes : null,
            'ip_address' => Request::ip(),
            'user_agent' => Request::userAgent(),
        ]);
    }
}