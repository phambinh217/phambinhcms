<?php

namespace Packages\SimpleShop\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use HomeController as CoreHomeController;
use Packages\Ecommerce\Product;
use Packages\Ecommerce\Brand;
use Packages\Ecommerce\Category;
use Packages\Ecommerce\Filter;
use Packages\Ecommerce\Tag;

class ProductController extends CoreHomeController
{
    /**
     * Xem nhanh sản phẩm
     * @param  integer $id
     */
    public function quickview($id)
    {
        $product = Product::findOrFail($id);
        $this->data['product'] = $product;
        $this->data['product_id'] = $id;
        \Metatag::set('title', $product->name);
        
        return view('Home::product.quickview', $this->data);
    }

    /**
     * Xem chi tiêt sản phẩm
     * @param  integer $id
     */
    public function show($slug, $id)
    {
        $product = Product::findOrFail($id);
        $this->data['product'] = $product;
        $this->data['product_id'] = $id;
        \Metatag::set('title', $product->name);
        
        return view('Home::product.show', $this->data);
    }

    public function listByBrand($slug, $id)
    {
        $brand = Brand::findOrFail($id);
        $product = new Product();
        $filter = $product->getRequestFilter(['brand_id' => $brand->id]);
        $products = $product->applyFilter($filter)->select('products.*')->paginate(config('baseshop.paginate'));

        $this->data['product'] = $product;
        $this->data['products'] = $products;
        $this->data['brand_id'] = $id;
        $this->data['brand'] = $brand;
        $this->data['filter'] = $filter;

        \Metatag::set('title', $brand->name);
        return view('Home::product.brand', $this->data);
    }

    public function listByCategory($slug, $id)
    {
        $category = Category::findOrFail($id);
        $product = new Product();
        $filter = $product->getRequestFilter(['category_id' => $category->id]);
        $products = $product->applyFilter($filter)->select('products.*')->paginate(config('baseshop.paginate'));

        $this->data['product'] = $product;
        $this->data['products'] = $products;
        $this->data['category_id'] = $id;
        $this->data['category'] = $category;
        $this->data['filter'] = $filter;

        \Metatag::set('title', $category->name);
        return view('Home::product.category', $this->data);
    }

    public function listByFilter($slug, $id)
    {
        $filter = Filter::findOrFail($id);
        $product = new Product();
        $product_filter = $product->getRequestFilter(['filter_id' => $filter->id]);
        $products = $product->applyFilter($product_filter)->select('products.*')->paginate(config('baseshop.paginate'));

        $this->data['product'] = $product;
        $this->data['products'] = $products;
        $this->data['filter_id'] = $id;
        $this->data['filter'] = $filter;
        $this->data['product_filter'] = $product_filter;

        \Metatag::set('title', $filter->name);
        return view('Home::product.filter', $this->data);
    }

    public function listByTag($slug, $id)
    {
        $tag = Tag::findOrFail($id);
        $product = new Product();
        $filter = $product->getRequestFilter(['tag_id' => $tag->id]);
        $products = $product->applyFilter($filter)->select('products.*')->paginate(config('baseshop.paginate'));

        $this->data['product'] = $product;
        $this->data['products'] = $products;
        $this->data['tag_id'] = $id;
        $this->data['tag'] = $tag;
        $this->data['filter'] = $filter;

        \Metatag::set('title', $tag->name);
        return view('Home::product.tag', $this->data);
    }

    public function listBySale()
    {
        $product = new Product();
        $filter = $product->getRequestFilter(['sale' => 'true']);
        $products = $product->applyFilter($filter)->select('products.*')->paginate(config('baseshop.paginate'));

        $this->data['product'] = $product;
        $this->data['products'] = $products;
        $this->data['filter'] = $filter;

        \Metatag::set('title', 'Đang giảm giá');
        return view('Home::product.sale', $this->data);
    }
}
