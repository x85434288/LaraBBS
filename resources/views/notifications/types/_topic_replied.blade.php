<ul class="media-list">
    <li class="media">
        <div class="media-left">
            <a href="{{ route('users.show',[$notification->data['user_id']]) }}" title="{{ $notification->data['user_name'] }}">
                <img src="{{ $notification->data['user_avatar'] }}" style="width: 52px;height: 52px" class="media-object  img-thumbnail">
            </a>
        </div>

        <div class="media-body">

            <div class="media-heading">

                {{--<a href="{{ $topic->link() }}">{{ $topic->title }}</a>--}}

                {{--<a class="pull-right" href="{{ $topic->link() }}">--}}
                    {{--<span class="badge">{{ $topic->reply_count }}</span>--}}
                {{--</a>--}}

                <a href="{{ route('users.show',[$notification->data['user_id']]) }}">{{ $notification->data['user_name'] }}</a>
                评论了<a href="{{ $notification->data['topic_link'] }}">{{ $notification->data['topic_title'] }}</a>

            </div>

            <div class="media-body meta">

                <span class="meta pull-right" title="{{ $notification->created_at }}">
                    <span class="glyphicon glyphicon-clock" aria-hidden="true"></span>
                    {{ $notification->created_at->diffForHumans() }}
                </span>

                <div class="reply_content">
                    {!! $notification->data['reply_content'] !!}
                </div>

            </div>

        </div>
    </li>
</ul>
<hr>