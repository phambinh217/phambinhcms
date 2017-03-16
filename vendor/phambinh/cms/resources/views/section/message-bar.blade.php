<?php  $inbox = \Auth::user()->inbox()->applyFilter(['check' => 'not-check'])
    ->select('messages.*')
    ->addSelect('users.first_name', 'users.last_name', 'users.avatar')
    ->join('users', 'users.id', '=', 'messages.sender_id')
    ->take(5)
    ->get(); ?>

<li class="dropdown dropdown-extended dropdown-inbox dropdown-dark" id="header_inbox_bar">
    <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
        <i class="icon-envelope-open"></i>
            <span class="badge {{ $inbox->count() != 0 ? 'badge-danger' : 'badge-default' }}"> {{ $inbox->count() }} </span>
    </a>
    @if($inbox->count() != 0)
        <ul class="dropdown-menu">
            <li class="external">
                <h3>Bạn có
                    <span class="bold">{{ $inbox->count() }} Tin nhắn</span> mới</h3>
                <a href="{{ admin_url('mail/inbox') }}">xem tất cả</a>
            </li>
            
            <li>
                <ul class="dropdown-menu-list scroller" style="height: 275px;" data-handle-color="#637283">
                    @foreach($inbox as $inbox_item)
                        <li>
                            <a href="{{ route('admin.mail.inbox.show', ['id' => $inbox_item->id]) }}">
                                <span class="photo">
                                    <img src="{{ thumbnail_url($inbox_item->avatar, ['width' => '45', 'height' => '45']) }}" class="img-circle" alt="" style="max-width: 50px">
                                </span>
                                <span class="subject">
                                    <span class="from"> {{ $inbox_item->full_name() }} </span>
                                    <span class="time">{{ $inbox_item->created_at->diffForHumans() }} </span>
                                </span>
                                <span class="message"> {{ str_limit($inbox_item->content, 100) }} </span>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </li>
        </ul>
    @endif
</li>