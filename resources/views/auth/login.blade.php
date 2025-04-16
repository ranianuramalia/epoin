@extends('auth.layouts')

@section('content')
<h1>login</h1>

<br> <br>
<form action= "{{ route('authenticate') }}" method="post">
  @csrf
  <label>Email Address</label><br>
  <input type='email' id="email"name="email" value=" {{ old ('email') }}"><br><br>
  <label>password</label><br>
  <input type="password" id="password"name="password" name="password"><br><br>
  <input type="submit" value="Login">
</form>

@endsection