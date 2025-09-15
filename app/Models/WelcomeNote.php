<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WelcomeNote extends Model
{
    public $table = 'welcome_notes';
    public $timestamps = true;

    protected $fillable = ['title', 'content'];
}
