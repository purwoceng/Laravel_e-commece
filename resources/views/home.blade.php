@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="">
                    <div class="card-header">{{ __('Products') }}</div>
                    <div class="row">
                        @foreach ($products as $index => $product)
                            <div class="col-md-4">
                                <div class="card mb-5">
                                    <img src="{{ $product->image }}" class="card-img-top" alt="..."
                                        style="height: 200px; ">
                                    <div class="card-body">
                                        <h5 class="card-title"
                                            style="height: 40px; overflow: hidden; text-overflow: ellipsis;">
                                            {{ $product->title }}</h5>
                                        <p class="card-text">
                                            <strong>Harga :</strong> Rp. {{ number_format($product->price) }} <br>
                                            <strong>Rating :</strong> {{ $product->rating->rate }} <br>
                                            <hr>
                                        </p>
                                        <a href="{{ url('pesan') }}/{{ $product->id }}" class="btn btn-primary"><i
                                                class="fa fa-shopping-cart"></i> Pesan</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
