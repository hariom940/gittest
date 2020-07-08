<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
     protected $fillable = [
       'task_name', 'name', 'Due_Date', 'Status', 'Date', 'sub_task', 'created_at', 'updated_at'
    ];
}
