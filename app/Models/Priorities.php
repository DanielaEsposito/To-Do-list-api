<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Priorities extends Model
{

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
}
