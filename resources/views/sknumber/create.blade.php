@extends('app')
@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('sk.index') }}">Nomor SK</a></li>
            <li class="breadcrumb-item active" aria-current="page">Tambah</li>
        </ol>
    </nav>

    <div class="card">
        <div class="card-header bg-primary">
            <h5 class="mb-0" style="color: white">Tambah Nomor SK</h5>
        </div>

        <div class="card-body">
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

                <div class="mb-3">
                    <label for="category_id" class="form-label">Kategori</label>
                    <select name="category_id"
                            id="category_id"
                            class="form-select @error('category_id') is-invalid @enderror">
                        <option value="">-- Pilih Kategori --</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}"
                                    {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>

                    @error('category_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Deskripsi</label>
                    <textarea name="description"
                              id="description"
                              rows="3"
                              class="form-control @error('description') is-invalid @enderror">{{ old('description') }}</textarea>

                    @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <input type="hidden" name="is_sispk" value="0">

                <button type="submit" class="btn btn-primary w-100">Simpan</button>
            </form>
        </div>
    </div>

@endsection
