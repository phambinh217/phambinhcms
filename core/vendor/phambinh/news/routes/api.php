<?php

Route::middleware(['auth:api'])->get('/api/news', function (Phambinh\News\News $news) {
    return $news->all();
});
