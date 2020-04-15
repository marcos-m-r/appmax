<?php

namespace App\Http\Controllers;

use App\Model\Product;
use App\Model\StocksLog;
use Illuminate\Http\Request;
use App\Http\Requests\Product\StoreRequest;
use App\Http\Requests\Product\UpdateRequest;
use App\Http\Requests\Product\UpdateStockRequest;
use App\Services\ProductsStockService;
use App\Repositories\ProductRepository;

class ProductController extends Controller
{

    protected $productsStockService;
    protected $productRepository;

    public function __construct(ProductsStockService $productsStockService, ProductRepository $productRepository) {
        $this->productsStockService = $productsStockService;
        $this->productRepository = $productRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = $this->productRepository->findAll();
        
        return view('products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('products.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\Product\StoreRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request)
    {
        $product = new Product([
            'name' => $request->get('name'),
            'sku' => $request->get('sku'),
            'in_stock' => $request->get('in_stock'),
        ]);

        $product->save();

        return redirect('/products')->with('success', 'Produto criado com sucesso!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        return view('products.edit', compact('product')); 
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, Product $product)
    {
        $product->name = $request->get('name');
        // $product->sku = $request->get('sku');
        $product->in_stock = $request->get('in_stock');
        $product->save();

        return redirect('/products')->with('success', 'Produto editado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->status = 0;

        $product->save();

        return redirect('/products')->with('success', 'Produto removido com sucesso!');
    }

    public function addStock(Product $product)
    {
        return view('products.change_stock', ['type' => StocksLog::TYPE_ADD, 'product' => $product]); 
    }

    public function removeStock(Product $product)
    {
        return view('products.change_stock', ['type' => StocksLog::TYPE_REMOVE, 'product' => $product]); 
    }

    public function updateStock(UpdateStockRequest $request, Product $product)
    {
        $quantity = $request->get('quantity');

        $type = $request->get('type') . 'ProductStock';
        
        try {
            $this->productsStockService->{$type}((int) $product['id'], (int) $quantity, StocksLog::ORIGIN_SITE);
        } catch (\Exception $e) {
            return redirect('/products')->with('error', 'Não foi possível alterar o estoque. '. $e->getMessage() .'!');
        }

        return redirect('/products')->with('success', 'Estoque alterado com sucesso!');
    }
}
