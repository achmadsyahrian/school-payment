@extends('app')
@section('content')

<div class="section">
   <x-sweetalert></x-sweetalert>

   <div class="section-header">
      <div class="section-header-back">
         <a href="{{ route('administrator.teachers.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
      </div>
      <h1>Tambah</h1>
      <div class="section-header-breadcrumb">
         <div class="breadcrumb-item active"><a href="/">Dashboard</a></div>
         <div class="breadcrumb-item active"><a href="{{ route('administrator.teachers.index') }}">Wali kelas</a></div>
         <div class="breadcrumb-item">Tambah</div>
      </div>
   </div>

   <div class="section-body">
      <h2 class="section-title">Tambah Wali kelas</h2>
      <p class="section-lead">
         Lengkapi informasi berikut untuk mendaftarkan wali kelas baru.
      </p>

      <div class="row mt-sm-4">
         <div class="col-12 col-md-12 col-lg-12">
            <div class="card">
               <form action="{{ route('administrator.teachers.store') }}" method="post" enctype="multipart/form-data" novalidate="">
                  @csrf
                  <div class="card-header">
                     <h4>Tambah Wali kelas</h4>
                  </div>
                  <div class="card-body">
                     <div class="row mb-3">
                        <div class="col-sm-12 col-md-12">
                           <label>Foto</label>
                           <div class="custom-file">
                              <input type="file" name="photo" class="custom-file-input @error('photo') is-invalid @enderror" id="profile-logo">
                              <label class="custom-file-label">Pilih Gambar</label>
                           </div>
                           @error('photo')
                           <div class="form-text text-danger">{{ $message }}</div>
                           @enderror
                           <div class="form-text text-muted">Batas maksimal ukuran gambar adalah 2MB</div>
                        </div>
                     </div>
                     <div class="row">
                        <div class="form-group col-md-6 col-12">
                           <label>Nama <x-label-required></x-label-required></label>
                           <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" placeholder="Masukkan Nama" autocomplete="off">
                           <x-invalid-feedback field='name'></x-invalid-feedback>
                        </div>
                        <div class="form-group col-md-6 col-12">
                           <label>Username <x-label-required></x-label-required></label>
                           <input type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" placeholder="Masukkan Username" autocomplete="off">
                           <x-invalid-feedback field='username'></x-invalid-feedback>
                        </div>
                     </div>
                     <div class="row">
                        <div class="form-group col-md-7 col-12">
                           <label>Email</label>
                           <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" placeholder="Masukkan Email" autocomplete="off">
                           <x-invalid-feedback field='email'></x-invalid-feedback>
                        </div>
                        <div class="form-group col-md-5 col-12">
                           <label>No. Handphone</label>
                           <input type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone') }}" placeholder="Masukkan Nomor" autocomplete="off">
                           <x-invalid-feedback field='phone'></x-invalid-feedback>
                        </div>
                     </div>
                  </div>
                  <div class="card-footer text-right">
                     <button class="btn btn-primary">Simpan</button>
                  </div>
               </form>
            </div>
         </div>
      </div>
   </div>
</div>


@endsection

