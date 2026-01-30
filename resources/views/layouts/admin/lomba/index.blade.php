@extends('layouts.admin.layout')
@section('title', 'Data Lomba')

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between mb-3">
                <h5 class="fw-bold">Data Lomba</h5>
                <a href="{{ route('lomba.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus"></i> Tambah
                </a>
            </div>

            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama Lomba</th>
                        <th width="150">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($lombas as $lomba)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $lomba->nama_lomba }}</td>
                            <td>
                                <a href="{{ route('lomba.edit', $lomba->id) }}" class="btn btn-warning btn-sm">
                                    Edit
                                </a>
                                <form action="{{ route('lomba.destroy', $lomba->id) }}" method="POST" class="d-inline">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-danger btn-sm">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection