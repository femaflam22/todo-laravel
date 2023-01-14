@extends('layout')

@section('content')
    <div class="container pt-5">
        <div class="card d-block m-auto py-5 px-2">
            <div class="card-body">
                @if (is_null($user['image_profile']))
                    <img src="{{asset('assets/img/kosong.png')}}" alt="" srcset="" width="100" style="border-radius: 50%" class="d-block m-auto">
                @else
                    <img src="{{asset('assets/img/'.$user['image_profile'])}}" alt="" srcset="" width="100" style="border-radius: 50%" class="d-block m-auto">
                @endif
                <div class="d-flex justify-content-center mt-2">
                    <a href="/todo/profile/upload" class="btn btn-primary">Ubah Foto Profile</a>
                </div>
                <ul class="mt-3">
                    <li><b>username:</b> {{$user['username']}}</li>
                    <li><b>email :</b> {{$user['email']}}</li>
                    <li><b>name :</b> {{$user['name']}}</li>
                </ul>
                <div class="d-flex justify-content-end">
                    <a href="{{route('todo.index')}}" class="btn btn-secondary">Back</a>
                </div>
            </div>
        </div>
    </div>
@endsection