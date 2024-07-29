@extends('layouts.master')

@section('content')
    <div class="pagetitle">
        <h1>Tagihan {{ $klinik->nama_klinik }}</h1>
    </div>
    <div class="alert alert-info align-items-center" role="alert">
        <i class="bi bi-exclamation-triangle-fill flex-shrink-0 me-2"></i>
        Jika ingin melakukan konsultasi harap membayar sebesar&nbsp;<strong>Rp. 20.000,00</strong>&nbsp; ke Nomor Rekening
        &nbsp;<strong>{{ $klinik->no_rek }}</strong>&nbsp; dan upload bukti
        bayarnya
        disini
    </div>

    <section class="section">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="card-body">
                            @if (isset(App\Models\Transaksi::where('user_id', Auth::user()->id)->first()->status) &&
                                    App\Models\Transaksi::where('user_id', Auth::user()->id)->first()->status == 'Valid')
                                <div class="alert alert-success" role="alert">
                                    <i class="bi bi-check-circle-fill text-success me-2"></i> Status pembayaran anda valid.
                                    Tekan tombol dibawah ini untuk melakukan konsultasi
                                </div>
                                <a href="{{ url('konsultasi/dokter') }}" class="btn btn-primary">Konsultasi</a>
                            @elseif(isset(App\Models\Transaksi::where('user_id', Auth::user()->id)->first()->status) &&
                                    App\Models\Transaksi::where('user_id', Auth::user()->id)->first()->status == 'Menunggu')
                                <div class="alert alert-warning" role="alert">
                                    Pembayaran anda sedang dicek terlebih dahulu. Jika ada kesalahan upload bukti bayarnya,
                                    bisa diupload ulang.
                                </div>
                                <form action="{{ route('transaksi.store') }}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="bukti_bayar" class="form-label">Bukti Bayar</label>
                                        <input type="file"
                                            class="form-control @error('bukti_bayar') is-invalid @enderror" id="bukti_bayar"
                                            name="bukti_bayar">
                                        @error('bukti_bayar')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <button type="submit" class="btn btn-primary">Kirim</button>
                                </form>
                            @elseif(isset(App\Models\Transaksi::where('user_id', Auth::user()->id)->first()->status) &&
                                    App\Models\Transaksi::where('user_id', Auth::user()->id)->first()->status == 'Tidak Valid')
                                <div class="alert alert-danger" role="alert">
                                    Pembayaran anda tidak valid. Silahkan upload bukti pembayaran yang sah
                                </div>
                                <form action="{{ route('transaksi.store') }}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="bukti_bayar" class="form-label">Bukti Bayar</label>
                                        <input type="file"
                                            class="form-control @error('bukti_bayar') is-invalid @enderror" id="bukti_bayar"
                                            name="bukti_bayar">
                                        @error('bukti_bayar')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <button type="submit" class="btn btn-primary">Kirim</button>
                                </form>
                            @else
                                <form action="{{ route('transaksi.store') }}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="klinik_id" value="{{ $klinik->id }}">
                                    <div class="mb-3">
                                        <label for="bukti_bayar" class="form-label">Bukti Bayar</label>
                                        <input type="file"
                                            class="form-control @error('bukti_bayar') is-invalid @enderror" id="bukti_bayar"
                                            name="bukti_bayar">
                                        @error('bukti_bayar')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <button type="submit" class="btn btn-primary">Kirim</button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
    </section>
@endsection
