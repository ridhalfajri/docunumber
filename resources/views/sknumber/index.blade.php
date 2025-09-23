@extends('app')
@section('content')
    <a href="{{route('sk.create')}}" class="btn btn-outline-primary">Generate No SK</a>
    <table class="table table-striped">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Nomor SK</th>
            <th scope="col">Tanggal</th>
            <th scope="col">Virifikasi</th>
            <th scope="col">Tanggal Verifikasi</th>
            <th scope="col">#</th>
        </tr>
        </thead>
        <tbody>
            @forelse ($skNumbers as $sk)
                <tr>
                    <td>{{ $loop->iteration}}</td>
                    <td>{{ $sk['sk_number'] ?? '-' }}</td>
                    <td>{{ $sk['date'] ?? '-' }}</td>
                    <td>{{ $sk['is_verified'] ?? '-' }}</td>
                    <td>{{ $sk['verified_at'] ?? '-' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4">Data tidak tersedia</td>
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
