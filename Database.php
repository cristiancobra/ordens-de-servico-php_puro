<?php

class Database {
  // $host = 'http://localhost/conteudos/crud-php-mysql-procedural/';

  // db
  protected $name;
  protected $host;
  protected $user;
  protected $password;

  public function __construct() {
    $this->name = 'ordens_servico';
    $this->host = 'mysql';
    $this->user = 'ordens_servico';
    $this->password = '12345678';
  }

public function connect() {
  $database = new Database;

    try {
        return $conn = mysqli_connect($database->host, $database->user, $database->password, $database->name);
    } catch (\Throwable $th) {
      throw $th;
    }
  }

}