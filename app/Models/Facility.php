<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Facility extends Model
{
    use HasFactory;

    // Table name
    protected $table = 'facility';

    // Primary key
    protected $primaryKey = 'facility_ID';

    // Indicates if the IDs are auto-incrementing
    public $incrementing = true;

    // Key type
    protected $keyType = 'int';

    // Mass assignable fields
    protected $fillable = [
        'name',
        'type',
        'building_ID',
        'status',
    ];

    // Relationships
    public function building()
    {
        return $this->belongsTo(Building::class, 'building_ID', 'building_ID');
    }
}
