<?php

namespace Phambinh\FbComment\Services;

class Comment
{
    public function isEnable()
    {
        return setting('fb-comment-apply', false);
    }

    public function render($id)
    {
        echo ('<div class="fb-comments" data-width="100%" data-href="'.$id.'" data-numposts="'.setting('fb-comment-perpage', 5).'"></div>');
    }
}
