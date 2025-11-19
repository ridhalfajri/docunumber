@extends('app')
@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('sk.index') }}">Nomor SK</a></li>
            <li class="breadcrumb-item active" aria-current="page">Edit</li>
        </ol>
    </nav>
    <div class="card">
        <div class="card-header bg-primary">
            <h5 class="mb-0" style="color:white;">Edit Nomor SK</h5>
        </div>

        <div class="card-body">
            <form action="{{ route('sk.update', $skNumber->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="nomor_sk" class="form-label">Nomor SK</label>
                    <input type="text"
                           name="nomor_sk"
                           id="nomor_sk"
                           class="form-control @error('nomor_sk') is-invalid @enderror"
                           value="{{ $skNumber->sk_number }}"
                           disabled>
                </div>

                <div class="mb-3">
                    <label for="date" class="form-label">Tanggal SK</label>
                    <input type="date"
                           name="date"
                           id="date"
                           class="form-control @error('date') is-invalid @enderror"
                           value="{{ $skNumber->date }}"
                           disabled>
                </div>

                <div class="mb-3">
                    <label for="category_id" class="form-label">Kategori</label>
                    <select name="category_id"
                            id="category_id"
                            class="form-select @error('category_id') is-invalid @enderror">
                        <option value="">-- Pilih Kategori --</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}"
                                    {{ old('category_id') == $category->id || $skNumber->category_id == $category->id ? 'selected' : '' }}>
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
                              class="form-control @error('description') is-invalid @enderror">{{ $skNumber->description }}</textarea>
                    @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary w-100">Simpan</button>
            </form>
        </div>
    </div>
@endsection
