<?php
require_once '../../../src/models/Order.php';

$id = (int) $_GET['id'];

$data = Order::find($id);

$order = new Order($data);

if( !isset($order->finished) OR $order->finished == null OR $order->finished == 0 ) {
    $order->finished = 1;

} elseif ( $order->finished == 1 ) {
    $order->finished = 0;
}

$order->save($order);
$order->id = $id;

header("Content-Type: application/json");

echo json_encode($order);

exit();

?>