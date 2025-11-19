@extends('app')
@section('content')

    <div class="card mb-3">
        <div class="card-header bg-primary" style="color: white !important;">
            <h5 class="mb-0" style="color: white">Daftar Nomor SK</h5>
        </div>

        <div class="card-body">

            <div class="mb-3">
                <div class="btn-group" role="group">
                    <a href="{{ route('sk.create') }}" class="btn btn-outline-primary">Generate No SK</a>
                    <a href="{{ route('sk.excel') }}" class="btn btn-outline-primary">Excel</a>
                </div>
            </div>


            <div class="table-responsive">
                <table class="table table-striped align-middle">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nomor SK</th>
                        <th scope="col">Tanggal</th>
                        <th scope="col">Kategori</th>
                        <th scope="col">Deskripsi</th>
                        <th scope="col">#</th>
                    </tr>
                    </thead>

                    <tbody>
                    @forelse ($skNumbers as $sk)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $sk['sk_number'] ?? '-' }}</td>
                            <td>{{ $sk['date'] ? \Carbon\Carbon::parse($sk['date'])->locale('id')->translatedFormat('d F Y') : '-' }}</td>
                            <td>{{ $sk['category']['name'] ?? '-' }}</td>
                            <td>{{ $sk['description'] ?? '-' }}</td>
                            <td>
                                <a href="{{ route('sk.edit', $sk['id']) }}" class="btn btn-sm btn-outline-info">
                                    Edit
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6">Data tidak tersedia</td>
                        </tr>
                    @endforelse
                    </tbody>

                </table>
            </div>

            {{-- PAGINATION --}}
            @if(isset($pagination['links']))
                <nav>
                    <ul class="pagination">
                        @foreach ($pagination['links'] as $link)
                            <li class="page-item {{ $link['active'] ? 'active' : '' }} {{ $link['url'] ? '' : 'disabled' }}">
                                @if ($link['url'])
                                    <a class="page-link"
                                       href="{{ url()->current() . '?' . parse_url($link['url'], PHP_URL_QUERY) }}">
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
        </div>
    </div>
@endsection
