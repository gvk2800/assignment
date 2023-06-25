@extends('master')
@section('title')
Customer Details 
@endsection
@section('content')

<div class="container">
<h1>Available Details from DB</h1>
<form action="{{route('logout')}}" method="POST">
    @csrf
    <button class="btn btn-warning" type="submit">Logout</button>
</form>
    <div class="table">
    <table class='table table-striped'>
    <thead>
        <tr>
            <th>Id</th>
            <th>First Name</th>
            <th>Last Name</th>    
            <th>Email</th>   
            <th>Mobile Number</th>   
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach($d as $u)
        <tr>
            <td>{{$u->id}}</td>
            <td>{{$u->first_name}}</td>
            <td>{{$u->last_name}}</td>
            <td>{{$u->email}}</td>
            <td>{{$u->mobile}}</td>
            <td>
                <form action="/cedit"method="post">
                @csrf()
                <input type="hidden"name="idd" value="{{$u->id}}">
                <button type="submit"class="btn btn-danger">Edit Details</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
    </table>
    </div>
</div>

@endsection