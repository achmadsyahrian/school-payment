@extends('app')
@section('content')

<div class="section">
   <x-sweetalert></x-sweetalert>

   <div class="section-header mb-5">
      <div class="section-header-back">
         <a href="{{ route('teacher.students.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
      </div>
      <h1>Pembayaran</h1>
      <div class="section-header-breadcrumb">
         <div class="breadcrumb-item active"><a href="/">Dashboard</a></div>
         <div class="breadcrumb-item active"><a href="{{ route('teacher.students.index') }}">Siswa</a></div>
         <div class="breadcrumb-item active"><a href="{{ route('teacher.students.index') }}">Pembayaran</a></div>
         <div class="breadcrumb-item">{{ $student->user->name }}</div>
      </div>
   </div>

   <div class="section-body">
      <div class="col-12 col-sm-12 col-lg-12 ">
         <div class="card profile-widget">
           <div class="profile-widget-header">                     
             @if ($student->user->photo)
                  <img alt="image"
                     src="{{ asset('storage/photos/user/' . $student->user->photo) }}"
                     class="rounded-circle profile-widget-picture" style="object-fit: cover" width="100"
                     height="100" data-toggle="title" title="">
               @else
                  <img alt="image"
                     src="{{ asset('assets/img/avatar/avatar-1.png') }}"
                     class="rounded-circle profile-widget-picture" width="35" data-toggle="title"
                     title="">
               @endif
             <div class="profile-widget-items">
               <div class="profile-widget-item">
                  <div class="profile-widget-item-label">Periode Masuk</div>
                  <div class="profile-widget-item-value">{{ $student->academicYear->name }}</div>
                </div>
               <div class="profile-widget-item">
                 <div class="profile-widget-item-label">Kelas</div>
                 <div class="profile-widget-item-value">{{ $student->classroom->name }}</div>
               </div>
               <div class="profile-widget-item">
                 <div class="profile-widget-item-label">Wali Kelas</div>
                 <div class="profile-widget-item-value">{{ $student->classroom->teacher->name }}</div>
               </div>
             </div>
           </div>
           <div class="profile-widget-description pb-0">
             <div class="profile-widget-name">{{ $student->user->name }} <div class="text-muted d-inline font-weight-normal"><div class="slash"></div> {{ $student->nisn }}</div></div>
             <div class="row sortable-card">
               @foreach ($academicYears as $item)
                  <div class="col-12 col-md-6 col-lg-3">
                     <div class="card {{ $item->isComplete ? 'card-success' : 'card-primary' }}">
                           <div class="card-header">
                              <h4>TA : {{ $item->name }}</h4>
                              @if ($item->isActive)
                                 <span class="badge bg-success text-white">Saat Ini</span>
                              @endif
                              @if ($item->isComplete)
                                 <span class="badge bg-success text-white ml-1"><i class="far fa-check-circle"></i> Lunas</span>
                              @endif
                           </div>
                           <div class="card-body">
                              <a href="{{ route('teacher.payments.studentDetailPayment', [$student->nisn, $item->name]) }}" class="btn {{ $item->isComplete ? 'btn-success' : 'btn-primary' }} btn-action mr-1">
                                 <i class="fas fa-eye"></i> Lihat Pembayaran
                              </a>
                           </div>
                     </div>
                  </div>
               @endforeach
             </div>
           </div>
         </div>
      </div>
   </div>
</div>


@endsection

