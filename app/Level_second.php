<?php

namespace App;

use App\Level_first;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Level_second extends Model
{
    use Sortable;

    protected $fillable = [
        'id',
        'name',
        'level_first_id'
    ];

    public $sortable = [
        'id',
        'name',
        'level_first_id',
        'created_at',
        'updated_at',
    ];

    public function level(){
        return $this->hasOne(Level_first::class,'id','level_first_id');
    }
}


