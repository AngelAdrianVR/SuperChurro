<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkPermit extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'time_requested',
        'description',
        'status',
        'permission_type_id',
        'user_id',
    ];

    protected $dates = [
        'date',
    ];

    // constants
    const STATUS_IN_CHECKING = 1,
    STATUS_APPROVED = 2,
    STATUS_REJECTED = 3;

    //Relationships
    public function user(){
        return $this->belongsTo(User::class);
    }

    public function permissionType(){
        return $this->belongsTo(PermissionType::class);
    }
}
