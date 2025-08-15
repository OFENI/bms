<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class UserDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'phone_number',
        'date_of_birth',
        'blood_type',
        'weight_lbs',
        'address',
        'created_by',
        'created_on',
        'updated_by',
        'updated_on',
        'custom_id', // <-- our new field
    ];

    protected static function booted()
    {
        static::creating(function ($detail) {
            // Don’t overwrite if someone manually set it
            if ($detail->custom_id) {
                return;
            }

            // Fetch the user to read its role
            $user = User::find($detail->user_id);
            $suffix = ($user && $user->role === 'donor') ? 'BD' : 'ED';

            // Generate until unique
            do {
                $random = random_int(100000, 999999);
                $candidate = $random . '-' . $suffix;
            } while (self::where('custom_id', $candidate)->exists());

            $detail->custom_id = $candidate;
        });
    }
    protected $table = 'user_details';

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function bloodGroup()
{
    return $this->belongsTo(BloodGroup::class, 'blood_group_id');
}

}
