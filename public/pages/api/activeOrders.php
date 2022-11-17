<?php
require_once '../../../src/models/Order.php';

$id = (int) $_GET['id'];

$data = Order::find($id);

$order = new Order;
var_dump($order);
$order->id = $data['id'];

if( $data['finished'] == null ) {
    $order->finished = 1;

} elseif ( $data['finished'] = 1 ) {
    $order->finished = null;
}

$order->save($data);

header("Content-Type: application/json");

echo json_encode($order);

exit();

?>