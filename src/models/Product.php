<?php
require_once '../../../src/models/Model.php';

class Product
{

    var $name;
    var $cpf;
    var $address;
    var $address_number;
    public $table = 'products';

    public function __construct()
    {
    }

    public function store($data)
    {
        // sku is required
        if (!$data->sku) {
            return $message = [
                'type' => 'danger',
                'text' => 'Código é obrigatório.'
            ];
        }

        // sku exist
        if (!$this->uniqueSku($data->sku)) {
            return $message = [
                'type' => 'danger',
                'text' => 'Código já cadastrado'
            ];
        }

        // description is required
        if (!$data->description) {
            return $message = [
                'type' => 'danger',
                'text' => 'Descrição é obrigatório.'
            ];
        }

        // active is boolean or null
        if (isset($data->active)) {
            if ($data->active != 1 and $data->active != 0 and $data->active != null) {
                return $message = [
                    'type' => 'danger',
                    'text' => 'Campo Ativo é inválido'
                ];
            }
        }

        storeModel($this->table, $data);

        return $message = [
            'type' => 'success',
            'text' => 'Produto cadastrado com sucesso'
        ];
    }

    public function save($data)
    {
        saveModel($this->table, $data);
    }

    public static function findAll()
    {
        return findAllModel('products');
    }

    public static function find($productId)
    {
        return findModel('products', $productId);
    }

    public function uniqueSku($sku)
    {
        $validator = findColumnModel($this->table, 'sku', $sku);

        if ($validator) {
            return false;
        }

        return true;
    }
}
