@if(count($topics)>0)

    <ul class="list-group">

        @foreach($topics as $topic)

            <li class="list-group-item">
                <a href="{{ route('topics.show', $topic->id) }}">{{ $topic->title }} </a>
                · <span class="meta pull-right"> {{ $topic->reply_count }} 回复  {{ $topic->created_at->diffForHumans() }}</span>
            </li>

        @endforeach
    </ul>

@else

    <div class="empty-block">
        暂无内容 ~~~
    </div>

@endif


{{--  分页 --}}

{!! $topics->render() !!}