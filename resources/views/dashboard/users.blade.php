@extends('layout')

@section('content')
<div class="container p-3">
    <table class="table table-primary table-bordered">
        <tr>
            <th>No</th>
            <th>Name</th>
            <th>Username</th>
            <th>Email</th>
            <th>Created</th>
        </tr>
        @php
            $no = 1;
        @endphp
        @foreach ($users as $user)
        <tr>
            <td>{{$no++}}</td>
            <td>{{$user['name']}}</td>
            <td>{{$user['username']}}</td>
            <td>{{$user['email']}}</td>
            <td>{{ \Carbon\Carbon::parse($user['created_at'])->format('j F, Y') }}</td>
        </tr>
        @endforeach
        
    </table>
</div>
@endsection