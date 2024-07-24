@extends('app')
@section('content')

<div class="section">
   <x-sweetalert></x-sweetalert>

   <div class="section-header">
      <div class="section-header-back">
         <a href="{{ route('employee.students.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
      </div>
      <h1>Edit</h1>
      <div class="section-header-breadcrumb">
         <div class="breadcrumb-item active"><a href="/">Dashboard</a></div>
         <div class="breadcrumb-item active"><a href="{{ route('employee.students.index') }}">Siswa</a></div>
         <div class="breadcrumb-item">Edit</div>
      </div>
   </div>

   <div class="section-body">
      <h2 class="section-title">Edit Siswa</h2>
      <p class="section-lead">
         Silakan perbarui informasi siswa <span class="text-primary">{{ $student->user->name }}</span> di bawah ini sesuai dengan perubahan yang diinginkan
      </p>

      <div class="row mt-sm-4">
         <div class="col-12 col-md-12 col-lg-12">
            <div class="card">
               <form action="{{ route('employee.students.update', [$student]) }}" method="post" enctype="multipart/form-data" novalidate="">
                  @method('patch')
                  @csrf
                  <div class="card-header">
                     <h4>Edit Siswa</h4>
                  </div>
                  <div class="card-body">
                     <div class="row mb-3">
                        <div class="form-group col-md-1 col-12">
                           <figure class="avatar mr-2 avatar-xl">
                              @if ($student->user->photo)
                              <img src="{{ asset('storage/photos/user/' . $student->user->photo) }}" style="object-fit:cover;" alt="Foto Profile">
                              @else
                              <img src="{{ asset('assets/img/avatar/avatar-1.png') }}" alt="Foto Profile">
                              @endif
                           </figure>
                        </div>
                        <div class="col-sm-7 col-md-7">
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
                           <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name', $student->user->name) }}" placeholder="Masukkan Nama" autocomplete="off">
                           <x-invalid-feedback field='name'></x-invalid-feedback>
                        </div>
                        <div class="form-group col-md-6 col-12">
                           <label>NISN <x-label-required></x-label-required></label>
                           <input type="text" class="form-control @error('nisn') is-invalid @enderror" name="nisn" value="{{ old('nisn', $student->nisn) }}" placeholder="Masukkan NISN" autocomplete="off">
                           <x-invalid-feedback field='nisn'></x-invalid-feedback>
                        </div>
                     </div>
                     <div class="row">
                        <div class="form-group col-md-5 col-12">
                           <label>Kelas <x-label-required></x-label-required></label>
                           <select class="form-control select2" name="classroom_id">
                              <option selected disabled>Pilih Kelas</option>
                              @foreach ($classrooms as $item)
                              <option value="{{ $item->id }}" {{ old('classroom_id') == $item->id || (isset($student) && $student->classroom_id == $item->id) == $item->id ? 'selected' : '' }}>{{ $item->name }}</option>
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
                              <option value="Laki-Laki" {{ old('gender') == 'Laki-Laki' || (isset($student) && $student->gender == 'Laki-Laki') == $item->id ? 'selected' : '' }}>Laki Laki</option>
                              <option value="Perempuan" {{ old('gender') == 'Perempuan' || (isset($student) && $student->gender == 'Perempuan') == $item->id ? 'selected' : '' }}>Perempuan</option>
                           </select>
                           @error('gender')
                           <div class="form-text text-danger">{{ $message }}</div>
                           @enderror
                        </div>
                        <div class="form-group col-md-4 col-12">
                           <label>Tanggal Lahir</label>
                           <input type="date" class="form-control @error('birth_date') is-invalid @enderror" name="birth_date" value="{{ old('birth_date', $student->birth_date) }}" placeholder="Masukkan birth_date" autocomplete="off">
                           <x-invalid-feedback field='birth_date'></x-invalid-feedback>
                        </div>
                     </div>
                     <div class="row">
                        <div class="form-group col-md-6 col-12">
                           <label>Email</label>
                           <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email', $student->user->email) }}" placeholder="Masukkan Email" autocomplete="off">
                           <x-invalid-feedback field='email'></x-invalid-feedback>
                        </div>
                        <div class="form-group col-md-6 col-12">
                           <label>No. Handphone</label>
                           <input type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone', $student->user->phone) }}" placeholder="Masukkan Nomor" autocomplete="off">
                           <x-invalid-feedback field='phone'></x-invalid-feedback>
                        </div>
                     </div>
                     <div class="row">
                        <div class="form-group col-md-7 col-12">
                           <label>Alamat</label>
                           <input type="text" class="form-control @error('address') is-invalid @enderror" name="address" value="{{ old('address', $student->address) }}" placeholder="Masukkan Alamat" autocomplete="off">
                           <x-invalid-feedback field='address'></x-invalid-feedback>
                        </div>
                        <div class="form-group col-md-5 col-12">
                           <label>Password Baru</label>
                           <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="Masukkan Password Baru">
                           <x-invalid-feedback field='password'></x-invalid-feedback>
                           <div class="form-text text-muted">Kosongkan jika tidak ingin menggantinya</div>
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

