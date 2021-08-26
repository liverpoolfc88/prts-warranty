<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Department extends Model
{
    use Sortable;

    protected $fillable = [
        'name',
    ];

    public function problems(){
        return $this->hasMany(Problem::class);
    }

    public function users(){
        return $this->belongsToMany(User::class, 'department_user');
    }

    public $sortable = [
        'name',
        'manager',
        'email'
    ];
}
