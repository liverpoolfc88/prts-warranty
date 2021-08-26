<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProblemActions extends Model
{
    protected $fillable = [
        'id',
        'problem_id',
        'user_id',
        'stage_id',
        'content',
        'attachment',
        'accepted',
        'deadline_at',
        'email_status'
    ];

    public function problem(){
        return $this->belongsTo(Problem::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function stage(){
        return $this->belongsTo(Stage::class);
    }
}
