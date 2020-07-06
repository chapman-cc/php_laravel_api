<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{
    protected $table = 'todo';
    protected $fillable = ['todo', 'todo_id', 'completed'];
}
