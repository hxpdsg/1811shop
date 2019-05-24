<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
	protected  $table = 'brand';
	protected $primaryKey = 'brand_id';
	public $timestamps = false;
	protected  $fillable = [
	'brand_name',
	'brand_desc',
	'brand_logo',
	'brand_url',
	];
}
