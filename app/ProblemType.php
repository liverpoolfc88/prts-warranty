<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProblemType extends Model
{
    protected $fillable = [
        'name'
    ];

    public function problems(){
        return $this->hasMany(Problem::class);
    }
}
