@extends('master')
@section('title')
hey user!
@endsection
@section('content')
<h1>Hey User you are Logged in !! Dashboard Page </h1>

<nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
    <h4>Name : {{$data->first_name}}</h4>
    <h5>You are {{$role}}</h5>
    <form action="{{route('logout')}}" method="POST">
    @csrf
    <button class="btn btn-warning" type="submit">Logout</button>

</form>
</nav>
<div class="container">
    <h5>Email : {{$data->email}}</h5>
    <h5>Mobile Number : {{$data->mobile}}</h5>
</div>

<style>
    *{
        margin: 15px;
    }
    
</style>
@endsection