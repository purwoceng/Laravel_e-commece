<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="{{ config('midtrans.client_key') }}"></script>


    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

    <!-- Font Awesome CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">


    <!-- Styles -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>

<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    <img src="https://i.pinimg.com/564x/b6/3e/e9/b63ee922f91de19dc1c27feb55a74401.jpg" alt="img"
                        width="75" height="75">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item">
                                @php
                                    $pesanan_utama = \App\Models\Orders::where('user_id', Auth::user()->id)
                                        ->where('status', 0)
                                        ->first();
                                    if (!empty($pesanan_utama)) {
                                        $notif = \App\Models\DetailOrders::where(
                                            'order_id',
                                            $pesanan_utama->id,
                                        )->count();
                                    } else {
                                        $notif = 0;
                                    }
                                @endphp
                                @if ($notif == 0)
                                    <a href="#" onclick="return confirm('Anda Belum Memasukkan Produk?');">
                                        <i class="fa fa-shopping-cart fa-lg"></i>
                                        <span class="badge badge-danger">0</span>
                                    </a>
                                @else
                                    <a class="nav-link" href="{{ url('check_out') }}">
                                        <i class="fa fa-shopping-cart fa-lg"></i>
                                        @if ($notif > 0)
                                            <span class="badge badge-danger">{{ $notif }}</span>
                                        @endif

                                    </a>
                                @endif
                            </li>

                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>
                                    <a class="dropdown-item" href="{{ url('history') }}">
                                        Riwayat Pemesanan
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            <div id="snap-container"></div>
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <a href="{{ url('home') }}" class="btn btn-primary"><i class="fa fa-arrow-left"></i>
                            Kembali</a>
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
                                                            <img src="{{ $product['image'] }}" width="100"
                                                                alt="Product Image">
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
                                                    <td align="right">Rp.
                                                        {{ number_format($details_order->total_price) }}</td>
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
                                                <td align="right"><strong>Rp.
                                                        {{ number_format($orders->total_price) }}</strong>
                                                </td>
                                                {{-- <td>
                                            <button id="pay-button" class="btn btn-success"> <i class="fa fa-shopping-cart"></i> Check Out</button>
                                        </td> --}}
                                            </tr>
                                        </tbody>
                                    </table>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
    <button id="pay-button" class="btn btn-success" style="margin-left: 50%"> <i class="fa fa-shopping-cart"></i>
        Check Out</button>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js"></script>
    <script></script>
    <script type="text/javascript">
        // For example trigger on button clicked, or any time you need
        var payButton = document.getElementById('pay-button');
        payButton.addEventListener('click', function() {
            // Trigger snap popup. @TODO: Replace TRANSACTION_TOKEN_HERE with your transaction token
            window.snap.pay('{{ $snapToken }}', {
                onSuccess: function(result) {
                var confirmationUrl = "{{ url('konfirmasi-check-out') }}";
                window.location.href = confirmationUrl;
                alert("Payment success!");
                console.log(result);
                 },
                onPending: function(result) {
                    /* You may add your own implementation here */
                    alert("wating your payment!");
                    console.log(result);
                },
                onError: function(result) {
                    /* You may add your own implementation here */
                    alert("payment failed!");
                    console.log(result);
                },
                onClose: function() {
                    /* You may add your own implementation here */
                    alert('you closed the popup without finishing the payment');
                }
            })
        });
    </script>
</body>

</html>
