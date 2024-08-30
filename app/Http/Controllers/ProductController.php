<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __invoke()
    {
        $client = new Client();

        // Melakukan permintaan GET ke API
        $response = $client->request('GET', 'https://fakestoreapi.com/products');

        // Mengambil isi dari respons
        $products = json_decode($response->getBody());

        return view('welcome', ['products' => $products]);
    }
}
