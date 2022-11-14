<?php
require_once '../../../src/models/Order.php';

class OrderController {

    public function index() {
        $orders = Order::findAll();

        return $orders;
    }

    public function create($dataOrder, $dataCustomer) {
        $order = new Order;
        $message = $order->store($dataOrder, $dataCustomer);

        $url = 'Location: ./../../pages/order/index.php?messageType=' . $message['type'] . '&messageText=' . $message['text'] ;
        
        return header($url);
    }

    public function edit($orderId) {
        $order = Order::find($orderId);

        return $order;
    }

    public function update($data) {
        $order = new Order;
        $order->save($data);
    }
}