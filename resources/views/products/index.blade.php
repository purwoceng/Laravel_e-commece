@extends('layouts.app')

@section('content')
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <a href="{{ url('home') }}" class="btn btn-primary"><i class="fa fa-arrow-left"></i> Kembali</a>
            </div>
            <div class="col-md-12 mt-2">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('home') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $product->title }}</li>
                    </ol>
                </nav>
            </div>
            <div class="col-md-12 mt-1">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <img src="{{ $product->image }}" class="rounded mx-auto d-block" width="35%"
                                    alt="">
                            </div>
                            <div class="col-md-6 mt-5">
                                <h2>{{ $product->title }}</h2>
                                <table class="table">
                                    <tbody>
                                        <tr>
                                            <td>Harga</td>
                                            <td>:</td>
                                            <td>Rp. {{ number_format($product->price) }}</td>
                                        </tr>
                                        <tr>
                                            <td>Jumlah Pesan</td>
                                            <td>:</td>
                                            <td>
                                                <form method="post" action="{{ url('pesan') }}/{{ $product->id }}"
                                                    id="orderForm">
                                                    @csrf
                                                    <input type="number" min="1" name="jumlah_pesan"
                                                        class="form-control" required="" value="1">
                                                    <button type="submit" class="btn btn-primary mt-2"><i
                                                            class="fa fa-shopping-cart"></i> Masukkan Keranjang</button>
                                                </form>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-md-12">
                <h2>Produk Lainnya</h2>
                <div class="row">
                    @foreach ($otherProducts as $otherProduct)
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-body">
                                    <img src="{{ $otherProduct->image }}" class="card-img-top" width="60" height="140"
                                        alt="...">
                                    <h5 class="card-title "
                                        style="height: 40px; overflow: hidden; text-overflow: ellipsis;">
                                        {{ $otherProduct->title }}
                                    </h5>
                                    <p class="card-text">Rp. {{ number_format($otherProduct->price) }}</p>
                                    <a href="{{ $otherProduct->id }}" class="btn btn-primary">Lihat
                                        Detail</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    {{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

    <script>

        $(document).on('submit', '#orderForm', function(event) {
            event.preventDefault();
            var formData = $(this).serialize(); // Ambil data formulir

            // Kirim permintaan AJAX
            $.ajax({
                type: 'POST',
                url: $(this).attr('action'),
                data: formData,
                success: function(data) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Pesanan Sukses Masuk Keranjang',
                        showConfirmButton: false,

                    });
                },
                error: function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Gagal memasukkan pesanan ke keranjang',
                    });
                }
            });
        });
    </script> --}}
@endsection
