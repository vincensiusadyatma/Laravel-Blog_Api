<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PressReleaseContent extends Model
{
    protected $fillable = ['press_release_id', 'image_url', 'content'];

    public function pressRelease()
    {
        return $this->belongsTo(PressRelease::class);
    }
}
