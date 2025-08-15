<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Institution;
use App\Models\BloodGroup;
use App\Models\User;

class BloodRequest extends Model
{
    use HasFactory;

    /**
     * Mass assignable attributes.
     */
    protected $fillable = [
        'requester_id',        // who made the request (institution ID)
        'requested_from_id',    // which institution the request is sent to
        'blood_group_id',
        'quantity',
        'urgency_level',
        'notes',
        'status',
        'requested_date',
        'fulfilled_date',
        'requested_by',
        'created_by',
        'created_on',
        'updated_by',
        'updated_on',
    ];

    /**
     * Relationship: the institution that this request belongs to (as requester)
     */
    public function institution()
    {
        return $this->belongsTo(Institution::class, 'requester_id');
    }

    /**
     * Relationship: the institution from which blood is requested
     */
    public function requestedFromInstitution()
    {
        return $this->belongsTo(Institution::class, 'requested_from_id');
    }

    /**
     * Relationship: the blood group of this request
     */
    public function bloodGroup()
    {
        return $this->belongsTo(BloodGroup::class, 'blood_group_id');
    }

    /**
     * Relationship: user who created record
     */
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Relationship: user who last updated record
     */
    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    /**
 * The hospital (institution) that made this request.
 */


    public function requestedBy()
    {
        return $this->belongsTo(User::class, 'requested_by');
    }

    public function requesterInstitution() 
    {
        return $this->belongsTo(Institution::class, 'requester_id');
    }

    public function requestedFrom() {
        return $this->belongsTo(Institution::class, 'requested_from_id');
    }
    public function requestedTo() {
        return $this->belongsTo(Institution::class, 'requested_to_id');
    }
    


}
