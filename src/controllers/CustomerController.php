<?php
require_once '../../../src/models/Customer.php';

class CustomerController {

    public function index() {
        $customers = Customer::findAll();

        return $customers;
    }

    public function create($data) {
        $customer = new Customer;
        $message = $customer->store($data);

        $url = 'Location: ./../../pages/customer/index.php?messageType=' . $message['type'] . '&messageText=' . $message['text'] ;
        
        return header($url);
    }

    public function edit($customerId) {
        $customer = Customer::find($customerId);

        return $customer;
    }

    public function update($data) {
        $customer = new Customer;
        $customer->save($data);
    }
}