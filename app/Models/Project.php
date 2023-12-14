<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use App\Models\Task;

class Project extends Model
{
    use HasUlids,HasFactory;

    protected $fillable = ['name', 'description', 'start_date', 'end_date'];

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
}
