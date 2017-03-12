<?php 

namespace Packages\Ecommerce\Http\Controllers\Api;

use Illuminate\Http\Request;
use ApiController;
use Validator;
use Packages\Ecommerce\Category;

class CategoryController extends ApiController
{
    public function index()
    {
        $category = new Category();
        $filter = $category->getRequestFilter();
        $res = $category->applyFilter($filter)->get();

        return response()->json($res);
    }
}
