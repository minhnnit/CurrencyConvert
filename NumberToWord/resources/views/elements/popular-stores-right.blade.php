<div class="populer-right">
    <h1 class="title">
        Popular Store
    </h1>
    <ul>
        @foreach ($popularStores as $s)
            <li>
                <a href="{{url('/' . $s['alias'])}}">{{$s['name'].' '}}</a>
            </li>
        @endforeach
    </ul>
</div>