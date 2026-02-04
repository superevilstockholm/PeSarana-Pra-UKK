<?php

namespace App\Models\MasterData;

use Illuminate\Database\Eloquent\Model;

// Models
use App\Models\MasterData\Student;

class Classroom extends Model
{
    protected $table = 'classrooms';

    protected $fillable = [
        'name',
        'description'
    ];

    public function students()
    {
        return $this->hasMany(Student::class);
    }
}
