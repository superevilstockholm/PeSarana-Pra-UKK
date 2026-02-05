<?php

namespace App\Models\MasterData;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

// Models
use App\Models\MasterData\Aspiration;

class AspirationImage extends Model
{
    protected $table = 'aspiration_images';

    protected $fillable = [
        'image_path',
        'aspiration_id'
    ];

    protected $appends = [
        'image_path_url'
    ];

    public function getImagePathUrlAttribute(): string
    {
        return $this->image_path
            ? Storage::url($this->image_path)
            : asset('static/img/no-image-placeholder.svg');
    }

    public function aspiration()
    {
        return $this->belongsTo(Aspiration::class);
    }
}
