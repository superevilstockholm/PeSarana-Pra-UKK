<?php

namespace App\Models\MasterData;

use Illuminate\Database\Eloquent\Model;

// Models
use App\Models\MasterData\Student;
use App\Models\MasterData\Category;
use App\Models\MasterData\AspirationImage;

// Enums
use App\Enums\AspirationStatusEnum;

class Aspiration extends Model
{
    protected $table = 'aspirations';

    protected $fillable = [
        'title',
        'content',
        'location',
        'status',
        'student_id',
        'category_id',
    ];

    protected $casts = [
        'status' => AspirationStatusEnum::class,
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function aspiration_images()
    {
        return $this->hasMany(AspirationImage::class);
    }
}
