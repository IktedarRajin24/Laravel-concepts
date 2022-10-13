<div class="container">
    @extends('bootstrap')
    <h1>Hello {{$users->name}}</h1>
    <a class="btn btn-danger" href="">Edit</a>
    <a class="btn btn-success" href="{{route('users.view')}}">My Info</a>
    <a class="btn btn-success" href="{{route('admin.allUsers')}}">All Users</a>
    <a class="btn btn-danger" href="{{route('users.logout')}}">Logout</a>
</div>