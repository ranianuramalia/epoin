@extends('auth.layouts')

@section('content')
<h1>login</h1>
<a href="{{ route('register')}}">Daftar</a>
<br> <br>
<from action= "{{ route('authenticate') }}" method="post">
  @csrf
  <label>Email Address</label><br>
  <input type='email' id="email"name="email" value=" {{ old ('email') }}"><br><br>
  <label>password</label><br>
  <input type="password" id="password"name="password" name="password"><br><br>
  <input type="submit" value="login">
</from>

@endsection