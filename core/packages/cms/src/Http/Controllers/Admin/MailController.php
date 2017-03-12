<?php

namespace Packages\Cms\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Packages\Cms\Mail;
use Validator;

class MailController extends AdminController
{
    /**
     * Gửi mail mới
     * @return view
     */
    public function create()
    {
        \Metatag::set('title', 'Soạn thư mới');

        $mail = new Mail();
        $filter = $mail->getRequestFilter();
        $this->data['filter'] = $filter;
        $this->data['mail'] = $mail;

        return view('Cms::admin.create', $this->data);
    }

    /**
     *
     * Gửi thư đi
     *
     * @param
     * @return
     * @author BinhPham
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'mail.receiver_id'    =>    'required|exists:users,id',
            'mail.subject'        =>    'required|max:255',
            'mail.content'        =>    'required|max:500',
        ]);

        $mail = new Mail();
        $mail = $mail->fill($request->mail);
        $mail->sender_id = \Auth::user()->id;
        $mail->save();

        if ($request->ajax()) {
            return response()->json([
                'title'        =>    trans('cms.success'),
                'message'    =>    trans('cms.success'),
                'redirect'    =>    $request->exists('save_only') ?
                    route('admin.mail.outbox') :
                    route('admin.mail.create'),
            ], 200);
        }

        if ($request->exists('save_only')) {
            return redirect(route('admin.mail.outbox'));
        }

        return redirect(route('admin.mail.create'));
    }

    /**
     * Hộp thư đến
     * @return view
     */
    public function inbox()
    {
        \Metatag::set('title', 'Hộp thư đến');

        $mail    = new Mail();
        $filter = $mail->getRequestFilter();
        $mails    = $mail->applyFilter($filter)
            ->select('messages.*')
            ->addSelect('users.first_name', 'users.last_name', 'users.email', 'users.avatar')
            ->join('users', 'users.id', '=', 'messages.sender_id')
            ->paginate($this->paginate);

        $this->data['mail']    = $mail;
        $this->data['filter']    = $filter;
        $this->data['mails']    = $mails;

        return view('Cms::admin.inbox', $this->data);
    }

    /**
     * Hộp thư đi
     * @return [type] [description]
     */
    public function outbox()
    {
        \Metatag::set('title', 'Hộp thư đi');

        $mail    = new Mail();
        $filter = $mail->getRequestFilter();
        $mails    = $mail->applyFilter($filter)
            ->select('messages.*')
            ->addSelect('users.first_name', 'users.last_name', 'users.email', 'users.avatar')
            ->join('users', 'users.id', '=', 'messages.receiver_id')
            ->paginate($this->paginate);

        $this->data['mail']    = $mail;
        $this->data['filter']    = $filter;
        $this->data['mails']    = $mails;

        return view('Cms::admin.outbox', $this->data);
    }

    /**
     *
     *
     *
     * @param
     * @return
     * @author BinhPham
     */
    public function inboxShow($id)
    {
        \Metatag::set('title', 'Xem hộp thư đến');

        $mail = Mail::find($id);
        
        // Đánh dấu là đã xem mail
        $mail->check = 1;
        $mail->save();

        $this->data['mail'] = $mail;
        $this->data['mail_id'] = $id;

        return view('Cms::admin.inbox-show', $this->data);
    }

    /**
     *
     *
     *
     * @param
     * @return
     * @author BinhPham
     */
    public function outboxShow($id)
    {
        \Metatag::set('title', 'Xem hộp thư đi');

        $mail = Mail::find($id);

        $this->data['mail'] = $mail;
        $this->data['mail_id'] = $id;

        return view('Cms::admin.outbox-show', $this->data);
    }


    /**
     *
     *
     *
     * @param
     * @return
     * @author BinhPham
     */
    public function popupForward($id)
    {
        $mail = Mail::find($id);

        $this->data['mail'] = $mail;
        $this->data['mail_id'] = $id;
        
        return view('Cms::admin.popup-forward', $this->data);
    }
}
