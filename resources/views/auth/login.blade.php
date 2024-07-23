@extends('app')
@section('auth')

<x-sweetalert></x-sweetalert>

<div class="container mt-5">
   <div class="row">
      <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
         <div class="login-brand">
            <img src="{{ asset('assets/img/me/school-logo.png') }}" alt="logo" width="100" class="">
         </div>

         <div class="card card-primary">
            <div class="card-header">
               <h4>Login</h4>
            </div>

            <div class="card-body">
               <form method="POST" action="{{ route('auth.login') }}" novalidate="">
                  @csrf
                  <div class="form-group">
                     <label for="username">Username</label>
                     <input id="username" type="username" class="form-control @error('username') is-invalid @enderror" name="username" tabindex="1" value="{{ old('username') }}" placeholder="Masukkan username" required autofocus autocomplete="off">
                     <x-invalid-feedback field='username'></x-invalid-feedback>
                  </div>

                  <div class="form-group">
                     <div class="d-block">
                        <label for="password" class="control-label">Password</label>
                     </div>
                     <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" placeholder="Masukkan password" name="password" tabindex="2" required>
                     <x-invalid-feedback field='password'></x-invalid-feedback>
                  </div>

                  <div class="form-group">
                     <label>Level</label>
                     <select class="form-control selectric" name="role_id">
                        <option selected disabled>Pilih Level</option>
                        @foreach ($roles as $item)
                        <option value="{{ $item->id }}" {{ old('role_id') == $item->id ? 'selected' : '' }}>{{ $item->name }}</option>
                        @endforeach
                     </select>
                     @error('role_id')
                     <div class="form-text text-danger">{{ $message }}</div>
                     @enderror
                  </div>

                  <div class="form-group">
                     <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
                        Login
                     </button>
                  </div>
               </form>
            </div>
         </div>
         <div class="simple-footer">
            Copyright &copy; <a href="https://instagram.com/_achrian" target="_blank">SMK Negeri Medan</a> 2024
         </div>
      </div>
   </div>
</div>

@endsection
