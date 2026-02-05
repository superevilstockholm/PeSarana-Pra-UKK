<?php

namespace App\Models\MasterData;

use Illuminate\Database\Eloquent\Model;

// Models
use App\Models\MasterData\Student;
use App\Models\MasterData\Category;
use App\Models\MasterData\AspirationImage;

// Enums
use App\Enums\AspirationStatusEnum;
use Illuminate\Support\Facades\Storage;

class Aspiration extends Model
{
    protected $table = 'aspirations';

    protected $fillable = [
        'cover_image_path',
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

    protected $appends = [
        'cover_image_path_url'
    ];

    public function getCoverImagePathUrlAttribute(): string
    {
        return $this->cover_image_path
            ? Storage::url($this->cover_image_path)
            : asset('static/img/no-image-placeholder.svg');
    }

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
