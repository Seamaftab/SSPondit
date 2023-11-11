<?php

namespace App\View\Composer;

use App\Models\Category;
use Illuminate\View\View;

class ShowComposer
{
	function compose(View $view)
	{
		$categories = Category::pluck('name','slug')->toArray();
		//dd($categories);
		$view->with('categories', $categories);
	}
}