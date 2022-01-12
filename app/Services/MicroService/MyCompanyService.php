<?php

namespace App\Services\MicroService;

class MyCompanyService
{

    /**TODO в этом классе реализовать методы подключения к апи стороннего микросервиса, и использовать при получении цены для товара
     *
     * @throws \Exception
     */
    public function getPriceProduct($id): float {
        return number_format(2 + mt_rand() / mt_getrandmax() * (20 - 2), 2);
    }
}
