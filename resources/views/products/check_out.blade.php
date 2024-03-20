@extends('layouts.app')
@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <a href="{{ url('home') }}" class="btn btn-primary"><i class="fa fa-arrow-left"></i> Kembali</a>
            </div>
            <div class="col-md-12 mt-2">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('home') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Check Out</li>
                    </ol>
                </nav>
            </div>
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <h3><i class="fa fa-shopping-cart"></i> Check Out</h3>
                        @if (!empty($orders))
                            <p align="right">Tanggal Pesan : {{ $orders->date }}</p>
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Gambar</th>
                                        <th>Nama Barang</th>
                                        <th>Jumlah</th>
                                        <th>Harga</th>
                                        <th>Total Harga</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($details_orders as $key => $details_order)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>
                                                @php
                                                    $product = collect($filtered_products)->firstWhere(
                                                        'id',
                                                        $details_order->product_id,
                                                    );
                                                @endphp

                                                @if ($product)
                                                    <img src="{{ $product['image'] }}" width="100" alt="Product Image">
                                                @else
                                                    <span>Gambar tidak tersedia</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($product)
                                                    {{ $product['title'] }}
                                                @else
                                                    <span>Data produk tidak tersedia</span>
                                                @endif
                                            </td>
                                            <td>{{ $details_order->total }} </td>
                                            <td>
                                                @if ($product)
                                                    Rp. {{ number_format($product['price']) }}
                                                @else
                                                    <span>Data produk tidak tersedia</span>
                                                @endif
                                            </td>
                                            <td align="right">Rp. {{ number_format($details_order->total_price) }}</td>
                                            <td>
                                                <form action="{{ url('check_out') }}/{{ $details_order->id }}"
                                                    method="post">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm"
                                                        onclick="return confirm('Anda yakin akan menghapus data?');">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach

                                    <tr>
                                        <td colspan="5" align="right"><strong>Total Harga :</strong></td>
                                        <td align="right"><strong>Rp. {{ number_format($orders->total_price) }}</strong>
                                        </td>
                                        <td>
                                            <a href="{{ url('konfirmasi-check-out') }}" class="btn btn-success"
                                                onclick="return confirm('Anda yakin akan Check Out?');">
                                                <i class="fa fa-shopping-cart"></i> Check Out
                                            </a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

    <script>
        $(document).on('submit', '#delete', function(event) {
            event.preventDefault();
            var formData = $(this).serialize(); // Ambil data formulir

            // Kirim permintaan AJAX
            $.ajax({
                type: 'Delete',
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
    </script>
@endsection
