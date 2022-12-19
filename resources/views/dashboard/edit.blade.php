@extends('layout')

@section('content')
<div class="container content">  
  <form id="create-form" action="/todo/update/{{$todo['id']}}" method="POST">
    {{-- mengambil dan mengirim data input ke controller yg nantinya diambil oleh Request $request --}}
    @csrf
    {{-- karna di route nya pake method patch sedangkan attribute method di form cuman bisa post/get. Jadi yg post nya ditimpa --}}
    @method('PATCH')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <h3>Edit Todo</h3>
    
    <fieldset>
        <label for="">Title</label>
        {{-- attribute value fungsinya untuk memasukkan data ke input --}}
        {{-- kenapa datanya harus disimpen di input? karena ini kan fitur edit. Kalau fitur edit belum tentu semua data column diubah. Jadi untuk mengantisipasi hal itu, tampilin dulu semua data di inputnya baru nantinya pengguna yg menentukan data input mana yg mau diubah --}}
        <input placeholder="title of todo" type="text" name="title" value="{{ $todo['title'] }}">
    </fieldset>
    <fieldset>
        <label for="">Target Date</label>
        <input placeholder="Target Date" type="date" name="date" value="{{ $todo['date'] }}">
    </fieldset>
    <fieldset>
        <label for="">Description</label>
        {{-- karena textarea tidak termasuk tag input, untuk menampilkan value nya di pertengahan (sebelum penutup tag </textarea>) --}}
        <textarea name="description" placeholder="Type your descriptions here..." tabindex="5">{{ $todo['description'] }}</textarea>
    </fieldset>
    <fieldset>
        <button type="submit" id="contactus-submit">Submit</button>
    </fieldset>
    <fieldset>
        <a href="/todo/" class="btn-cancel btn-lg btn">Cancel</a>
    </fieldset>
  
  </form>
</div>
@endsection