@extends('layouts.main')

@section('title', 'Login')
@section('content')
<div class="form-login">
    <div class="content-login">
        <form action="{{ route('login') }}" method="POST">
            @csrf
            <div class="form-group mt-4">
                <label for="email">E-mail</label>
                <input type="email" class="form-control" name="email" id="email" :value="old('email')" required autofocus>
            </div>
            <div class="form-group mt-4">
                <label for="email">Senha</label>
                <input type="password" class="form-control" name="password" id="password" required autocomplete="current-password">
            </div>
            <button type="submit" class="btn btn-secondary mt-4">Entrar</button>
        </form>
    </div>
</div>
@endsection