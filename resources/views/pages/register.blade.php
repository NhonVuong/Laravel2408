@extends('layout.auth.layout')
@section('content')
<div class="card card-container" style="max-width:500px">
    <h3 class="text-center">Sign Up</h3>
    <p id="profile-name" class="profile-name-card"></p>
    <form class="form-signin" method="post" action="{{route('register')}}">
        @csrf
    <input type="text" name="username" class="form-control" placeholder="Username" required autofocus value="{{old('username')}}">
        @if($errors->has('username'))
            <small style="color:red">
                {{$errors->first('username')}}
            </small>
        @endif
        <input type="text" name="fullname" class="form-control" placeholder="Fullname" required value="{{old('fullname')}}">
        @if($errors->has('fullname'))
            <small style="color:red">
                {{$errors->first('fullname')}}
            </small>
    @endif
        <input type="date" name="birthdate" class="form-control" placeholder="Birthdate" required>
        <div class="row" style="margin-top:10px">
            <div class="col-md-4 col-md-offset-2">
                <input @if(old('gender')=='Nam') checked @endif type="radio" name="gender" value="Nam" required> Male
            </div>
            <div class="col-md-4">
                    <input @if(old('gender')=='Nữ') checked @endif type="radio" name="gender" value="Nữ" required> Female
            </div>
        </div>
        <input type="email" name="email" class="form-control" placeholder="Email address" required value="{{old('email')}}">
        @if($errors->has('email'))
            <small style="color:red">
                {{$errors->first('email')}}
            </small>
        @endif
        <input type="password" name="password" class="form-control" placeholder="Password" required>
        @if($errors->has('password'))
            <small style="color:red">
                {{$errors->first('password')}}
            </small>
        @endif
        <input type="password" name="confirmation_password" class="form-control" placeholder="Confirm Password" required>
        @if($errors->has('confirmation_password'))
        <small style="color:red">
            {{$errors->first('confirmation_password')}}
        </small>
    @endif
        <button class="btn btn-lg btn-primary btn-block btn-signin" type="submit" name="login">Sign up</button>
    </form><!-- /form -->
    <a href="{{route('login')}}" class="forgot-password">
        Or Login
    </a>
</div><!-- /card-container -->
@endsection
@section('title','Sign Up') 