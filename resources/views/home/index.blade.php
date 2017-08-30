<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{$title}}</title>
    <link href="{{ asset('/css/bootstrap.min.css') }}" rel="stylesheet">
    <script src="{{ asset('/js/jquery.js') }}"></script>
    <script src="{{ asset('/js/bootstrap.js') }}"></script>
    <style>
        .product img {
            display: block;
            width: 100%;
        }
        .product p{
            font-weight: bolder;
        }
    </style>
</head>
<body>
<div class="flex-center position-ref full-height">
    <div class="container-fluid">
        <div class="row">

            <div class="col-md-12">
                @foreach($currencies as $curr)
                    <a class="btn {{ $curr == $currency ? 'btn-primary' : 'btn-default' }}"
                       href="{{URL::to('/')."/".$curr}}">{{$curr}}</a>
                @endforeach
            </div>
            <div class="product_cont col-md-12">
                <h2>{{$title}}</h2>
                @foreach($products as $product)
                    <div class="product col-md-4">
                        <div class="img-responsive">
                            <img src="{{$product['url']}}">
                        </div>
                        <h3>{{$product["name"]}}</h3>

                        <p>{{$product["price"]}} {{$currency}}</p>
                    </div>
                @endforeach

            </div>
        </div>
    </div>
</div>
</body>
</html>
