<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
   
   protected $fillable = array('name','slug','continent_id'); 
	
   public $timestamps = false;
	
   public function continent()
    {
        return $this->belongsTo('App\Continent');
    }
	
	public function categories() {

        return $this->belongsToMany('App\Category');

    }
	public function hubs() {

        return $this->belongsToMany('App\Hub')->withPivot('id','cnt_in_main_menu','cnt_in_front');

    }
	public static function getTopMenuDefaultCountries()
	{
		$countries = Country::where('default_country',1)->get();
		
		return $countries;
	}
	public static function getTopMenuHubCountries($hub_slug)
	{
		
		$hub_id = Hub::where('slug',$hub_slug)->first();
		
		$countries = Hub::find($hub_id->id)->countries()->where('cnt_in_main_menu', '1')->get();
			
		return $countries;
	}
	
	public function getCountryCategories($country_hub_id)
	{
		//$country_hub = CountryHub::find($country_hub_id);//where('hub_id',$country_hub_id)->first();
		//$categories = $country_hub->categories()->get();
		/*$country_hub = CountryHub::where('hub_id',1)
								   ->where('country_id',4)
								   ->first();*/
		$categories = CountryHub::find($country_hub_id)->categories()->get();
		
		return $categories;
	}
}
