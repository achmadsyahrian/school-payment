@extends('app')
@section('content')
    <div class="section">
        <x-sweetalert></x-sweetalert>

        <div class="section-header">
            <h1>Pembayaran</h1>
            <div class="section-header-button">
                {{-- <a href="{{ route('employee.payments.create') }}" class="btn btn-primary">Tambah</a> --}}
            </div>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="/">Dashboard</a></div>
                <div class="breadcrumb-item">Pembayaran</div>
            </div>
        </div>

        <div class="section-body">
            <h2 class="section-title">Pembayaran</h2>
            <p class="section-lead">
                Kelola dan pantau semua pembayaran SPP siswa dengan mudah dan efisien
            </p>

            <div class="row mt-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Data Siswa</h4>
                        </div>
                        <div class="card-body">
                            <div class="float-right">
                                <div class="input-group">
                                    <button type="button" class="btn btn-primary ml-3" data-toggle="modal"
                                        data-target="#exampleModal">Pencarian Lanjutan</button>
                                    <form action="{{ route('employee.payments.index') }}" method="GET"
                                        style="display:inline;">
                                        <button type="submit" class="btn btn-secondary ml-3">Reset Pencarian</button>
                                    </form>
                                </div>
                            </div>
                            <div class="clearfix mb-3"></div>

                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <tr>
                                        <th>#</th>
                                        <th>Nama Murid</th>
                                        <th>Tahun Ajaran Masuk</th>
                                        <th>Kelas</th>
                                        <th>Aksi</th>
                                    </tr>
                                    @forelse ($students as $item)
                                        <tr>
                                            <td>{{ ($students->currentPage() - 1) * $students->perPage() + $loop->iteration }}</td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    @if ($item->user->photo)
                                                        <img alt="image"
                                                            src="{{ asset('storage/photos/user/' . $item->user->photo) }}"
                                                            class="rounded-circle" style="object-fit: cover" width="35"
                                                            height="35" data-toggle="title" title="">
                                                    @else
                                                        <img alt="image"
                                                            src="{{ asset('assets/img/avatar/avatar-1.png') }}"
                                                            class="rounded-circle" width="35" data-toggle="title"
                                                            title="">
                                                    @endif
                                                    <div class="ml-3">
                                                        <div>{{ $item->user->name }}</div>
                                                        <div>
                                                            NISN: <a href="#">{{ $item->nisn ?? '--' }}</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="badge badge-info"><i class="fas fa-calendar-alt"></i> {{ $item->academicYear->name }}</div>
                                            </td>
                                            <td>
                                                {{ $item->classroom->name }}
                                            </td>
                                            <td>
                                                <a href="{{ route('employee.payments.studentDetail', [$item->nisn]) }}"
                                                    class="btn btn-success btn-action mr-1" data-toggle="tooltip"
                                                    title="Transaksi"><i class="fas fa-money-bill-wave"></i></a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="100" class="text-center">Data tidak tersedia <i class="far fa-sad-tear"></i></td>
                                        </tr>
                                    @endforelse
                                </table>
                            </div>
                            <x-pagination :data="$students"></x-pagination>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('employee.payments.modal')
@endsection
