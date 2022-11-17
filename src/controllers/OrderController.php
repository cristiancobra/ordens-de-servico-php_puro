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
        $id = $_GET['id'];

        $order = new Order;
        $message = $order->save($data);

        $url = 'Location: ./../../pages/order/edit.php?id=' . $id . '&messageType=' . $message['type'] . '&messageText=' . $message['text'] ;

        return header($url);
    }
}