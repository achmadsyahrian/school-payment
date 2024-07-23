<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
       <div class="sidebar-brand">
          <a href="/"><img src="{{ asset('assets/img/me/school-logo.png') }}" width="30" alt=""> {{ config('app.name') }}</a>
       </div>
       <div class="sidebar-brand sidebar-brand-sm">
          <a href="/">
             <img src="{{ asset('assets/img/me/Logopotensiutama.png') }}" width="30" alt="">
          </a>
       </div>
       <ul class="sidebar-menu">
          <li class="menu-header">Dashboard</li>
          <li class="{{ Request::is('/') ? 'active' : '' }}"><a class="nav-link" href="/"><i class="fas fa-tachometer-alt"></i> <span>Dashboard</span></a></li>
 
          @if (Auth::user()->role_id == 1)
 
          @elseif (Auth::user()->role_id == 2)
 
          <li class="menu-header">Manajemen</li>
          <li class="{{ Request::is('*users*') ? 'active' : '' }}"><a class="nav-link" href="{{ route('employee.users.index') }}"><i class="fas fa-user-cog"></i> <span>Pegawai</span></a></li>
          <li class="{{ Request::is('*teachers*') ? 'active' : '' }}"><a class="nav-link" href="{{ route('employee.teachers.index') }}"><i class="fas fa-chalkboard-teacher"></i> <span>Wali Kelas</span></a></li>
          <li class="{{ Request::is('*classrooms*') ? 'active' : '' }}"><a class="nav-link" href="{{ route('employee.classrooms.index') }}"><i class="fas fa-chalkboard"></i> <span>Kelas</span></a></li>
          <li class="{{ Request::is('*students*') ? 'active' : '' }}"><a class="nav-link" href=""><i class="fas fa-users"></i> <span>Siswa</span></a></li>
 
 
          <li class="menu-header">Transaksi</li>
          <li class="{{ Request::is('*transactions*') ? 'active' : '' }}"><a class="nav-link" href=""><i class="fas fa-money-bill-wave"></i> <span>Pembayaran</span></a></li>
          @endif
       </ul>
 
       <div class="mt-4 mb-4 p-3 hide-sidebar-mini">
          <a href="https://instagram.com/_achrian" target="_blank" class="btn btn-primary btn-lg btn-block btn-icon-split">
             <i class="fab fa-instagram"></i> SMK Negeri Medan
          </a>
       </div>
    </aside>
 </div>
 