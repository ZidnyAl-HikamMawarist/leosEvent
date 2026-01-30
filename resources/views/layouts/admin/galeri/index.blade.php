@extends('layouts.admin.layout')
@section('title','Galeri')

@section('content')
<div class="card">
    <div class="card-body">
        <div class="d-flex justify-content-between mb-3">
            <h5 class="fw-bold">Galeri Eskul</h5>
            <a href="{{ route('galeri.create') }}" class="btn btn-primary">
                <i class="bi bi-plus"></i> Tambah Foto
            </a>
        </div>

        <div class="row">
            @foreach($galeris as $item)
            <div class="col-md-3 mb-4">
                <div class="card h-100">
                    <img src="{{ asset('storage/'.$item->gambar) }}"
                         class="card-img-top"
                         style="height:180px;object-fit:cover">

                    <div class="card-body">
                        <p class="fw-semibold mb-2">{{ $item->judul }}</p>

                        <form action="{{ route('galeri.destroy',$item->id) }}" method="POST">
                            @csrf @method('DELETE')
                            <button class="btn btn-danger btn-sm w-100">
                                <i class="bi bi-trash"></i> Hapus
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

    </div>
</div>
@endsection
