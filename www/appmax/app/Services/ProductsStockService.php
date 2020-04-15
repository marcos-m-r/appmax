<?php 

namespace App\Services;

use App\Model\Product;
use App\Model\StocksLog;
use App\Repositories\ProductRepository;
use App\Repositories\StocksLogRepository;

class ProductsStockService {

    const INVALID_PRODUCT = 'Produto inválido!';
    const INVALID_QUANTITY = 'Quantidade indiposnível';

    const SUCCESS_REMOVE = "Produto baixado com sucesso";
    const SUCCESS_ADD = "Produto adicionado com sucesso";
    
    protected $productsRepository;
    protected $stocksLogRepository;

    public function __construct(ProductRepository $productRepository, StocksLogRepository $stocksLogRepository)
    {
        $this->productsRepository = $productRepository;
        $this->stocksLogRepository = $stocksLogRepository;
    }

    protected function changeStock(Product $product, $type, $newStock, $origin) {
        $originalStock = $product->in_stock;

        $product->in_stock = $newStock;
        $product->save();

        $stocksLog = new StocksLog();

        $stocksLog->product_id = $product->id;
        $stocksLog->before = $originalStock;
        $stocksLog->after = $newStock;
        $stocksLog->type = $type;
        $stocksLog->origin = ($origin == StocksLog::ORIGIN_SITE) ? StocksLog::ORIGIN_SITE : StocksLog::ORIGIN_API;
        $stocksLog->save();
    }

    public function removeProductStock(int $id, int $stockToRemove, $origin = 'api') {

        $product = $this->productsRepository->findFirst($id);
        
        if (empty($product)) {
            throw new \Exception(self::INVALID_PRODUCT);
        }
        
        if ($stockToRemove > $product->in_stock) {
            throw new \Exception(self::INVALID_QUANTITY);
        }

        $newStock = (int)$product->in_stock - $stockToRemove;

        $this->changeStock($product, StocksLog::TYPE_REMOVE, $newStock, $origin);

        return self::SUCCESS_REMOVE;
    }

    public function addProductStock(int $id, int $stockToAdd, $origin = 'api') {

        $product = $this->productsRepository->findFirst($id);
        
        if (empty($product)) {
            throw new \Exception(self::INVALID_PRODUCT);
        }

        $newStock = (int)$product->in_stock + $stockToAdd;
        $this->changeStock($product, StocksLog::TYPE_ADD, $newStock, $origin);

        return self::SUCCESS_ADD;
    }

    public function getReport($filter = []) {

        $conditions = [];
        
        if (array_key_exists('created_at', $filter) && !empty($filter['created_at'])) {
            $conditions['created_at'] = \DateTime::createFromFormat("Y-m-d", $filter['created_at']);
        }

        if (array_key_exists('origin', $filter) && !empty($filter['origin'])) {
            $conditions['origin'] = $filter['origin'];
        }

        $stocksLogs = $this->stocksLogRepository->findAll($conditions);
        
        return $stocksLogs;
    }

}