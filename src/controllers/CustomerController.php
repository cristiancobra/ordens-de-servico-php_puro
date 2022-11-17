<?php
require_once '../../../src/models/Customer.php';

class CustomerController {

    public function index() {
        $customers = Customer::findAll();

        return $customers;
    }

    public function create($customer) {
        // $customer = new Customer($data);
        $message = $customer->store($customer);

        $url = 'Location: ./../../pages/customer/index.php?messageType=' . $message['type'] . '&messageText=' . $message['text'] ;
        
        return header($url);
    }

    public function edit($customerId) {
        $customer = Customer::find($customerId);

        return $customer;
    }

    public function update($data) {
        $id = $_GET['id'];

        $customer = new Customer;
        $message = $customer->save($data);

        $url = 'Location: ./../../pages/customer/edit.php?id=' . $id . '&messageType=' . $message['type'] . '&messageText=' . $message['text'] ;

        return header($url);
    }
}