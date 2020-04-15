<?php

namespace App\Repositories;
 
use App\Model\StocksLog;

class StocksLogRepository {

    protected $stocksLog;

    public function __construct(StocksLog $stocksLog)
    {
        $this->stocksLog = $stocksLog;
    }

    public function findAll($conditions = [])
    {
        $query = $this->stocksLog;

        if (isset($conditions['created_at']) && !empty($conditions['created_at'])) {
            $query = $query->whereDate('created_at', '=', $conditions['created_at']);
        }
        
        if (isset($conditions['origin']) && !empty($conditions['origin'])) {
            $query = $query->where('origin', $conditions['origin']);
        }

        return $query->with('product')->orderBy('created_at', 'desc')->get();
    }
}