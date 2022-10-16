@extends('bootstrap')
<div class="container">

    <div>
        <table class="table table-bordered" style="text-align:center; border: 2px solid #000">
            <tr>
                <h1 style="text-align:center; border: 2px solid #000">Users</h1>
                
                <button class="btn btn-success"><a style="font-size:20px; text-decoration: none" href="/getExcel">Get Excel</a></button>
                <br>
                <button class="btn btn-success"><a style="font-size:20px; text-decoration: none" href="/getWord">Get Word</a></button>
                <br>
            </tr>
            <tr>
                <td>Name</td>
                <td>Email</td>
                <td>Gender</td>
                <td>Phone</td>
                <td>Image</td>
                <td>Action</td>
            </tr>
            @foreach ($users as $user)
            <tr>
                <td>{{$user->name}}</td>
                <td>{{$user->email}}</td>
                <td>{{$user->gender}}</td>
                <td>{{$user->phone}}</td>
                <td><img src="{{asset('images/'. $user->image)}}" style="margin:0 auto; display:block;" width="20%" height="20%"></td>
                <td><button class="btn btn-warning"><a style="font-size:20px; text-decoration: none" class="fa" href="/downloadCertificate/{{$user->id}}/{{$user->name}}">&#xf019; Download Certificate</a></button><br><br>
                    <button class="btn btn-warning"><a style="font-size:20px; text-decoration: none" class="fa" href="/sendCertificate/{{$user->id}}/{{$user->name}}">&#xf1d9; Send Certificate</a></button><br><br>
                    <button class="btn btn-warning"><a style="font-size:20px; text-decoration: none" class="fa" href="/viewPDF/{{$user->id}}/{{$user->name}}">&#xf06e; Download Certificate</a></button>
                </td>
            </tr>
            @endforeach
        </table>

    </div>
</div>