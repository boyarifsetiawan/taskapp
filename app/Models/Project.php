<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Project extends Model
{
    use HasFactory;

    const NOT_STARTED = 0;
    const PENDING = 1;
    const COMPLETED = 2;

    protected $guarded = [];

    public static function createSlug($data)
    {
        $code = Str::random(10) . time();
        $slug = Str::slug($data) . '-' . $code;

        return $slug;
    }

    public function task_progress()
    {
        return $this->hasOne(TaskProgress::class, 'projectId');
    }

    public function tasks()
    {
        return $this->hasMany(Task::class, 'projectId');
    }
}
