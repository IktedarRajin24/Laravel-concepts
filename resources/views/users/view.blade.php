@extends('bootstrap')
<br>
<br>
<br>
<h1 style="background-color: skyblue; text-align: center">Your Profile</h1>
<table class="table table-border" style="text-align: center">
    <tr hidden>
        <td>ID:</td>
        <td>{{$users->id}}</td>
    </tr>
    <tr>
        <td>Name</td>
        <td>{{$users->name}}</td>
    </tr>

    <tr>
        <td>E-mail</td>
        <td>{{$users->email}}</td>
    </tr>

    <tr>
        <td>Phone number</td>
        <td>{{$users->phone}}</td>
    </tr>

    <tr>
        <td>Gender</td>
        <td>{{$users->gender}}</td>
    </tr>

    <tr>
        <td>Password</td>
        <td>{{$users->password}}</td>
    </tr>

    <tr>
        <td>Image</td>
        <td><img src="{{asset('images/'. $users->image)}}" style="display:block;" width="20%" height="20%"></td>
    </tr>



    <tr>
        <td>Edit Info</td>
        <td><a class="btn btn-success" href="#">Edit</a></td>
    </tr>

    <tr>
        <td>Download Certificate</td>
        <td><a class="btn btn-primary" href="{{route('users.viewCertificate')}}">Download</a></td>
    </tr>


</table>