<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
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

    public function myTeacher()
    {
    	return $this->belongsToMany('App\Models\Teacher', 'teacher_student', 'student_id', 'teacher_id');
    }

    public function availableStudents()
    {
        // $ids = \DB::table('teacher_student')->where('student_id', '=', $this->id)->lists('student_id');
        // return \Student::whereNotIn('id', $ids)->get();
    }
}
