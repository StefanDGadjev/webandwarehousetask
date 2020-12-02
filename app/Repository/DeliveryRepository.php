<?php

namespace App\Repository;

use App\Models\Delivery;
use App\Models\Imei;

class DeliveryRepository
{
    private $deliveryModel;
    private $imeiModel;

    public function __construct(Delivery $deliveryModel, Imei $imeiModel)
    {
        $this->deliveryModel = $deliveryModel;
        $this->imeiModel = $imeiModel;
    }

    public function allLatestPaginate()
    {
        return $this->deliveryModel::latest()->paginate(5);
    }

    public function getAttachProducts(Delivery $delivery)
    {
        $products = [];

        foreach($delivery->products()->get() as $product)
        {
            $Imeis = Imei::where('delivery_product_id', $product->pivot->id)->get();
            array_push($products,[ 'product' =>$product, 'imeis' => $Imeis]);

        }
        return $products;
    }

    public function getDeliveryProducts(Delivery $delivery)
    {
        return $delivery->products()->get();

    }



    public function store($request)
    {
        $request->validate([
            'name' => 'required',
        ]);

        $delivery = new Delivery();

        $delivery->name = $request->name;

        $delivery->save();

        $products = collect(array_filter($request->input('products', [])))
            ->map(function ($product){
                if($product != null)
                {
                    return ['amount' => $product];
                }
                return null;
            });

        $delivery->products()->sync($products);

        $delivery->save();
    }

    public function update($request, Delivery $delivery)
    {
        $request->validate([
            'name' => 'required',
        ]);

        $delivery->name = $request->name;

        $delivery->save();
    }

    public function saveImei($imeis, $deliveryId)
    {

        $status = 1;
        foreach($imeis as $deliveryProductId => $imei)
        {
            foreach($imei as $product_id => $value)
            {
                foreach($value as $key => $name)
                if($name != null) {
                    $imeiModel = new Imei();
                    $imeiModel->imei = $name;
                    $imeiModel->product_id = $product_id;
                    $imeiModel->delivery_product_id = $deliveryProductId;
                    $imeiModel->save();
                }else{
                    $status = 0;
                }
            }
        }
        if($status == 1){
            $delivery = Delivery::find($deliveryId);
            $delivery->status = "done";
            $delivery->save();
        }
    }

    public function delete($delivery)
    {
        $delivery->delete();
    }



}
