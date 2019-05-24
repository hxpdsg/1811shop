<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected  $table = 'article';
	protected $primaryKey = 'article_id';
	public $timestamps = false;
	protected  $fillable = [
	'article_title',
	'classify_id',
	'is_sign',
	'is_show',
	'article_name',
	'article_email',
	'article_keyword',
	'article_desc',
	'article_img',
	'created_at',
	'updated_at',


	];

}
