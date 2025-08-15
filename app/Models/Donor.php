<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Donor extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'institution_id',
        'blood_group_id',
        'weight',
        'last_donation_date',
        'created_by',
        'created_on',
        'updated_by',
        'updated_on',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function institution()
    {
        return $this->belongsTo(Institution::class);
    }

    public function bloodGroup()
    {
        return $this->belongsTo(BloodGroup::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function donations()
    {
        // If your Donor table has `user_id` column pointing to users.id:
        return $this->hasMany(\App\Models\Donation::class, 'user_id', 'user_id');
    }

    public function userDetail()
    {
        return $this->hasOne(\App\Models\UserDetail::class, 'user_id', 'user_id');
    }

    // In User.php or Donor.php



    
}
