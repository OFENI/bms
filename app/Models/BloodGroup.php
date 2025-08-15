<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BloodGroup extends Model
{
    use HasFactory;

    protected $table = 'blood_groups';

    protected $fillable = [
        'name',         // like 'A+', 'O-', etc.
        'created_by',
        'created_on',
        'updated_by',
        'updated_on',
    ];

    // Relationships

    public function donors()
    {
        return $this->hasMany(Donor::class);
    }

    public function donations()
    {
        return $this->hasMany(Donation::class);
    }

    public function bloodRequests()
    {
        return $this->hasMany(BloodRequest::class);
    }

    public function inventories()
    {
        return $this->hasMany(Inventory::class);
    }
}
