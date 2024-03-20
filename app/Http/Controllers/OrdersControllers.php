<?php

namespace App\Http\Controllers;

use App\Models\DetailOrders;
use App\Models\Orders;
use App\Models\Products;
use App\Models\User;
use Carbon\Carbon;
use Carbon\Factory;
use GuzzleHttp\Client;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redirect;
use Midtrans\Config;
use Midtrans\Snap;

class OrdersControllers extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index($id)
    {
        $client = new Client();
        $response = $client->request('GET', 'https://fakestoreapi.com/products/' . $id);
        $product = json_decode($response->getBody());
        $response = $client->request('GET', 'https://fakestoreapi.com/products');
        $otherProducts = json_decode($response->getBody());
        return view('products.index', compact('product', 'otherProducts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request, $id)
    {
            $responseProduct = Http::get('https://fakestoreapi.com/products/' . $id);
            $product = $responseProduct->json();
            $responseOtherProducts = Http::get('https://fakestoreapi.com/products');
            $otherProducts = $responseOtherProducts->json();

            $tanggal = Carbon::now();

            // Cek validasi
            $cek_pesanan = Orders::where('user_id', Auth::user()->id)
                ->where('status', 0)
                ->first();

                if (empty($cek_pesanan)) {
                    $orders = new Orders();
                    $orders->user_id = Auth::user()->id;
                    $orders->date = $tanggal;
                    $orders->status = 0;
                    $orders->total_price = 0;

                    // Simpan pesanan
                    $orders->save();
                }


        //simpan ke database pesanan detail
        $pesanan_baru = Orders::where('user_id', Auth::user()->id)
            ->where('status', 0)
            ->first();

        //cek pesanan detail
        $cek_pesanan_detail = DetailOrders::where('product_id', $product['id'])
            ->where('order_id', $pesanan_baru->id)
            ->first();
        if (empty($cek_pesanan_detail)) {
            $pesanan_detail = new DetailOrders();
            $pesanan_detail->product_id = $product['id'];
            $pesanan_detail->order_id = $pesanan_baru->id;
            $pesanan_detail->total = $request->jumlah_pesan;
            $pesanan_detail->total_price = $product['price'] * $request->jumlah_pesan;
            $pesanan_detail->save();
        } else {
            $pesanan_detail = DetailOrders::where('product_id', $product['id'])
                ->where('order_id', $pesanan_baru->id)
                ->first();

            $pesanan_detail->total = $pesanan_detail->total + $request->jumlah_pesan;

            //harga sekarang
            $harga_pesanan_detail_baru = $product['price'] * $request->jumlah_pesan;
            $pesanan_detail->total_price = $pesanan_detail->total_price + $harga_pesanan_detail_baru;
            $pesanan_detail->update();
        }

        //jumlah total
        $pesanan = Orders::where('user_id', Auth::user()->id)
            ->where('status', 0)
            ->first();
        $pesanan->total_price = $pesanan->total_price + $product['price'] * $request->jumlah_pesan;
        $pesanan->update();

        return redirect()->route('check_out')->with('success', 'Pesanan berhasil ditambahkan');

    }

    /**
     * Store a newly created resource in storage.
     */
    public function check_out()
{
    $response = Http::get('https://fakestoreapi.com/products/');
    $products = $response->json();

    $orders = Orders::where('user_id', Auth::user()->id)
                    ->where('status', 0)
                    ->first();

    $details_orders = [];
    $filtered_products = [];

    if ($orders) {
        $details_orders = DetailOrders::where('order_id', $orders->id)->get();

        if ($details_orders->isNotEmpty()) {
            $product_ids = $details_orders->pluck('product_id')->toArray();

            $filtered_products = collect($products)->whereIn('id', $product_ids)->all();
        }
    }

    return view('products.check_out', compact('orders', 'details_orders', 'filtered_products'));
}



    /**
     * Display the specified resource.
     */
    // public function konfirmasi()
    // {
    //     $user = User::where('id', Auth::user()->id)->first();

    //     // if(empty($user->alamat))
    //     // {
    //     //     Alert::error('Identitasi Harap dilengkapi', 'Error');
    //     //     return redirect('profile');
    //     // }

    //     // if(empty($user->nohp))
    //     // {
    //     //     Alert::error('Identitasi Harap dilengkapi', 'Error');
    //     //     return redirect('profile');
    //     // }

    //     $order = Orders::where('user_id', Auth::user()->id)->where('status',0)->first();
    //     $order_id = $order->id;
    //     $order->status = 1;
    //     $order->update();

    //     Alert::success('Pesanan Sukses Check Out Silahkan Lanjutkan Proses Pembayaran', 'Success');
    //     return redirect('history/'.$order_id);

    // }


    public function konfirmasi()
    {
        // Konfigurasi Midtrans
        Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        Config::$clientKey = env('MIDTRANS_CLIENT_KEY');
        Config::$isProduction = !env('MIDTRANS_IS_SANDBOX');

        // Ambil data pesanan yang akan dikonfirmasi
        $order = Orders::where('user_id', Auth::user()->id)
                        ->where('status', 0)
                        ->first();

        // Periksa apakah ada pesanan yang belum dikonfirmasi
        if (!$order) {
            // Jika tidak ada pesanan yang belum dikonfirmasi, tampilkan pesan error
            return redirect()->back()->with('error', 'Tidak ada pesanan yang harus dikonfirmasi.');
        }

        // Ubah status pesanan menjadi "Sedang Dikonfirmasi" (misalnya, status = 1)
        $order->status = 1;
        $order->update();

        // Data transaksi untuk Midtrans
        $transactionDetails = [
            'order_id' => $order->id,
            'gross_amount' => $order->total_price,
        ];

        try {
            // Buat transaksi Snap menggunakan SDK Midtrans
            $snapToken = Snap::getSnapToken($transactionDetails);

            // Redirect ke halaman pembayaran menggunakan snapToken
            return redirect()->away(Snap::getSnapUrl($snapToken));
        } catch (\Exception $e) {
            // Tangani kesalahan saat membuat transaksi Snap
            return redirect()->back()->with('error', 'Terjadi kesalahan saat membuat transaksi pembayaran.');
        }
    }





    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete($id)
    {
        $detail_order = DetailOrders::where('id', $id)->first();

        $order = Orders::where('id', $detail_order->order_id)->first();
        $order->total_price = $order->total_price-$detail_order->total_price;
        $order->update();


        $detail_order->delete();
        return redirect('check_out');
    }
}
