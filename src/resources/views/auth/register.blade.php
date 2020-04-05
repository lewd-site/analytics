@extends('layout')

@section('title', 'Sign Up')

@section('content')
  <h1>Sign Up</h1>

  <form class="form" method="POST" action="/register" enctype="multipart/form-data">
    @csrf

    <div class="form__row">
      <label class="form__field">
        <span class="form__addon las la-user"></span>
        <input class="form__input" type="text" name="name" placeholder="Name" />
      </label>
      @error('name')
        <div class="form__error">{{ $message }}</div>
      @enderror
    </div>

    <div class="form__row">
      <label class="form__field">
        <span class="form__addon las la-envelope"></span>
        <input class="form__input" type="email" name="email" placeholder="E-Mail" />
      </label>
      @error('email')
        <div class="form__error">{{ $message }}</div>
      @enderror
    </div>

    <div class="form__row">
      <label class="form__field">
        <span class="form__addon las la-key"></span>
        <input class="form__input" type="password" name="password" placeholder="Password" />
      </label>
      @error('password')
        <div class="form__error">{{ $message }}</div>
      @enderror
    </div>

    @error('user')
      <div class="form__row form__row_center">
        <div class="form__error">{{ $message }}</div>
      </div>
    @enderror

    <div class="form__row form__row_center">
      <button class="btn" type="submit">Sign Up</button>
    </div>
  </form>
@endsection
