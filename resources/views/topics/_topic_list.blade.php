@if(count($topics)>0)

    @foreach($topics as $topic)

        <ul class="media-list">
            <li class="media">
                <div class="media-left">
                    <a href="{{ route('users.show',[$topic->user_id]) }}" title="{{ $topic->user->name }}">
                        <img src="{{ $topic->user->avatar }}" style="width: 52px;height: 52px" class="media-object  img-thumbnail">
                    </a>
                </div>

                <div class="media-body">

                    <div class="media-heading">

                        <a href="{{ $topic->link() }}">{{ $topic->title }}</a>

                        <a class="pull-right" href="{{ $topic->link() }}">
                            <span class="badge">{{ $topic->reply_count }}</span>
                        </a>

                    </div>

                    <div class="media-body meta">

                        <a href="{{ route('categories.show',$topic->category_id) }}" title="{{ $topic->category->name }}">
                            <span class="glyphicon glyphicon-list-alt"></span>
                            {{ $topic->category->name }}
                        </a>

                        <span> • </span>

                        <a href="{{ route('users.show',[$topic->user_id]) }}" title="{{ $topic->category->name }}">
                            <span class="glyphicon glyphicon-user"></span>
                            {{ $topic->user->name }}
                        </a>

                        <span> • </span>

                        <span class="glyphicon glyphicon-time" aria-hidden="true"></span>
                        <span class="timeago" title="最后活跃于">{{ $topic->updated_at->diffForHumans() }}</span>

                    </div>

                </div>



            </li>
        </ul>

        @if ( ! $loop->last)
            <hr>
        @endif

    @endforeach

@else

    <div class="empty-block">暂无数据</div>

@endif