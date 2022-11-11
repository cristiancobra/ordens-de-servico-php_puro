<?php
require_once '../../../src/models/Product.php';

class ProductController {

    public function index() {
        $products = Product::findAll();

        return $products;
    }

    public function create($data) {
        $product = new Product;
        $message = $product->store($data);

        $url = 'Location: ./../../pages/product/index.php?messageType=' . $message['type'] . '&messageText=' . $message['text'] ;
        
        return header($url);
    }

    public function edit($productId) {
        $product = Product::find($productId);

        return $product;
    }

    public function update($data) {
        $product = new Product;
        $product->save($data);
    }
}