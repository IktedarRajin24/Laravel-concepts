@extends('bootstrap')

<html>

<body>
    <br>
    <br>
    <br>

    <div class="container" style="width:40%; background-color: orange; ">
        <form method="post" action="{{route('users.register')}}" enctype="multipart/form-data">
            {{csrf_field()}}
            <h2 style="text-align:center; color: white">Sign Up</h2>
            <br>
            <div class="form-group row">
                <label for="staticName" class="col-sm-2 col-form-label" style="color: white">Name</label>
                <div class="col-sm-10">
                    <input type="text" name="name" id="name" class="form-control" id="inputName" placeholder="Name" style="width:75%">
                </div>
                @error('name')
                <span class="text-danger">{{$message}}</span>
                @enderror
            </div>
            <br>
            <div class="form-group row">
                <label for="staticEmail" class="col-sm-2 col-form-label" style="color: white">Email</label>
                <div class="col-sm-10">
                    <input type="text" name="email" id="email" class="form-control" id="inputEmail" placeholder="E-mail" style="width:75%">
                </div>
                @error('email')
                <span class="text-danger">{{$message}}</span>
                @enderror
            </div>
            <br>
            <div class="form-group row">
                <label for="staticGender" class="col-sm-2 col-form-label" style="color: white">Gender</label>
                <div style="width:75%">
                    <input type="radio" id="male" name="gender" value="male">
                    <label for="male">Male</label>
                    <input type="radio" id="css" name="gender" value="female">
                    <label for="female">Female</label>
                    <input type="radio" id="others" name="gender" value="others">
                    <label for="others">Others</label>
                </div>
                @error('gender')
                <span class="text-danger">{{$message}}</span>
                @enderror
            </div>
            <br>
            <div class="form-group row">
                <label for="staticName" class="col-sm-2 col-form-label" style="color: white">Phone</label>
                <div class="col-sm-10">
                    <input type="text" name="phone" id="phone" class="form-control" id="inputPhone" placeholder="Phone" style="width:75%">
                </div>
                @error('phone')
                <span class="text-danger">{{$message}}</span>
                @enderror
            </div>
            <br>
            <div class="form-group row">
                <label for="staticImage" class="col-sm-2 col-form-label" style="color: white">Image</label>
                <div class="col-sm-10">
                    <input type="file" name="img" id="img" class="form-control" style="width:75%">
                </div>
                @error('img')
                <span class="text-danger">{{$message}}</span>
                @enderror
            </div>
            <br>
            <div class="form-group row">
                <label for="inputPassword" class="col-sm-2 col-form-label" style="color: white">Password</label>
                <div class="col-sm-10">
                    <input type="password" name="password" id="password" class="form-control" id="inputPassword" placeholder="Password" style="width:75%">
                </div>
                @error('password')
                <span class="text-danger">{{$message}}</span>
                @enderror
            </div>
            <br>
            <div class="form-group row">
                <label for="inputConPassword" class="col-sm-2 col-form-label" style="color: white">Confirm Password</label>
                <div class="col-sm-10">
                    <input type="password" name="confirmPassword" id="confirmPassword" class="form-control" placeholder="Confirm Password" style="width:75%">
                </div>
                @error('conPassword')
                <span class="text-danger">{{$message}}</span>
                @enderror
            </div>
            <br>
            <div class="form-group" style="text-align:center">
                <input type="submit" class="btn btn-success" value="Sign Up">
            </div>
            <br>
            <div class="form-group" style="text-align:center">
                <p style="color: white">Already Registered? <a href="{{route('users.login')}}">Login</a></p>
            </div>



        </form>
        <br>
    </div>

</body>

</html>