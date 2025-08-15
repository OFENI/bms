<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Donor;
use App\Models\UserDetail;
use App\Models\Donation;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'email',
        'password',
        'role',
        'institution_id',
        'status',
        'two_factor_enabled',
        'created_by',
        'created_on',
        'updated_by',
        'updated_on',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'created_on' => 'datetime',
        'updated_on' => 'datetime',
        'two_factor_enabled' => 'boolean',
    ];

    protected $appends = [
        'full_name',
    ];

    // ✅ Single, correct relationship for user details
    public function detail()
    {
        return $this->hasOne(UserDetail::class, 'user_id');
    }
    

public function details()
{
    return $this->hasOne(\App\Models\UserDetail::class, 'user_id');
}


    public function donor()
    {
        return $this->hasOne(Donor::class);
    }

    public function donations()
    {
        return $this->hasMany(\App\Models\Donation::class, 'user_id');
    }
    

    public function createdBy()
    {
        return $this->belongsTo(self::class, 'created_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo(self::class, 'updated_by');
    }

    public function getFullNameAttribute(): string
    {
        if ($this->detail) {
            return trim($this->detail->first_name . ' ' . $this->detail->last_name);
        }
        return '';
    }

    public function scopeFilter(Builder $query, array $filters): Builder
    {
        if (!empty($filters['search'] ?? '')) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('email', 'like', "%{$search}%")
                  ->orWhereHas('detail', function ($q2) use ($search) {
                      $q2->where('first_name', 'like', "%{$search}%")
                         ->orWhere('last_name', 'like', "%{$search}%");
                  });
            });
        }

        if (!empty($filters['role'] ?? '')) {
            $query->where('role', $filters['role']);
        }

        if (!empty($filters['status'] ?? '')) {
            $query->where('status', $filters['status']);
        }

        return $query;
    }

    public function institution()
    {
        return $this->belongsTo(Institution::class);
    }
    

}
