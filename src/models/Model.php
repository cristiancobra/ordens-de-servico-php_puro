<?php

require_once '../../../Database.php';


function storeModel($table, $data)
{
    $database = new Database;
    $conn = $database->connect();

    $arrayKeys = [];
    $arrayValues = [];

    foreach($data as $key => $value) {
        $arrayKeys[] = $key;
        $arrayValues[] = $value;
    }

    $columns = implode(", ", $arrayKeys);
    $escaped_values = array_map(array($conn, 'real_escape_string'), $arrayValues);
    $values  = implode("', '", $escaped_values);
    $sql = "INSERT INTO $table ($columns) VALUES ('$values')";

    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql))
        exit('SQL error');

    mysqli_stmt_execute($stmt);
    mysqli_close($conn);
    return true;
}


function saveModel($table, $data)
{
    $database = new Database;
    $conn = $database->connect();

    $id = mysqli_real_escape_string($conn, $data->id);
    $name = mysqli_real_escape_string($conn, $data->name);
    $address = mysqli_real_escape_string($conn,  $data->address);
    $address_number = mysqli_real_escape_string($conn,  $data->address_number);

    if ($id && $name && $address && $address_number) {
        $sql = "UPDATE $table SET name = ?, address = ?, address_number = ? WHERE id = ?";
        $stmt = mysqli_stmt_init($conn);

        if (!mysqli_stmt_prepare($stmt, $sql))
            exit('SQL error');

        mysqli_stmt_bind_param($stmt, 'sssi', $name, $address, $address_number, $id);
        mysqli_stmt_execute($stmt);
        mysqli_close($conn);
        return true;
    }
}

function findAllModel($table)
{
    $database = new Database;
    $conn = $database->connect();

    $sql = "SELECT * FROM $table";
    $result = mysqli_query($conn, $sql);

    $result_check = mysqli_num_rows($result);

    if ($result_check > 0) {
        $models = mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    mysqli_close($conn);

    return $models;
}

function findWithQuery($sql)
{
    $database = new Database;
    $conn = $database->connect();
    
    $result = mysqli_query($conn, $sql);

    $result_check = mysqli_num_rows($result);

    if ($result_check > 0) {
        $models = mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    mysqli_close($conn);

    if (!empty($models)) {
        return $models;
    }

    return false;
}

function findModel($table, $id)
{
    $database = new Database;
    $conn = $database->connect();

    $id = mysqli_real_escape_string($conn, $id);
    // $user;

    $sql = "SELECT * FROM $table  WHERE id = ?";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql))
        exit('SQL error');

    mysqli_stmt_bind_param($stmt, 'i', $id);
    mysqli_stmt_execute($stmt);

    $model = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));

    mysqli_close($conn);

    return $model;
}


function findColumnModel($table, $column, $value)
{
    $database = new Database;
    $conn = $database->connect();

    $column = mysqli_real_escape_string($conn, $column);
    $value = mysqli_real_escape_string($conn, $value);
    // $user;

    $sql = "SELECT * FROM $table  WHERE $column = $value";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql))
        exit('SQL error');

    $result = mysqli_query($conn, $sql);

    $result_check = mysqli_num_rows($result);

    // $models = [];
    if ($result_check > 0) {
        $models = mysqli_fetch_all($result, MYSQLI_ASSOC);
    }
    
    mysqli_close($conn);

    if (!empty($models)) {
        return $models;
    }

    return false;
}
