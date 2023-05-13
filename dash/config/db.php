<?php

class Database{
  private $host = "localhost";
  private $user = "root";
  private $password = "";
  private $dbname = "myblog";

  public function connect(){
    try {
        $db = new PDO("mysql:host=$this->host;dbname=$this->dbname", $this->user, $this->password);
        // set the PDO error mode to exception
      $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      return $db;
    } catch (PDOException $e) {
        echo "Error ".$e->getMessage();
    }
}

}