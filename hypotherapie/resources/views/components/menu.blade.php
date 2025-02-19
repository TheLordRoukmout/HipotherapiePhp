<ul class="menu">
    @foreach($items as $item)
        <li>
            <a href="{{ $item['url'] }}">{{ $item['label'] }}</a>
        </li>
    @endforeach
</ul>
