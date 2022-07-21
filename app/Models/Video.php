<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Video extends Model {
    use HasFactory;

    protected $table = 'videos';

    // relacion One to Many
    public function comments() {

        return $this->hasMany('App\Models\Comment')->orderBy('id', 'desc');

    }

    // relacion Many to One
    public function user() {

        return $this->belongsTo('App\Models\User', 'user_id');

    }
}
