@extends('layouts.admin.layout')
@section('title','FAQ')

@section('content')
<div class="row">
    <div class="col-md-5">
        <div class="card mb-3">
            <div class="card-body">
                <h6 class="fw-bold">Tambah FAQ</h6>
                <form method="POST">
                    @csrf
                    <input class="form-control mb-2" name="pertanyaan" placeholder="Pertanyaan">
                    <textarea class="form-control mb-2" name="jawaban" placeholder="Jawaban"></textarea>
                    <button class="btn btn-primary w-100">Simpan</button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-7">
        @foreach($faqs as $faq)
        <div class="card mb-2">
            <div class="card-body">
                <form method="POST" action="/admin/faq/{{ $faq->id }}">
                    @csrf @method('PUT')
                    <input class="form-control mb-2" name="pertanyaan" value="{{ $faq->pertanyaan }}">
                    <textarea class="form-control mb-2" name="jawaban">{{ $faq->jawaban }}</textarea>
                    <button class="btn btn-success btn-sm">Update</button>
                </form>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
