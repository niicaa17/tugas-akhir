@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3>Detail Kategori</h3>
                </div>

                <div class="card-body">
                    <p><strong>ID:</strong> {{ $category->id }}</p>
                    <p><strong>Nama Kategori:</strong> {{ $category->nama_kategori }}</p>
                    <p><strong>Dibuat:</strong> {{ $category->created_at->format('d M Y H:i') }}</p>
                    <p><strong>Diupdate:</strong> {{ $category->updated_at->format('d M Y H:i') }}</p>

                    <a href="{{ route('categories.edit', $category) }}" class="btn btn-warning">Edit</a>
                    <a href="{{ route('categories.index') }}" class="btn btn-secondary">Kembali</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
