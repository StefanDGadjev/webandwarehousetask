@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Imei Delivery</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('deliveries.index') }}" title="Go back"> <i class="fas fa-backward "></i> </a>
            </div>
        </div>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Error!</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('delivery.create.imeis', $delivery->id) }}" method="POST">
        @csrf

        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Name:</strong>
                    {{ $delivery->name }}
                </div>
            </div>
            <table class="table table-bordered table-responsive-lg">
                <tr>
                    <th>Product</th>
                    <th>Amount</th>
                </tr>

                @foreach ($products as $product)
                    <tr>
                        <td>{{ $product['product']->name }}</td>
                        <td>{{ $product['product']->pivot->amount }}</td>


                    @for ($i = count($product['imeis']); $i < $product['product']->pivot->amount; $i++)

                            <td>
                                <input type="text" name="imei[{{ $product['product']->pivot->id }}][{{$product['product']->id}}][]" placeholder="IMEI" />
                            </td>

                    @endfor
                    @foreach ($product['imeis'] as $imei)
                        <td> {{ $imei->imei }}</td>
                    @endforeach
                    </tr>
                @endforeach
            </table>
            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </div>

    </form>
@endsection
