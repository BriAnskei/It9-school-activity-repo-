<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    // Allow mass assignment for these fields
    protected $fillable = [
        'FirstName',
        'LastName',
        'Job',
        'Salary',
    ];
}