<?php 

namespace Phambinh\Cms\Http\Controllers;

use Illuminate\Http\Request;
use AppController;
use Mail;
use Validator;

class ContactController extends AppController
{
    public function store(Request $request, $alias)
    {
        $contact = \Contact::where('alias', $alias)->first();
        return $contact->send($request);
    }
}
