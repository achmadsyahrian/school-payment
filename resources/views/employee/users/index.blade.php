@extends('app')
@section('content')

<div class="section">
   <x-sweetalert></x-sweetalert>

   <div class="section-header">
      <h1>Pegawai</h1>
      <div class="section-header-button">
         <a href="{{ route('employee.users.create') }}" class="btn btn-primary">Tambah</a>
      </div>
      <div class="section-header-breadcrumb">
         <div class="breadcrumb-item active"><a href="/">Dashboard</a></div>
         <div class="breadcrumb-item">Pegawai</div>
      </div>
   </div>
   
   <div class="section-body">
      <h2 class="section-title">Pegawai</h2>
      <p class="section-lead">
         Anda memiliki kontrol penuh atas semua akun pegawai administrasi, termasuk opsi mengedit dan menghapus.
      </p>
   
      <div class="row mt-4">
         <div class="col-12">
            <div class="card">
               <div class="card-header">
                  <h4>Data Pegawai</h4>
               </div>
               <div class="card-body">
                  <div class="float-right">
                     <div class="input-group">
                        <button type="button" class="btn btn-primary ml-3" data-toggle="modal" data-target="#exampleModal">Pencarian Lanjutan</button>
                        <form action="{{ route('employee.users.index') }}" method="GET" style="display:inline;">
                           <button type="submit" class="btn btn-secondary ml-3">Reset Pencarian</button>
                        </form>
                     </div>
                  </div>
                  <div class="clearfix mb-3"></div>
   
                  <div class="table-responsive">
                     <table class="table table-striped">
                        <tr>
                           <th>#</th>
                           <th>Nama</th>
                           <th>Username</th>
                           <th>No Telepon</th>
                           <th>Aksi</th>
                        </tr>
                        @forelse ($data as $item)
                           <tr>
                              <td>{{ ($data->currentPage() - 1) * $data->perPage() + $loop->iteration }}</td>
                              <td>
                                 <div class="d-flex align-items-center">
                                    @if ($item->photo)
                                       <img alt="image" src="{{ asset('storage/photos/user/' . $item->photo) }}" class="rounded-circle" style="object-fit: cover" width="35" height="35" data-toggle="title" title="">
                                    @else
                                       <img alt="image" src="{{ asset('assets/img/avatar/avatar-1.png') }}" class="rounded-circle" width="35" data-toggle="title" title="">
                                    @endif
                                     <div class="ml-3">
                                         <div>{{ $item->name }}</div>
                                         <div>
                                             <a href="mailto:{{ $item->email }}">{{ $item->email ?? '--' }}</a>
                                         </div>
                                     </div>
                                 </div>
                             </td>
                              <td>
                                 {{ $item->username }}
                              </td>
                              <td>
                                 @if ($item->phone)
                                    <div class="badge badge-primary"><i class="fas fa-mobile-alt"></i> {{ $item->phone }}</div>
                                 @else
                                    --
                                 @endif
                              </td>
                              <td>
                                 <a href="{{ route('employee.users.edit', [$item]) }}" class="btn btn-primary btn-action mr-1" data-toggle="tooltip" title="Edit"><i class="fas fa-pencil-alt"></i></a>
                                 <form class="d-inline" action="{{ route('employee.users.destroy', $item) }}" method="post" id="delete-data-{{ $item->id }}">
                                    @method('delete')
                                    @csrf
                                    <button type="button" class="btn btn-danger btn-action" onclick="showDeleteConfirmation('Ya, Hapus', 'Apakah anda yakin ingin menghapus pegawai ini?', 'delete-data-{{ $item->id }}')" data-toggle="tooltip" title="Hapus"><i class="fas fa-trash"></i></button>
                                 </form>
                               </td>
                           </tr>
                        @empty
                            <tr>
                              <td colspan="100" class="text-center">Data tidak tersedia <i class="far fa-sad-tear"></i></td>
                            </tr>
                        @endforelse
                     </table>
                  </div>
                  <x-pagination :data="$data"></x-pagination>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>

@include('employee.users.modal')
@endsection