<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>tambah pelanggaran</title>
</head>
<body>
    <h1>tambah pelanggaran</h1>
    <br><br>

    <a href="{{route('pelanggaran.index')}}">kembali</a><br><br>

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($eerros->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        <ul>
        </div>
        @endif
    <form action="{{ route('pelanggaran.store')}}" method="POST">

        @csrf
        <label>jenis pelanggaran</label>
        <textarea id="jenis" name="jenis" rows="7" cols="50" value="{{ old('jenis')}}"></textarea>
        <br>

        <br>
        <label>konsekuensi</label>
        <textarea id="konsekuensi" name="konsekuensi" rows="7" cols="50" value="{{ old('konsekuensi')}}"></textarea>
        <br>

        <br>
        <label>poin</label>
        <input type="text" name="poin" id="poin" value="{{ old('poin')}}"><br>
        <br><br>

        <input type="submit" value="register">
    </form>
</body>
</html>