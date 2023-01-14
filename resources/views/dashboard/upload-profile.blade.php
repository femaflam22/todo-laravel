@extends('layout')

@section('content')
    <div class="container pt-5">
        <div class="card d-block m-auto p-3">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            {{-- untuk form yg akan mengirim file harus menggunakan attribute enctype="multipart/form-data" pada tag form nya --}}
            {{-- fungsi  enctype="multipart/form-data" untuk mengirim identitas file yang di upload ke controller --}}
            <form action="{{route('todo.profile.change')}}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PATCH')
                <div class="form-group mb-3">
                    <label for="image_upload">Pilih Gambar</label>
                    <input type="file" name="image_profile" class="form-control" id="image_upload">
                </div>
                <button type="submit" class="btn btn-primary me-3">Ubah</button>
                <a href="/todo/profile" class="btn btnn-secondary">Kembali</a>
            </form>
        </div>
    </div>
@endsection