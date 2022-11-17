<?php
require_once '../../../src/models/Model.php';

class Customer
{

    public $table = 'customers';

    public function __construct($data)
    {
        $this->name = $data['name'];
        $this->cpf = $data['cpf'];
        $this->address = $data['address'];
        $this->address_number = $data['address_number'];
    }

    public function store($customer)
    {
        // name is required
        if (!$customer->name) {
            return $message = [
                'type' => 'danger',
                'text' => 'Nome é obrigatório.'
            ];
        }

        // cpf is required
        if (!$customer->cpf) {
            return $message = [
                'type' => 'danger',
                'text' => 'CPF é obrigatório.'
            ];
        }

        // cpf is invalid
        $customer->cpf = preg_replace("/[^0-9]/", "", $customer->cpf);
        $digits = preg_match_all("/[0-9]/", $customer->cpf);

        if ($digits != 11) {
            return $message = [
                'type' => 'danger',
                'text' => 'Número de CPF inválido.'
            ];
        }

        // cpf exist
        if (!$this->uniqueCpf($customer->cpf)) {
            return $message = [
                'type' => 'danger',
                'text' => 'CPF já cadastrado'
            ];
        }

        storeModel($this->table, $customer);

        return $message = [
            'type' => 'success',
            'text' => 'Cliente cadastrado com sucesso'
        ];
    }

    public function save($customer)
    {
        saveModel($this->table, $customer);

        return $message = [
            'type' => 'success',
            'text' => 'Cliente atualizado com sucesso'
        ];
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
