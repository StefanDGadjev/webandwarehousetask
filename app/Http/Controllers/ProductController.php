<?php

namespace App\Http\Controllers;

use App\Models\Imei;
use App\Models\Product;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\Request;
use App\Repository\ProductRepository;

class ProductController extends Controller
{
    private $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function index()
    {
        $products = Product::latest()->paginate(5);

        return view('products.index', compact('products'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    public function create()
    {
        return view('products.create');
    }

    public function store(Request $request)
    {
        $this->productRepository->store($request);

        return redirect()->route('products.index')
            ->with('success', 'Product created successfully.');
    }

    public function show(Product $product)
    {
        return view('products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        return view('products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $this->productRepository->update($request, $product);

        return redirect()->route('products.index')
            ->with('success', 'Product updated successfully');
    }

    public function destroy(Product $product)
    {
        $this->productRepository->delete($product);

        return redirect()->route('products.index')
            ->with('success', 'Product deleted successfully');
    }

    public function allProductsPDF()
    {
        $displayProduct = array();
        $products = Product::all();
        foreach($products as $product)
        {
           $quantity = Imei::where('product_id', $product->id)->count();
           $displayProduct[$product->name]=$quantity;
        }

        $pdf = PDF::loadView('products.allPDF',  compact('displayProduct'));
        return $pdf->stream();
    }
}
