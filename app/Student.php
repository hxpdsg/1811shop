<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
   protected  $table = 'student';
	protected $primaryKey = 'student_id';
	public $timestamps = false;
	protected  $fillable = [
	'student_name',
	'student_age',
	'student_tel',
	];
}
