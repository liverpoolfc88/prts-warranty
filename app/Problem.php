<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Problem extends Model
{
    use Sortable;

    const STATUS_OPEN   = 0;
    const STATUS_CLOSE   = 10;

    protected $fillable = [
        'current_stage_id',
        'department_id',
        'vehicle_model_id',
        'dealer_id',
        'region_id',
        'level_second_id',
        'level_first_id',
        'part_type',
        'part_number',
        'vin',
        'contact_info',
        'problem_type_id',
        'has_penalty',
        'attachment',
        'video_attachment',
        'description',
        'status',
    ];

    public $sortable = [
        'current_stage_id',
        'department_id',
        'vehicle_model_id',
        'dealer_id',
        'region_id',
        'part_type',
        'part_number',
        'vin',
        'contact_info',
        'problem_type_id',
        'has_penalty',
        'description',
        'status',
        'created_by',
        'updated_at',
    ];

    public function stage(){
        return $this->belongsTo(Stage::class,'current_stage_id');
    }

    public function creator(){
        return $this->belongsTo(User::class,'created_by');
    }

    public function department(){
        return $this->belongsTo(Department::class);
    }

    public function dealer(){
        return $this->belongsTo(Dealer::class);
    }

    public function region(){
        return $this->belongsTo(Region::class);
    }

    public function vehicleModel(){
        return $this->belongsTo(VehicleModel::class);
    }


    public function problemType(){
        return $this->belongsTo(ProblemType::class);
    }

    public function problemActions(){
        return $this->hasMany(ProblemActions::class);
    }

    public function completedProblemActions(){
        return $this->hasMany(ProblemActions::class)->whereCompleted(true);
    }

    public function fault_type(){
        return $this->hasOne(Fault_type::class,'id','fault_type_id');
    }
    public function level_second(){
        return $this->hasOne(Level_second::class,'id','level_second_id');
    }


}
