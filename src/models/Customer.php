<?php
require_once '../../../src/models/Model.php';

class Customer
{

    var $name;
    var $cpf;
    var $address;
    var $address_number;
    public $table = 'customers';

    public function __construct()
    {
    }

    public function store($data)
    {
        // name is required
        if (!$data->name) {
            return $message = [
                'type' => 'danger',
                'text' => 'Nome é obrigatório.'
            ];
        }

        // cpf exist
        if (!$this->uniqueCpf($data->cpf)) {
            return $message = [
                'type' => 'danger',
                'text' => 'CPF já cadastrado'
            ];
        }

        storeModel($this->table, $data);

        return $message = [
            'type' => 'success',
            'text' => 'Cliente cadastrado com sucesso'
        ];
    }

    public function save($data)
    {
        saveModel($this->table, $data);
    }

    public static function findAll()
    {
        return findAllModel('customers');
    }

    public static function find($customerId)
    {
        return findModel('customers', $customerId);
    }

    public static function returnIdByCpf($cpf)
    {
        $customer = findColumnModel('customers', 'cpf', $cpf);
        
        if ($customer) {
            return (int) $customer[0]['id'];
        };
    }

    public function uniqueCpf($cpf)
    {
        $validator = findColumnModel($this->table, 'cpf', $cpf);

        if ($validator) {
            return false;
        }

        return true;
    }
}
