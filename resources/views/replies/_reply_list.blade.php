@if(count($topic->replies)>0)

    <ul class="list-group">

        @foreach($topic->replies as $reply)

            <li class="list-group-item">
                {{ $reply->content }}
                · <span class="meta pull-right"> 用户：{{ $reply->user->name }}  发布时间： {{ $reply->created_at->diffForHumans() }}</span>
            </li>

        @endforeach

    </ul>

@endif