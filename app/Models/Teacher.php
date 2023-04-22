<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name', 'email', 'profile_image'
    ];

    public function myStudent()
    {
    	return $this->belongsToMany('App\Models\Student', 'teacher_student', 'teacher_id', 'student_id')->withPivot('id');
    }


}
