<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Dealer extends Model
{
    use Sortable;

    protected $fillable = [
        'name',
        'address',
        'contact'
    ];

    public $sortable = [
        'name',
        'address',
        'contact',
        'created_by',
        'updated_at',
    ];
}
