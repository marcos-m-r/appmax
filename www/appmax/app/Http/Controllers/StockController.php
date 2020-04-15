<?php

namespace App\Http\Controllers;

use App\Http\Requests\Stock\AddStockRequest;
use App\Http\Requests\Stock\IndexRequest;
use App\Http\Requests\Stock\RemoveStockRequest;
use App\Services\ProductsStockService;

class StockController extends Controller
{
    const SUCCESS_STATUS = 200;

    protected $productsStockService;

    public function __construct(ProductsStockService $productsStockService) {
        $this->productsStockService = $productsStockService;
    }

    public function index(IndexRequest $request) {
        $filter = [
            'origin' => $request->get('origin', ''),
            'created_at' => $request->get('created_at', null),
        ];

        $stocks = $this->productsStockService->getReport($filter);


        return view('stocks.index', compact('stocks', 'filter')); 
    }

    protected function changeStock($type, $data) {
        
        $method = $type == 'Add' ? 'addProductStock' : 'removeProductStock';

        foreach ($data['products'] as $product) {

            $message = '';

            try {
                $message = $this->productsStockService->{$method}((int) $product['id'], (int) $product['quantity'], $data['origin']);
            } catch (\Exception $e) {
                $message = $e->getMessage();
            }

            $return[$product['id']] = $message;
        }
        
        return response()->json(['result' => $return], self::SUCCESS_STATUS); 

    }

    public function removeStock(RemoveStockRequest $request) {
        $data = $request->validated();

        $data['origin'] = $request->get('origin', 'api');
        
        $return = $this->changeStock('Remove', $data);
        
        return response()->json(['result' => $return], self::SUCCESS_STATUS); 
    }
    
    public function addStock(AddStockRequest $request) {
        $data = $request->validated();

        $data['origin'] = $request->get('origin', 'api');
        
        $return = $this->changeStock('Add', $data);
        
        return response()->json(['result' => $return], self::SUCCESS_STATUS); 
    }
}
