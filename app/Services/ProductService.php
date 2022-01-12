<?php

namespace App\Services;

use App\Services\MicroService\MyCompanyService;
use Illuminate\Support\Facades\Cache;

class ProductService
{

    protected $myCompanyService;

    /**
     * @param MyCompanyService $myCompanyService
     */
    public function __construct(MyCompanyService $myCompanyService) {
        $this->myCompanyService = $myCompanyService;
    }

    /**
     *
     * @param $id
     * @return float
     * @throws \Exception
     */
    public function getPrice($id): float {
        $price = 0;
        $tmpCacheProducts = [16 => ['price' => 155], 1 => ['price' => 89], 3 => ['price' => 132]];
        Cache::forget('products');
        Cache::add('products', $tmpCacheProducts, 5);

        $cacheProducts = Cache::get('products');

        // проверяем наличие цены товара в кэше, если нет, дергаем из сервиса и сохраняем в кэше
        if (array_key_exists($id, $cacheProducts) && isset($cacheProducts[$id]['price'])) {
            $price = $cacheProducts[$id]['price'];
        } else {
            $price = $this->myCompanyService->getPriceProduct($id);

            $cacheProducts[$id]['price'] = $price;
            Cache::forget('products');
            Cache::add('products', $cacheProducts, 60);
        }

        return $price;
    }
}
