<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Carrer extends Model
{
    protected $fillable = ['carrer_uuid', 'image_url', 'deskripsi', 'link'];
}
