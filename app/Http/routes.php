<?php

Route::get('/', 'PagesController@index');
//Route::get('pages/hub/{hub_slug}', 'PagesController@hub_index');

//Menu
Route::get('/menus', 'MenusController@index');
/*Route::get('/continents/create', 'ContinentsController@create');
Route::post('continents/store', 'ContinentsController@store');
Route::resource('continents', 'ContinentsController');
*/
//Continent
Route::get('/continents/index', 'ContinentsController@index');
Route::get('/continents/create', 'ContinentsController@create');
Route::post('continents/store', 'ContinentsController@store');
Route::resource('continents', 'ContinentsController');

//Country
Route::get('/countries/index', 'CountriesController@index');
Route::get('/countries/create', 'CountriesController@create');
Route::post('countries/store', 'CountriesController@store');


Route::get('/countries/hub_country_category/{hub_id}/{country_id}', 'CountriesController@hub_country_category');
Route::get('/countries/hub_country_category_view/{hub_id}/{country_id}', 'CountriesController@hub_country_category_view');
Route::patch('countries/hub_country_category_update/{country_hub_id}', [
	'uses' => 'CountriesController@hub_country_category_update', 
	'as' => 'hub_country_category_update'
]);
Route::put('countries/country_in_main_menu', [
	'uses' => 'CountriesController@country_in_main_menu', 
	'as' => 'country_in_main_menu'
]);
Route::put('countries/cnt_category_in_main_menu', [
	'uses' => 'CountriesController@cnt_category_in_main_menu', 
	'as' => 'cnt_category_in_main_menu'
]);
Route::resource('countries', 'CountriesController');
Route::get('country/{hub_slug}/{country_slug}', 'PagesController@country');
Route::get('country/{hub_slug}/{country_slug}/{category_slug}', 'PagesController@hub_country_category_news');

//Hub
Route::get('/hubs/index', 'HubsController@index');
Route::get('/hubs/create', 'HubsController@create');
Route::post('hubs/store', 'HubsController@store');
Route::get('/hubs/menu', 'HubsController@menu');
Route::resource('hubs', 'HubsController');
Route::get('hub/{hub_slug}', 'PagesController@hub_index');
Route::get('hub/{hub_slug}/{category_slug}', 'CategoriesController@show_hub_category_news');

//Route::get('hub/{hub_slug}/{category_slug}/{country_slug}', 'CategoriesController@show_hub_category_country_news');

//Category
Route::get('/categories/index', 'CategoriesController@index');
Route::get('/categories/create', 'CategoriesController@create');
Route::post('categories/store', 'CategoriesController@store');
Route::put('categories/in_main_menu', [
	'uses' => 'CategoriesController@in_main_menu', 
	'as' => 'in_main_menu'
]);
Route::resource('categories', 'CategoriesController');
Route::get('category/{category_slug}', 'CategoriesController@show_category_news');

//News
Route::get('/news/index', 'NewsController@index');
Route::get('/news/create', 'NewsController@create');
Route::post('news/store', 'NewsController@store');
Route::resource('news', 'NewsController');
Route::get('news/{date}/{news_slug}', 'NewsController@show');

//Author
Route::get('author_profiles/index', 'AuthorProfilesController@index');
Route::post('author_profiles/store', 'AuthorProfilesController@store');
Route::resource('author_profiles', 'AuthorProfilesController');


