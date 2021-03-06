<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Hub;
use App\Category;
use App\CategoryHub;
use App\Country;
use App\Helpers\CategoryHierarchy;
use Theme;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::getCategories();
		return view('categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(CategoryHierarchy $hierarchy)
    {
        $categories = Category::get();
		
		$hierarchy->setupItems($categories);
		
		$category_opts = $hierarchy->render();
		
		$cat_types = array('1'=>'None','2'=>'column');
		
		//$hubs = Hub::lists('name','id');
		
		//$countries = Country::lists('name','id');
		
		return view('categories.create', compact('category_opts','cat_types'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
		$current_position = Category::get()->max('position');
		
		$new_position = $current_position+1;
		
		$slug = str_slug($request['name']);

		$count = Category::whereRaw("slug RLIKE '^{$slug}(-[0-9]+)?$'")->count();
		
		$request['slug'] = $count ? "{$slug}-{$count}" : $slug;
		
		$category = Category::create([
		   'name'		 => $request['name'],
		   'parent_id' 	 => $request['parent_id'],
		   'position'	 => $new_position,
		   'default_front'    => $request['default_front'],
		   'default_menu'=> $request['default_menu'],
		   'cat_type'	 => $request['cat_type'],
		   'slug'		 => $request['slug']
	   
	   ]);
		//$category->hubs()->attach($request['hub_id']);
		//$category->hubs()->attach($request['hub_id'],['in_front'=>1, 'in_main_menu'=>1]);
		//$category->countries()->attach($request['country_id']);
		
		return redirect('categories/index')->with('message', 'Category Added');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show_category_news($slug)
    {
        $theme = Theme::uses('style1')->layout('category_news');
		
		$category = Category::where('slug', $slug)->first();
		
														
		$first_column_news = $category->news()->where('publish','1')->orderBy('created_at', 'desc')->paginate(21);

		$theme->setTitle($category->name);
		
		$theme->asset()->add('style', url('/css/style1.css'));
		
		//return view('categories.show_default', compact('first_column_news'));
		return $theme->of('categories.show_default',compact('first_column_news'))->render();
    }

	 public function show_hub_category_news($hub_slug,$category_slug)
    {
        $theme = Theme::uses('style1')->layout('hub_category_index');
		
		$hub = Hub::where('slug',$hub_slug)->first();
			
		$category = Category::where('slug', $category_slug)->first();
		
		$category_hub = CategoryHub::where('hub_id',$hub->id)
								   ->where('category_id',$category->id)
								   ->first();
		
														
		$first_column_news = $category_hub->news()->where('publish','1')->orderBy('created_at', 'desc')->paginate(21);

		$theme->setTitle($category->name.'-'.$hub->name);
		$theme->asset()->add('style', url('/css/'.$hub->template.'.css'));
		
		//return view('categories.hub_category_news', compact('first_column_news'));
		return $theme->of('categories.hub_category_news',compact('first_column_news','hub'))->render();
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id,CategoryHierarchy $hierarchy)
    {
        $category = Category::find($id);
		
		$categories = Category::get();// get all menu for select option
		
		$hierarchy->setupItems($categories,$category->parent_id);
		
		$category_opts = $hierarchy->render();
				
		$cat_types = array('1'=>'None','2'=>'column');
		
		//hubs
		/*$hubs = Hub::lists('name','id');
		
		$hubs_selected = $category->hubs->lists('id')->toArray();
		*/
		//countries
		/*$countries = Country::lists('name','id');
		
		$countries_selected = $category->countries->lists('id')->toArray();*/
		
		return view('categories.edit', compact('category',
												'category_opts',
												'cat_types'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);
		
		if($category['name'] != $request['name']){
			
			$slug = str_slug($request['name']);

			$count = Category::whereRaw("slug RLIKE '^{$slug}(-[0-9]+)?$'")->count();
		
			$request['slug'] = $count ? "{$slug}-{$count}" : $slug;
		}
		
		$category->update($request->all());
		
		//$category->hubs()->sync($request['hub_id']);
		
		//$category->countries()->sync($request['country_id']);
		
		return redirect('categories/index')->with('message', 'Category Updated');
    }

	public function in_main_menu(Request $request)
	{
		$category = Category::find($request['category_id']);
		
		//$category->hubs()->sync((array)$hub_id,['in_front'=>1, 'in_main_menu'=>1],false);
		$category->hubs()->sync([$request['hub_id']=>['in_main_menu'=>$request['in_main_menu'],
											'in_front'=>$request['in_front']]],false);
		//return redirect('categories/index')->with('message', 'Category Updated');
		
	}
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
