<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Habit extends Model
{
    use HasFactory;

    protected $fillable = [
        'habit_name',
        'description',
        'category',
        'priority',
        'status',
        'due_date',
        'streak',
    ];
}