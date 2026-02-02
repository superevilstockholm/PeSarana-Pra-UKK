<?php

namespace App\Models\MasterData;

use Illuminate\Database\Eloquent\Model;

class Classroom extends Model
{
    protected $table = 'classrooms';

    protected $fillable = [
        'name',
        'description'
    ];
}
