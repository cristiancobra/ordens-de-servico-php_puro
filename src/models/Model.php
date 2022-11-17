<?php

require_once '../../../Database.php';


function storeModel($table, $data)
{
    $database = new Database;
    $conn = $database->connect();

    $arrayKeys = [];
    $arrayValues = [];

    foreach ($data as $key => $value) {
        if ($key != 'table') {
            $arrayKeys[] = $key;
            $arrayValues[] = $value;
        }
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

    $id = $data->id;
    unset($data->id);

    $columns = [];
    foreach ($data as $key => $val) {
        $columns[] = "$key = '$val'";
    }
    $sql = "UPDATE $table SET " . implode(', ', $columns) . " WHERE id = $id";

    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql))
        exit('SQL error');

    mysqli_stmt_execute($stmt);
    mysqli_close($conn);
    return true;
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

    $sql = "SELECT * FROM $table  WHERE $column = $value";
    
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql))
        exit('SQL error');

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
