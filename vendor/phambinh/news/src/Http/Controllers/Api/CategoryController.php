<?php

namespace Phambinh\News\Http\Controllers\Api;

use Illuminate\Http\Request;
use Phambinh\News\Category;
use ApiController;
use Validator;

class CategoryController extends ApiController
{
    public function store(Request $request)
    {
        $this->validate($request, [
            'category.name'         => 'required|max:255',
            'category.slug'         => 'max:255',
            'category.description'  => 'max:300'
        ]);

        $category = new Category();
        
        $category->fill($request->input('category'))->save();

        return response()->json($category);
    }
}
