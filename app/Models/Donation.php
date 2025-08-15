<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Donation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'institution_id',
        'blood_group_id',
        'volume_ml',
        'donation_date',
        'created_by',
        'created_on',
        'updated_by',
        'updated_on',
    ];

 public function user()
{
    return $this->belongsTo(User::class, 'user_id');
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






}
