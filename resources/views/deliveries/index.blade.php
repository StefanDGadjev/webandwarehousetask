@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2> OnlineShop - Deliveries </h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-success" href="{{ route('deliveries.create') }}" title="Create a product"> <i class="fas fa-plus-circle"></i>
                </a>
            </div>
        </div>
    </div>

    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p> {{ $message }} </p>
        </div>
    @endif

    <table class="table table-bordered table-responsive-lg">
        <tr>
            <th>Name</th>
            <th>Status</th>
            <th>Date Created</th>
            <th>Actions</th>
        </tr>
        @foreach ($deliveries as $delivery)
            <tr>
                <td>{{ $delivery->name }}</td>
                <td>{{ $delivery->status }}</td>
                <td>{{ date_format($delivery->created_at, 'jS M Y') }}</td>
                <td>
                    <form action="{{ route('deliveries.destroy', $delivery->id) }}" method="POST">

                        <a href="{{ route('deliveries.show', $delivery->id) }}" title="show">
                            <i class="fas fa-eye text-success  fa-lg"></i>
                        </a>

                        <a href="{{ route('deliveries.edit', $delivery->id) }}">
                            <i class="fas fa-edit  fa-lg"></i>
                        </a>

                        @csrf
                        @method('DELETE')

                        <button type="submit" title="delete" style="border: none; background-color:transparent;">
                            <i class="fas fa-trash fa-lg text-danger"></i>
                        </button>
                    </form>
                </td>
            </tr>
        @endforeach
    </table>

    {!! $deliveries->links() !!}

@endsection
