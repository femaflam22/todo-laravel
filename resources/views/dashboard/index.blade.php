@extends('layout')

@section('content')
<div class="wrapper bg-white">
    @if (Session::get('notAllowed'))
        <div class="alert alert-danger">
            {{ Session::get('notAllowed') }}
       </div>
    @endif
    @if (Session::get('successAdd'))
        <div class="alert alert-success">
            {{ Session::get('successAdd') }}
       </div>
    @endif
    @if (Session::get('successUpdate'))
        <div class="alert alert-success">
            {{ Session::get('successUpdate') }}
       </div>
    @endif
    @if (Session::get('deleted'))
        <div class="alert alert-warning">
            {{ Session::get('deleted') }}
       </div>
    @endif
    @if (Session::get('done'))
        <div class="alert alert-success">
            {{ Session::get('done') }}
       </div>
    @endif
    <div class="d-flex align-items-start justify-content-between">
        <div class="d-flex flex-column">
            <div class="h5">My Todo's</div>
            <p class="text-muted text-justify">
                Here's a list of activities you have to do
            </p>
            <br>
            <span>
                <a href="{{route('todo.create')}}" class="text-success">Create</a>
            </span>
        </div>
        <div class="info btn ml-md-4 ml-0">
            <span class="fas fa-info" title="Info"></span>
        </div>
    </div>
    <div class="work border-bottom pt-3">
        <div class="d-flex align-items-center py-2 mt-1">
            <div>
                <span class="text-muted fas fa-comment btn"></span>
            </div>
            <div class="text-muted">2 todos</div>
            <button class="ml-auto btn bg-white text-muted fas fa-angle-down" type="button" data-toggle="collapse"
                data-target="#comments" aria-expanded="false" aria-controls="comments"></button>
        </div>
    </div>
    <div id="comments" class="mt-1">
        {{-- looping data-data dr compact 'todos' agar dapat ditampilkan per baris datanya --}}
        @foreach ($todos as $todo)
            <div class="comment d-flex align-items-start justify-content-between">
                <div class="mr-2">
                    {{-- cek kalau statusnya 1 (complated), maka yang ditampilin icon biasa yang gabisa di klik --}}
                    @if ($todo['status'] == 1)
                        <span class="fa-solid fa-bookmark text-secondary btn"></span>
                    {{-- kalau statusnya selain dari 1, baru muncul icon checklist yang bisa di click buat update ke complated --}}
                    @else
                        <form action="/todo/complated/{{$todo['id']}}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="fas fa-circle-check text-primary btn"></button>
                        </form>
                    @endif
                    {{-- <label class="option">
                        <input type="checkbox">
                        <span class="checkmark"></span>
                    </label> --}}
                </div>
                <div class="d-flex flex-column w-75">
                    {{-- menampilkan data dinamis/data yg diambil dari db pada blade harus menggunakan {{}} --}}
                    {{-- path yang {id} dikirim data dinamis (data dr db) makanya disitu pake {{}} --}}
                    <a href="/todo/edit/{{$todo['id']}}" class="text-justify">
                        {{ $todo['title'] }}
                    </a>
                    <p class="text-truncate">{{ $todo['description'] }}</p>
                    {{-- konsep ternary : if column status baris ini isinya 1 bakal munculin teks 'Complated' selain dari itu akan menampilkan teks 'On-Process' --}}
                    <p class="text-muted">
                        {{ $todo['status'] == 1 ? 'Complated' : 'On-Process' }} 
                        {{-- Carbon itu package laravel untuk mengelola yg berhubungan dengan date. Tadinya value column date di db kan bentuknya format 2022-11-22 nah kita pengen ubah bentuk formatnya jadi 22 November, 2022 --}}
                        <span class="date">
                            {{-- kalau statusnya 1 (complated), yang ditampilin itu tgl kapan dia selesainya yg diambil dr column done_time yg diisi pas update status nya ke complated --}}
                            @if ($todo['status'] == 1)
                            selesai pada : {{ \Carbon\Carbon::parse($todo['done_time'])->format('j F, Y') }}
                            {{-- kalau statusnya masih 0 (on-progress), yang ditampilin tgl dia dibuat (data dr column date yang diisi dr input pilih tanggal di fitur create) --}}
                            @else
                            target selesai : {{ \Carbon\Carbon::parse($todo['date'])->format('j F, Y') }}
                            @endif    
                        </span>
                    </p>
                </div>
                <div class="ml-auto">
                    {{-- apabila fitur nya berhubungan dengan modifikasi database, maka gunakan form --}}
                    <form action="{{ route('todo.delete', $todo['id']) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="fas fa-trash text-danger btn"></button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection