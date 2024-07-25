@extends('app')
@section('content')

<div class="section">
   <x-sweetalert></x-sweetalert>

   <div class="section-header">
      <div class="section-header-back">
         <a href="{{ route('administrator.students.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
      </div>
      <h1>Tambah</h1>
      <div class="section-header-breadcrumb">
         <div class="breadcrumb-item active"><a href="/">Dashboard</a></div>
         <div class="breadcrumb-item active"><a href="{{ route('administrator.students.index') }}">Siswa</a></div>
         <div class="breadcrumb-item">Tambah</div>
      </div>
   </div>

   <div class="section-body">
      <h2 class="section-title">Tambah Siswa</h2>
      <p class="section-lead">
         Lengkapi informasi berikut untuk menambahkan siswa baru.
      </p>

      <div class="row mt-sm-4">
         <div class="col-12 col-md-12 col-lg-12">
            <div class="card">
               <form action="{{ route('administrator.students.store') }}" method="post" enctype="multipart/form-data" novalidate="">
                  @csrf
                  <div class="card-header">
                     <h4>Tambah Siswa</h4>
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
                           <label>NISN <x-label-required></x-label-required></label>
                           <input type="text" class="form-control @error('nisn') is-invalid @enderror" name="nisn" value="{{ old('nisn') }}" placeholder="Masukkan NISN" autocomplete="off">
                           <x-invalid-feedback field='nisn'></x-invalid-feedback>
                        </div>
                     </div>
                     <div class="row">
                        <div class="form-group col-md-5 col-12">
                           <label>Kelas <x-label-required></x-label-required></label>
                           <select class="form-control select2" name="classroom_id">
                              <option selected disabled>Pilih Kelas</option>
                              @foreach ($classrooms as $item)
                              <option value="{{ $item->id }}" {{ old('classroom_id') == $item->id ? 'selected' : '' }}>{{ $item->name }}</option>
                              @endforeach
                           </select>
                           @error('classroom_id')
                           <div class="form-text text-danger">{{ $message }}</div>
                           @enderror
                        </div>
                        <div class="form-group col-md-3 col-12">
                           <label>Jenis Kelamin <x-label-required></x-label-required></label>
                           <select class="form-control selectric" name="gender">
                              <option selected disabled>Pilih Jenis Kelamin</option>
                              <option value="Laki-Laki" {{ old('gender') == 'Laki-Laki' ? 'selected' : '' }}>Laki Laki</option>
                              <option value="Perempuan" {{ old('gender') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                           </select>
                           @error('gender')
                           <div class="form-text text-danger">{{ $message }}</div>
                           @enderror
                        </div>
                        <div class="form-group col-md-4 col-12">
                           <label>Tanggal Lahir</label>
                           <input type="date" class="form-control @error('birth_date') is-invalid @enderror" name="birth_date" value="{{ old('birth_date') }}" placeholder="Masukkan birth_date" autocomplete="off">
                           <x-invalid-feedback field='birth_date'></x-invalid-feedback>
                        </div>
                     </div>
                     <div class="row">
                        <div class="form-group col-md-3 col-12">
                           <label>Tahun Ajaran <x-label-required></x-label-required></label>
                           <select class="form-control select2" name="academic_year_id">
                              <option selected disabled>Pilih Tahun Ajaran</option>
                              @foreach ($academicYears as $item)
                              <option value="{{ $item->id }}" {{ old('academic_year_id') == $item->id ? 'selected' : '' }}>{{ $item->name }}</option>
                              @endforeach
                           </select>
                           @error('academic_year_id')
                           <div class="form-text text-danger">{{ $message }}</div>
                           @enderror
                        </div>
                        <div class="form-group col-md-4 col-12">
                           <label>Email</label>
                           <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" placeholder="Masukkan Email" autocomplete="off">
                           <x-invalid-feedback field='email'></x-invalid-feedback>
                        </div>
                        <div class="form-group col-md-5 col-12">
                           <label>No. Handphone</label>
                           <input type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone') }}" placeholder="Masukkan Nomor" autocomplete="off">
                           <x-invalid-feedback field='phone'></x-invalid-feedback>
                        </div>
                        <div class="form-group col-md-12 col-12">
                           <label>Alamat</label>
                           <input type="text" class="form-control @error('address') is-invalid @enderror" name="address" value="{{ old('address') }}" placeholder="Masukkan Alamat" autocomplete="off">
                           <x-invalid-feedback field='address'></x-invalid-feedback>
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

