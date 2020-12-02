@extends('layouts.app')


@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2> Show Delivery </h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('deliveries.index') }}" title="Go back"> <i class="fas fa-backward "></i> </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Name: </strong>
                {{ $delivery->name }}
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Date Created: </strong>
                {{ date_format($delivery->created_at, 'jS M Y') }}
            </div>
        </div>
        <table class="table table-bordered table-responsive-lg">
            <tr>
                <th>Product</th>
                <th>amount</th>
            </tr>
            @foreach ($products as $product)

                <tr>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->pivot->amount }}</td>
                </tr>

            @endforeach
        </table>
    </div>
@endsection
