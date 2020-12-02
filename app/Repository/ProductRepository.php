<?php

namespace App\Repository;

use App\Models\Product;
use Illuminate\Support\Facades\Storage;

class ProductRepository
{
    private $model;

    public function __construct(Product $model)
    {
        $this->model = $model;
    }

    public function all()
    {
        return $this->model::all();
    }

    public function allLatestPaginate()
    {
        return $this->model::latest()->paginate(5);
    }

    public function store($request)
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        $image_name = $this->hashImageName($request->image);

        Storage::disk('products_images')->putFileAs('', $request->image, $image_name);

        $product = new Product;

        $product->name = $request->name;
        $product->price = $request->price;
        $product->image = $image_name;

        $product->save();
    }

    private function hashImageName($image)
    {
        return md5($image->getClientOriginalName() . uniqid('products')) . '.' . $image->getClientOriginalExtension();
    }

    public function update($request, Product $product)
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required',
            'image' => 'nullable'
        ]);

        if ($request->image) {
            Storage::disk('products_images')->delete($product->image);

            $image_name = $this->hashImageName($request->image);

            Storage::disk('products_images')->putFileAs('', $request->image, $image_name);

            $product->image = $image_name;
        }

        $product->name = $request->name;
        $product->price = $request->price;

        $product->save();
    }

    public function delete($product)
    {
        Storage::disk('products_images')->delete($product->image);
        $product->delete();
    }
}
