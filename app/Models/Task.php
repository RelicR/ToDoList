<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Task extends Model
{
    protected $fillable = [
        'task',
        'description',
        'is_urgent',
        'task_create',
        'task_done',
        'user_id',
    ];
    protected $hidden = [
        'user_id',
    ];
    protected $casts = [
        'is_urgent' => 'boolean',
        'task_create' => 'timestamp',
        'task_done' => 'timestamp',
        'user_id' => 'integer',
    ];
}
