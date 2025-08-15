<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    use HasFactory;

    /**
     * Explicit table name since the DB table is singular 'inventory'.
     */
    protected $table = 'inventory';

    /**
     * Disable automatic timestamps if your table uses custom timestamp columns.
     */
    public $timestamps = false;

    /**
     * Mass assignable attributes.
     */
    protected $fillable = [
        'institution_id',
        'blood_group_id',
        'quantity',
        'collected_date',
        'expiry_date',
        'created_by',
        'created_on',
        'updated_by',
        'updated_on',
    ];

    /**
     * Relationship: Inventory belongs to an Institution.
     */
    public function institution()
    {
        return $this->belongsTo(Institution::class);
    }

    /**
     * Relationship: Inventory belongs to a BloodGroup.
     */
    public function bloodGroup()
    {
        return $this->belongsTo(\App\Models\BloodGroup::class);
    }

    /**
     * Relationship: Who created this record.
     */
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Relationship: Who last updated this record.
     */
    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function donation()
    {
        return $this->hasOne(Donation::class, 'institution_id', 'institution_id')
            ->latest()
            ->whereHas('user.details', function ($q) {
                $q->where('blood_type', $this->bloodGroup->name);
            });
    }

    /**
     * Add to $casts for proper date handling.
     */
    protected $casts = [
        'collected_date' => 'date',
        'expiry_date' => 'date',
    ];
}
