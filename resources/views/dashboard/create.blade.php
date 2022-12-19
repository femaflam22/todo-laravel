@extends('layout')

@section('content')
<div class="container content">  
  <form id="create-form" action="{{route('todo.store')}}" method="POST">
    {{-- mengambil dan mengirim data input ke controller yg nantinya diambil oleh Request $request --}}
    @csrf
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <h3>Create Todo</h3>
    
    <fieldset>
        <label for="">Title</label>
        <input placeholder="title of todo" type="text" name="title">
    </fieldset>
    <fieldset>
        <label for="">Target Date</label>
        <input placeholder="Target Date" type="date" name="date">
    </fieldset>
    <fieldset>
        <label for="">Description</label>
        <textarea name="description" placeholder="Type your descriptions here..." tabindex="5"></textarea>
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