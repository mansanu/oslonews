<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    protected $fillable = array('name', 'content','publish', 'user_id','position','slug','author_profile_id','front_img');
	
	public function hubs() {

        return $this->belongsToMany('App\Hub');

    } 
	
	public function categories() {

        return $this->belongsToMany('App\Category');

    } 
	
	public function countries() {

        return $this->belongsToMany('App\Country');

    }  
	
	public function types()
    {
        return $this->belongsToMany('App\Type');
    }
	
	public function user()
    {
        return $this->belongsTo('App\User');
    }
	
	public function comments() {

        return $this->hasMany('App\Comment');

    } 
	public function author_profile()
    {
        return $this->belongsTo('App\AuthorProfile');
    }
}