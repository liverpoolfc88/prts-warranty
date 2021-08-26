<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Kyslik\ColumnSortable\Sortable;
use Zizaco\Entrust\Traits\EntrustUserTrait;

class User extends Authenticatable
{
    use EntrustUserTrait  { restore as private restoreA; }
    use Notifiable;
    use SoftDeletes  { restore as private restoreB; }
    use Sortable;

    const ROLE_EMPLOYEE     = 0;
    const ROLE_SUPPLIER     = 1;

    // solved collision
    public function restore()
    {
        $this->restoreA();
        $this->restoreB();
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'role', 'phone_number'
    ];

    public $sortable = [
        'name',
        'email',
        'phone_number',
        'role',
    ];

    protected $dates = ['deleted_at'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function departments()
    {
        return $this->belongsToMany(Department::class);
    }
}
