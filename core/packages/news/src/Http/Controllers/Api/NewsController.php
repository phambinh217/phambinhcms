<?php 

namespace Packages\News\Http\Controllers\Api;

use Illuminate\Http\Request;
use ApiController;
use Packages\News\News;

class NewsController extends ApiController
{
    public function index()
    {
        $news = new News();
        $filter = $news->getRequestFilter();
        $res = $news->applyFilter($filter)
            ->select('newses.*', 'news_meta.value as thumbnail', 'users.first_name as trainer_first_name', 'users.last_name as trainer_last_name')
            ->addSelect(\DB::raw('count(classes.id) as total_student'))
            ->leftjoin('news_meta', 'newses.id', '=', 'news_meta.news_id')
            ->leftjoin('classes', 'newses.id', '=', 'classes.news_id')
            ->groupBy('newses.id')
            ->join('users', 'users.id', '=', 'newses.trainer_id')
            ->get();

        return response()->json($res, 200);
    }
}
