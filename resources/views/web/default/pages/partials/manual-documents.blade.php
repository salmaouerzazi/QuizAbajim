@if ($documents && count($documents) > 0)
    @foreach ($documents as $document)
        @if (!empty($document->{'3d_path_enfant'}))
            <a href="{{ $document->{'3d_path_enfant'} }}" class="fp-embed"
                data-fp-width="100%" data-fp-height="100%" style="max-width: 100%"></a>
        @else
            <span>{{ $document->name }} (No 3D path available)</span>
        @endif
    @endforeach
@else
    <p>No documents available.</p>
@endif
    <script async defer src="https://cdn-online.flowpaper.com/zine/3.8.4/js/embed.min.js"></script>
