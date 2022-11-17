<?php
require_once '../../../src/models/Product.php';

class ProductController {

    public function index() {
        $products = Product::findAll();

        return $products;
    }

    public function create($product) {
        $message = $product->store($product);

        $url = 'Location: ./../../pages/product/index.php?messageType=' . $message['type'] . '&messageText=' . $message['text'] ;
        
        return header($url);
    }

    public function edit($productId) {
        $product = Product::find($productId);

        return $product;
    }

    public function update($product) {
        $product->save($product);
    }
}