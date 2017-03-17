<?php 

namespace Phambinh\Cms\Contact\Services;

use Mail;
use Validator;

class Contact
{
    public $registry = [];

    public function __construct()
    {
        $this->registry = collect();
    }

    public function register($alias, $data)
    {
        $data['alias'] = $alias;
        $this->registry->push(new SingleContact($data));
    }

    /**
     * Gọi các phương thức trang collection
     * @param  string $method
     * @param  array $params
     * @return collection()
     */
    public function __call($method, $params)
    {
        if (! method_exists($this, $method)) {
            return call_user_func_array([$this->registry, $method], $params);
        }
    }
}

class SingleContact
{
    public $validate;
    public $template;
    public $message;
    
    public function __construct($data)
    {
        foreach ($data as $property => $value) {
            $this->{$property} = $value;
        }
    }

    public function send(\Illuminate\Http\Request $request)
    {
        $validator = Validator::make($request->all(), $this->validate)->validate();

        Mail::send($this->template, $request->all(), function ($message) {
            $message->to($this->mailTo, $this->name)->subject($this->subject);
        });

        switch ($this->redirect) {
            case 'back':
                return redirect()->back()->with('message-success', $this->message);
                break;
            
            default:
                return redirect($this->redirect)->with('message-success', $this->message);
                break;
        }
    }
}
