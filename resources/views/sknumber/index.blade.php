@extends('app')
@section('content')
    <a href="{{route('sk.create')}}" class="btn btn-outline-primary">Generate No SK</a>
    <table class="table table-striped">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Nomor SK</th>
            <th scope="col">Tanggal</th>
            <th scope="col">Kategori</th>
            <th scope="col">Deskripsi</th>
{{--            <th scope="col">Tanggal Verifikasi</th>--}}
            <th scope="col">#</th>
        </tr>
        </thead>
        <tbody>
            @forelse ($skNumbers as $sk)
                <tr>
                    <td>{{ $loop->iteration}}</td>
                    <td>{{ $sk['sk_number'] ?? '-' }}</td>
                    <td>{{ $sk['date'] ? \Carbon\Carbon::parse($sk['date'])->locale('id')->translatedFormat('d F Y') : '-' }}</td>
                    <td>{{ $sk['category']['name'] ?? '-' }}</td>
                    <td>{{ $sk['description'] ?? '-' }}</td>
{{--                    @if($sk['is_verified'])--}}
{{--                        <td>--}}
{{--                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">--}}
{{--                                <path fill="#11d96e" d="m10.6 16.2l7.05-7.05l-1.4-1.4l-5.65 5.65l-2.85-2.85l-1.4 1.4zM5 21q-.825 0-1.412-.587T3 19V5q0-.825.588-1.412T5 3h14q.825 0 1.413.588T21 5v14q0 .825-.587 1.413T19 21z" />--}}
{{--                            </svg>--}}
{{--                        </td>--}}
{{--                    @else--}}
{{--                        <td>--}}
{{--                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">--}}
{{--                                <path fill="#e82626" d="M8 18q-.825 0-1.412-.587T6 16V4q0-.825.588-1.412T8 2h12q.825 0 1.413.588T22 4v12q0 .825-.587 1.413T20 18zm-4 4q-.825 0-1.412-.587T2 20V7q0-.425.288-.712T3 6t.713.288T4 7v13h13q.425 0 .713.288T18 21t-.288.713T17 22zm8.6-9.2l1.4-1.4l1.4 1.4q.275.275.7.275t.7-.275t.275-.7t-.275-.7L15.4 10l1.4-1.4q.275-.275.275-.7t-.275-.7t-.7-.275t-.7.275L14 8.6l-1.4-1.4q-.275-.275-.7-.275t-.7.275t-.275.7t.275.7l1.4 1.4l-1.4 1.4q-.275.275-.275.7t.275.7t.7.275t.7-.275" />--}}
{{--                            </svg>--}}
{{--                        </td>--}}
{{--                    @endif--}}
{{--                    <td>{{ $sk['verified_at'] ?? '-' }}</td>--}}
                    <td>
                        <a href="{{route('sk.edit',$sk['id'])}}" class="btn btn-sm btn-outline-info">Edit</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6">Data tidak tersedia</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    @if(isset($pagination['links']))
        <nav>
            <ul class="pagination">
                @foreach ($pagination['links'] as $link)
                    <li class="page-item {{ $link['active'] ? 'active' : '' }} {{ $link['url'] ? '' : 'disabled' }}">
                        @if ($link['url'])
                            <a class="page-link" href="{{ url()->current() . '?' . parse_url($link['url'], PHP_URL_QUERY) }}">
                                {!! $link['label'] !!}
                            </a>
                        @else
                            <span class="page-link">{!! $link['label'] !!}</span>
                        @endif
                    </li>
                @endforeach
            </ul>
        </nav>
    @endif
@endsection
