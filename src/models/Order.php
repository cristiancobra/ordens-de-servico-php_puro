<?php
require_once '../../../src/models/Model.php';
require_once '../../../src/models/Customer.php';

class Order
{
    
    public $table = 'orders';

    public function __construct($data)
    {
        $this->product_id = $data['product_id'];
        $this->start_date = $data['start_date'];

        if (isset($data['id'])) {
            $this->id = $data['id'];
        }

        if (isset($data['customer_id'])) {
            $this->customer_id = $data['customer_id'];
        }

        if (isset($data['finished'])) {
            $this->finished = $data['finished'];
        }

    }

    public function store($order, $customer)
    {
        // product_id is required
        if (!$order->product_id) {
            return $message = [
                'type' => 'danger',
                'text' => 'Produto é obrigatório.'
            ];
        }

        // start_date is required
        if (!$order->start_date) {
            return $message = [
                'type' => 'danger',
                'text' => 'Data de abertura é obrigatório.'
            ];
        }

        // cpf is required
        if (!$customer->cpf) {
            return $message = [
                'type' => 'danger',
                'text' => 'CPF é obrigatório.'
            ];
        }

        // get cpf if it already exists, otherwise create a new client
        $order->customer_id = $this->checkIfCustomerExist($customer);

        storeModel($this->table, $order);

        return $message = [
            'type' => 'success',
            'text' => 'Ordem cadastrada com sucesso'
        ];
    }

    public function save($data)
    {
        saveModel($this->table, $data);

        return $message = [
            'type' => 'success',
            'text' => 'Ordem atualizada com sucesso'
        ];
    }

    public static function find($orderId)
    {
        return findModel('orders', $orderId);
    }

    public static function findAll()
    {
        return findAllModel('orders');
    }

    public static function findWithCustomer($orderId)
    {
        $sql = "SELECT 
            orders.product_id,
            orders.start_date,
            customers.cpf,
            customers.name,
            customers.address,
            customers.address_number,
            products.description,
            products.id
            FROM
            orders, 
            customers, 
            products
            WHERE 
            orders.id = $orderId 
            AND 
            orders.customer_id = customers.id
            AND
            orders.product_id = products.id";

        $result = findWithQuery($sql);
        reset($result);

        return $result;
    }

    public static function findAllWithCustomer()
    {
        $sql = "SELECT 
            orders.id, 
            orders.product_id, 
            orders.start_date, 
            customers.cpf, 
            customers.name,
            products.description
            FROM 
            orders,
            customers, 
            products
            WHERE 
            orders.customer_id = customers.id
            AND 
            orders.product_id = products.id";

        return findWithQuery($sql);
    }

    public function checkIfCustomerExist($customer)
    {
        $customerFound = findColumnModel('customers', 'cpf', $customer->cpf);

        if ($customerFound) {
            return $customerFound[0]['id'];
        }
// print_r($customer);
        $data['name'] = $customer->name;
        $data['cpf'] = $customer->cpf;
        $customer->storeFromOrder($customer);

        return Customer::returnIdByCpf($customer->cpf);;
    }

    public static function filterOrders($data)
    {
        $array = (array) $data;

        if (!$array) { 

            $sql = "SELECT 
            orders.id, 
            orders.product_id, 
            orders.start_date,
            orders.finished,
            customers.cpf, 
            customers.name,
            products.description
            FROM 
            orders,
            customers, 
            products
            WHERE 
            orders.customer_id = customers.id
            AND 
            orders.product_id = products.id";

        } else {

            $sql = 'SELECT 
            orders.id, 
            orders.product_id, 
            orders.start_date, 
            orders.finished,
            customers.cpf, 
            customers.name,
            products.description
            FROM 
            orders,
            customers, 
            products
            WHERE ';

            if ($data->id) {
                $sql .= "orders.id = $data->id AND ";
            }

            if ($data->name) {
                $sql .= "customers.name LIKE '$data->name' AND ";
            }

            if ($data->date_min) {
                $sql .= "orders.start_date >= '$data->date_min' AND ";
            }

            if ($data->date_max) {
                $sql .= "orders.start_date <= '$data->date_max' AND ";
            }

            $sql .= "
        orders.customer_id = customers.id
        AND 
        orders.product_id = products.id";
        }

        return findWithQuery($sql);
    }
}
