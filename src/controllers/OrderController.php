<?php
require_once '../../../src/models/Order.php';

class OrderController {

    public function index() {
        $orders = Order::findAll();

        return $orders;
    }

    public function create($order, $customer) {
        $message = $order->store($order, $customer);

        $url = 'Location: ./../../pages/order/index.php?messageType=' . $message['type'] . '&messageText=' . $message['text'] ;
        
        return header($url);
    }

    public function edit($orderId) {
        $order = Order::find($orderId);

        return $order;
    }

    public function update($order) {
        $id = $_GET['id'];

        $message = $order->save($order);

        $url = 'Location: ./../../pages/order/edit.php?id=' . $id . '&messageType=' . $message['type'] . '&messageText=' . $message['text'] ;

        return header($url);
    }
}