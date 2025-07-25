<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    use HasFactory;
    
    protected $table = 'job_listings';
    
    protected $fillable = [
        'title',
        'category_id', 
        'job_type_id',
        'user_id',
        'vacancy',
        'salary',
        'location',
        'description',
        'benefits',
        'responsibility',
        'qualifications',
        'keywords',
        'experience',
        'company_name',
        'company_location',
        'company_website',
        'isFeatured'
    ];

    public function jobType()
    {
        return $this->belongsTo(JobType::class, 'job_type_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function applications()
    {
        return $this->hasMany(JobApplication::class, 'job_id');
    }

    public function getExperienceFormattedAttribute()
    {
        if ($this->experience === '8_plus') {
            return '8+ years';
        }

        if ($this->experience == 1) {
            return '1 year';
        }

        if ($this->experience == 2) {
            return '2 years';
        }

        if ($this->experience == 3) {
            return '3 years';
        }

        if ($this->experience == 4) {
            return '4 years';
        }

        if ($this->experience == 5) {
            return '5 years';
        }

        if ($this->experience == 6) {
            return '6 years';
        }

        if ($this->experience == 7) {
            return '7 years';
        }
        if ($this->experience == 0 || $this->experience === '0') {
            return 'No experience';
        }

        return $this->experience;
    }
}
