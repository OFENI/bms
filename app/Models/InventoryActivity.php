<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryActivity extends Model
{
    use HasFactory;

    protected $fillable = [
        'inventory_id',
        'institution_id',
        'blood_group_id',
        'action',
        'description',
        'created_by',
    ];
    


    public function bloodGroup()
    {
        return $this->belongsTo(BloodGroup::class);
    }

    public function institution()
    {
        return $this->belongsTo(Institution::class);
    }

    public function inventory()
{
    return $this->belongsTo(Inventory::class);
}



}
