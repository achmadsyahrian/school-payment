@extends('app')
@section('content')

<div class="section">
   <x-sweetalert></x-sweetalert>

   <div class="section-header">
      <div class="section-header-back">
         <a href="{{ route('employee.classrooms.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
      </div>
      <h1>Tambah</h1>
      <div class="section-header-breadcrumb">
         <div class="breadcrumb-item active"><a href="/">Dashboard</a></div>
         <div class="breadcrumb-item active"><a href="{{ route('employee.classrooms.index') }}">Kelas</a></div>
         <div class="breadcrumb-item">Tambah</div>
      </div>
   </div>

   <div class="section-body">
      <h2 class="section-title">Tambah Kelas</h2>
      <p class="section-lead">
         Formulir ini digunakan untuk menambah kelas baru. Masukkan data yang diperlukan dengan lengkap.
      </p>

      <div class="row mt-sm-4">
         <div class="col-12 col-md-12 col-lg-12">
            <div class="card">
               <form action="{{ route('employee.classrooms.store') }}" method="post" enctype="multipart/form-data" novalidate="">
                  @csrf
                  <div class="card-header">
                     <h4>Tambah Kelas</h4>
                  </div>
                  <div class="card-body">
                     <div class="row">
                        <div class="form-group col-md-12 col-12">
                           <label>Nama Kelas<x-label-required></x-label-required></label>
                           <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" placeholder="Masukkan Nama" autocomplete="off">
                           <x-invalid-feedback field='name'></x-invalid-feedback>
                        </div>
                     </div>
                     <div class="row">
                        <div class="form-group col-md-6 col-12">
                           <label>Wali Kelas <x-label-required></x-label-required></label>
                           <select class="form-control select2" name="user_id">
                              <option selected disabled>Pilih Wali Kelas</option>
                              @foreach ($teachers as $item)
                              <option value="{{ $item->id }}" {{ old('user_id') == $item->id ? 'selected' : '' }}>{{ $item->name }}</option>
                              @endforeach
                           </select>
                           @error('user_id')
                           <div class="form-text text-danger">{{ $message }}</div>
                           @enderror
                        </div>
                        <div class="form-group col-md-6 col-12">
                           <label>Biaya SPP / Bulan <x-label-required></x-label-required></label>
                           <div class="input-group">
                               <div class="input-group-prepend">
                                   <div class="input-group-text">
                                       Rp.
                                   </div>
                               </div>
                               <input type="numeric" class="form-control @error('spp_fee') is-invalid @enderror" id="price-input" name="spp_fee" value="{{ old('spp_fee') }}" placeholder="250000" autocomplete="off">
                           </div>
                           @error('spp_fee')
                              <div class="form-text text-danger">{{ $message }}</div>
                           @enderror
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

