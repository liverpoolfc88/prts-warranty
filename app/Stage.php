<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Stage extends Model
{
    protected $fillable = [
        'title',
        'sequence',
        'stage_group_id',
        'has_action',
        'has_date',
        'has_attachment',
        'has_approval',
        'owner'
    ];

    public function stageGroup(){
        return $this->belongsTo(StageGroup::class);
    }
}
