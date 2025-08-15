<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Institution extends Model
{
    use HasFactory;

   protected $fillable = [
    'name',
    'location',
    'email',
    'contact_number',
    'type',
    'region',
    'address',
    'country',
    'opening_time',
    'closing_time',
    'operating_days',
    'auto_accept_transfers',
    'blood_thresholds',
    'created_by',
    'created_on',
];

    protected $casts = [
        'operating_days' => 'array',
        'blood_thresholds' => 'array',
        'auto_accept_transfers' => 'boolean',
    ];


    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function donors()
    {
        return $this->hasMany(Donor::class);
    }

    public function bloodRequests()
    {
        return $this->hasMany(BloodRequest::class);
    }

    public function inventories()
    {
        return $this->hasMany(Inventory::class);
    }

    public function inventory()
    {
        return $this->hasMany(Inventory::class);
    }

    public function inventoryItems()
{
    return $this->hasMany(Inventory::class, 'institution_id');
}

public function donations()
{
    return $this->hasMany(\App\Models\Donation::class);
}

public function user()
{
    return $this->belongsTo(User::class);
}

}

