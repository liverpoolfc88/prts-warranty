<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Region extends Model
{
    use Sortable;

    protected $fillable = [
        'name'
    ];

    public $sortable = [
        'name',
        'created_by',
        'updated_at',
    ];
}
