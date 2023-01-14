@extends('layout')

@section('content')
    <div class="pt-5 w-100 bg-white" style="height: 100vh">
        <img src="{{asset('assets/img/404.jpg')}}" alt="" srcset="" width="300" class="d-block m-auto pt-5">
        <h5 class="text-center mt-3">Anda tidak diperbolehkan mengakses halaman ini.</h5>
        <div class="d-flex justify-content-center mt-2">
            <a href="{{route('todo.index')}}" class="btn btn-primary">Kembali</a>
        </div>
    </div>
@endsection