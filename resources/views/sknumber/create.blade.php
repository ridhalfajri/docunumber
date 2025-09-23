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
            <label for="description" class="form-label">Deskripsi</label>
            <textarea name="description"
                      id="description"
                      rows="3"
                      class="form-control @error('description') is-invalid @enderror">{{ old('description') }}</textarea>

            @error('description')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <input type="hidden" name="is_sispk" value="0">
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
@endsection
