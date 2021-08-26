<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class VehicleModel extends Model
{
    use Sortable;

    protected $fillable = [
        'name',
	    'responsible_email'
    ];

    public $sortable = [
        'name',
	    'responsible_email',
        'created_by',
        'updated_at',
    ];
}
