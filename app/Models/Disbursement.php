<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Disbursement extends Model
{
    use HasFactory;

    protected $fillable = [
        'blood_request_id',
        'institution_id',
        'blood_group_id',
        'quantity',
        'disbursed_date',
        'status',
        'created_by',
        'updated_by',
        'created_on',
        'updated_on',
    ];

    protected $table = 'disbursements';

    // Cast disbursed_date to Carbon instance for formatting
    protected $casts = [
        'disbursed_date' => 'datetime',
    ];

    // Relationship to BloodRequest
    public function bloodRequest()
    {
        return $this->belongsTo(BloodRequest::class);
    }

    // Relationship to Institution
    public function institution()
    {
        return $this->belongsTo(Institution::class);
    }

    // Relationship to BloodGroup
    public function bloodGroup()
    {
        return $this->belongsTo(BloodGroup::class);
    }

    public function fromInstitution() {
        return $this->belongsTo(Institution::class, 'institution_id');
    }
    

    public function receiverInstitution()
    {
        return $this->belongsTo(\App\Models\Institution::class, 'institution_id');
    }
    

}
