@extends('app')
@section('content')
    <div class="section">
        <div class="section-header">
            <h1>Dashboard</h1>
        </div>
        <div class="row">
            <div class="col-12 mb-4">
                @if (!isset(Auth::user()->classroom))
                    <div class="alert alert-warning alert-has-icon">
                        <div class="alert-icon"><i class="far fa-lightbulb"></i></div>
                        <div class="alert-body">
                        <div class="alert-title">Pemberitahuan</div>
                        Saat ini, Anda belum memiliki kelas yang diampu.
                        </div>
                    </div>
                @endif
                <div class="hero text-white hero-bg-image" style="background-image: url('assets/img/me/school-field2.jpg');">
                    <div class="hero-inner">
                        <h2>Selamat Datang, {{ Auth::user()->name }}!</h2>
                        <p class="lead">Di sini Anda dapat melihat ringkasan pembayaran, memantau status pembayaran siswa di kelas anda.</p>
                        <div class="mt-4">
                            <a href="" class="btn btn-outline-white btn-lg btn-icon icon-left"><i
                                    class="fas fa-money-bill-wave"></i> Lihat Pembayaran Siswa</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
