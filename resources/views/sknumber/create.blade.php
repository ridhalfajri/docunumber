@extends('app')
@section('content')
    <form action="{{ route('sk.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="date" class="form-label">Tanggal SK</label>
            <input type="date"
                   name="date"
                   id="date"
                   class="form-control @error('date') is-invalid @enderror"
                   value="{{ old('date') }}">

            @error('date')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
@endsection
