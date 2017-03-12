<?php

Route::middleware(['auth:api'])->get('/api/news', function (Packages\News\News $news) {
    return $news->all();
});
