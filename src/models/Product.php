<?php
require_once '../../../src/models/Model.php';

class Product
{

    public $table = 'products';

    public function __construct($data)
    {
        $this->sku = $data['sku'];
        $this->description = $data['description'];

        if (isset($data['id'])) {
            $this->id = $data['id'];
        }

        if (isset($data['active'])) {
            $this->active = (int) $data['active'];
        }
    }

    public function store($product)
    {
        // sku is required
        if (!$product->sku) {
            return $message = [
                'type' => 'danger',
                'text' => 'Código é obrigatório.'
            ];
        }

        // sku exist
        if (!$this->uniqueSku($product->sku)) {
            return $message = [
                'type' => 'danger',
                'text' => 'Código já cadastrado'
            ];
        }

        // description is required
        if (!$product->description) {
            return $message = [
                'type' => 'danger',
                'text' => 'Descrição é obrigatório.'
            ];
        }

        // active is boolean or null
        if ($product->active != 1 and $product->active != 0) {
            return $message = [
                'type' => 'danger',
                'text' => 'Campo Ativo é inválido'
            ];
        }

        storeModel($this->table, $product);

        return $message = [
            'type' => 'success',
            'text' => 'Produto cadastrado com sucesso'
        ];
    }

    public function save($product)
    {
        saveModel($this->table, $product);

        return $message = [
            'type' => 'success',
            'text' => 'Produto atualizado com sucesso'
        ];
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

    public static function findActives()
    {
        $products = findColumnModel('products', 'active', 1);

        return $products;
    }
}
