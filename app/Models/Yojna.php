<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Yojna extends Model
{
    public $table = 'yojnas';
    public $timestamps = true;

    protected $fillable = ['name','attachment','type_attachment', 'attachment_link'];
}
