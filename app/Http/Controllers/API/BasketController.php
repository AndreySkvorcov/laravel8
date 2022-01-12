<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\ProductService;
use Illuminate\Http\Request;

class BasketController extends Controller
{
    protected $productService;

    public function __construct(ProductService $productService) {
        $this->productService = $productService;
    }


    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     * @throws \Exception
     */
    public function index(Request $request) {
        $data = $request->post();
        $data['total_price_cart'] = 0;

        if (is_array($data['products'])) {
            foreach ($data['products'] as $key => $product) {
                $data['products'][$key]['price'] = $this->productService->getPrice($product['id']);
                $data['products'][$key]['total_price_product'] = $data['products'][$key]['quantity'] * $data['products'][$key]['price'];
                $data['total_price_cart'] += $data['products'][$key]['total_price_product'];
            }
        } else {
            return response($data);
        }

        return response($data);
    }
}
