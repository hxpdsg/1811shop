<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Register extends Model
{
    protected  $table = 'register';
	protected $primaryKey = 'r_id';
	public $timestamps = false;
	protected  $fillable = [
	'email',
	'code',
	'pwd',
	];
}
