<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StageGroup extends Model
{
    protected $fillable = [
        'title', 'sequence'
    ];

    public function stages(){
        return $this->hasMany(Stage::class);
    }
}
