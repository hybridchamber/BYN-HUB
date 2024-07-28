<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Demographic extends Model
{
    use HasFactory;

    protected $fillable = [
        'youth_profile_id',
        'civil_status',
        'youth_age_group',
        'educational_background',
        'youth_classification',
        'specific_needs_detail',
        'work_status',
        'registered_sk_voter',
        'registered_national_voter',
        'sk_assembly',
        'sk_assembly_times_attended',
        'sk_assembly_not_attended',
        'vote_last_sk_election'
    ];

    // Define the relationship with YouthProfile
    public function youthProfile()
    {
        return $this->belongsTo(YouthProfile::class, 'youth_profile_id');
    }
}
