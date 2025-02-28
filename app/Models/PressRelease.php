<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PressRelease extends Model
{
    protected $fillable = ['title', 'date', 'time','press_uuid'];

    public function contents()
    {
        return $this->hasMany(PressReleaseContent::class);
    }
}
