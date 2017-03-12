<?php

namespace Phambinh\News\Http\Controllers\Admin;

use Illuminate\Http\Request;
use AdminController;
use Validator;
use Phambinh\News\News;

class NewsController extends AdminController
{
    public function index()
    {
        $filter = News::getRequestFilter();
        $this->data['filter'] = $filter;
        $this->data['newses'] = News::applyFilter($filter)->with('author')->paginate($this->paginate);

        \Metatag::set('title', trans('news.list-news'));
        return view('News::admin.list', $this->data);
    }

    public function create()
    {
        $news = new News();
        $this->data['news'] = $news;

        \Metatag::set('title', trans('news.add-new-news'));
        return view('News::admin.save', $this->data);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'news.title'            =>    'required|max:255',
            'news.content'            =>    'min:0',
            'news.category_id'        =>    'required|exists:news_categories,id',
            'news.status'            =>    'required|in:enable,disable',
        ]);

        $news = new News();
        $news->fill($request->input('news'))->save();
        $news->categories()->sync((array) $request->input('news.category_id'));

        if ($request->ajax()) {
            return response()->json([
                'title'        =>    trans('cms.success'),
                'message'    =>    trans('news.create-news-success'),
                'redirect'    =>    $request->exists('save_only') ?
                    route('admin.news.edit', ['id' => $news->id]) :
                    route('admin.news.create'),
            ], 200);
        }

        if ($request->exists('save_only')) {
            return redirect()->route('admin.news.edit', ['id' => $news->id]);
        }

        return redirect()->route('admin.news.create');
    }
    
    public function edit(News $news)
    {
        $this->data['news_id'] = $news->id;
        $this->data['news']    = $news;

        \Metatag::set('title', trans('news.edit-news'));
        return view('News::admin.save', $this->data);
    }

    public function update(Request $request, News $news)
    {
        $this->validate($request, [
            'news.title'            =>    'required|max:255',
            'news.content'        =>    'min:0',
            'news.category_id'    =>    'required|exists:news_categories,id',
            'news.status'            =>    'required|in:enable,disable',
        ]);

        $news->fill($request->input('news'));

        $news->save();
        $news->categories()->sync((array) $request->input('news.category_id'));

        if ($request->ajax()) {
            $response = [
                'title'        =>    trans('cms.success'),
                'message'    =>    trans('news.update-news-success'),
            ];
            if ($request->exists('save_and_out')) {
                $response['redirect'] = route('admin.news.index');
            }

            return response()->json($response, 200);
        }
        
        if ($request->exists('save_and_out')) {
            return redirect()->route('admin.news.index');
        }
                
        return redirect()->back();
    }

    public function disable(Request $request, News $news)
    {
        $news->markAsDisable();
        if ($request->ajax()) {
            return response()->json([
                'title'            =>    trans('cms.success'),
                'message'        =>    trans('news.disable-news-success'),
            ], 200);
        }

        return redirect()->back();
    }

    public function enable(Request $request, News $news)
    {
        $news->markAsEnable();
        if ($request->ajax()) {
            return response()->json([
                'title'            =>    trans('cms.success'),
                'message'        =>    trans('news.enable-news-success'),
            ], 200);
        }

        return redirect()->back();
    }

    public function destroy(Request $request, News $news)
    {
        $news->delete();
        
        if ($request->ajax()) {
            return response()->json([
                'title'            =>    trans('cms.success'),
                'message'        =>    trans('news.destroy-news-success'),
            ], 200);
        }

        return redirect()->back();
    }
}
