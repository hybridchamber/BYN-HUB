<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class YouthProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'middle_name',
        'last_name',
        'suffix',
        'region',
        'province',
        'municipality',
        'baranggay',
        'purok',
        'sex',
        'age',
        'birthdate',
        'email',
        'contact_no'
    ];

    // Define the relationship with Demographic
    public function demographic()
    {
        return $this->hasOne(Demographic::class, 'youth_profile_id');
    }
}
