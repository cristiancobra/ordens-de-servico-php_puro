<?php
require_once '../../../src/models/Model.php';
require_once '../../../src/models/Customer.php';

class Order
{

    var $name;
    var $cpf;
    var $address;
    var $address_number;
    public $table = 'orders';

    public function __construct()
    {
    }

    public function store($dataOrder, $dataCustomer)
    {
        // product_id is required
        if (!$dataOrder->product_id) {
            return $message = [
                'type' => 'danger',
                'text' => 'Produto é obrigatório.'
            ];
        }

        // start_date is required
        if (!$dataOrder->start_date) {
            return $message = [
                'type' => 'danger',
                'text' => 'Data de abertura é obrigatório.'
            ];
        }

        // cpf is required
        if (!$dataCustomer->cpf) {
            return $message = [
                'type' => 'danger',
                'text' => 'CPF é obrigatório.'
            ];
        }

        // get cpf if it already exists, otherwise create a new client
        $dataOrder->customer_id = $this->checkIfCustomerExist($dataCustomer);

        storeModel($this->table, $dataOrder);

        return $message = [
            'type' => 'success',
            'text' => 'Ordem cadastrada com sucesso'
        ];
    }

    public function save($data)
    {
        saveModel($this->table, $data);
    }

    public static function find($orderId)
    {
        return findModel('orders', $orderId);
    }

    public static function findAll()
    {
        return findAllModel('orders');
    }

    public static function findAllWithCustomer()
    {
        $sql = "SELECT orders.id, orders.product_id, orders.start_date, customers.cpf, customers.name, products.description
            FROM orders, customers, products
            WHERE orders.customer_id = customers.id AND orders.product_id = products.id";

        return findWithQuery($sql);
    }

    public function checkIfCustomerExist($dataCustomer)
    {
        $customer = findColumnModel('customers', 'cpf', $dataCustomer->cpf);
        
        if ($customer) {
            return $customer[0]['id'];
        }

        $customer = new Customer;
        $customer->store($dataCustomer);
        
        return Customer::returnIdByCpf($dataCustomer->cpf);;
    }
}
