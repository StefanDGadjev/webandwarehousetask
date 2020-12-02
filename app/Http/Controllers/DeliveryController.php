<?php

namespace App\Http\Controllers;

use App\Models\Delivery;
use App\Repository\DeliveryRepository;
use App\Repository\ProductRepository;
use Illuminate\Http\Request;

class DeliveryController extends Controller
{
    private $deliveryRepository;
    private $productRepository;

    public function __construct(
        DeliveryRepository $deliveryRepository,
        ProductRepository $productRepository
    )
    {
        $this->deliveryRepository = $deliveryRepository;
        $this->productRepository = $productRepository;
    }

    public function index()
    {
        $deliveries = $this->deliveryRepository->allLatestPaginate();

        return view('deliveries.index', compact('deliveries'))
            ->with('i', (request()->input('page', 1) - 1));
    }

    public function create()
    {
        $products = $this->productRepository->all();

        return view('deliveries.create',compact('products'));
    }

    public function store(Request $request)
    {
        $this->deliveryRepository->store($request);

        return redirect()->route('deliveries.index')
            ->with('success', 'Delivery created successfully.');
    }

    public function show(Delivery $delivery)
    {
        $products = $this->deliveryRepository->getDeliveryProducts($delivery);

        return view('deliveries.show', compact('delivery','products'));
    }

    public function edit(Delivery $delivery)
    {
        $products = $this->deliveryRepository->getAttachProducts($delivery);

        return view('deliveries.edit', compact('delivery','products'));
    }

    public function createImeis(Request $request)
    {
        if($request->imei) {
            $this->deliveryRepository->saveImei($request->imei,$request->route('id'));
        }

        return redirect()->route('deliveries.index')
            ->with('success', 'Delivery imeis updated successfully');
    }

    public function destroy(Delivery $delivery)
    {
        $this->deliveryRepository->delete($delivery);

        return redirect()->route('deliveries.index')
            ->with('success', 'Delivery deleted successfully');
    }
}
