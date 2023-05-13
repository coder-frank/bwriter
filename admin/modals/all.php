<?php

class All {
    private $db;
    public function __construct($db){
        $this->db = $db;
    }
    
    public function login($email, $loginPwd){
    $sql = "SELECT id, email, name FROM admin WHERE email = ? AND password = ?";
    $stmt = $this->db->prepare($sql);
    $stmt->execute(array($email, $loginPwd));
    if ($stmt->rowCount() > 0) {
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        session_start();
        $_SESSION['id'] = $data[0]['id'];
        $_SESSION['email'] = $data[0]['email'];
        $_SESSION['name'] = $data[0]['name'];
        $stmt = null;
        return true;
    } else {
        $stmt = null;
        return false;
    }
}


    public function verifyAdmin($email, $pass){
        $sql = "SELECT * FROM admin WHERE email = ? AND password = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(array($email, $pass));
        if ($stmt->rowCount() > 0) {
            $stmt = null;
            return true;
        } else {
            $stmt = null;
            return false;
        }
    }

    public function removeUser($id){
        $query = "DELETE FROM users WHERE id = ?";
        $stmt = $this->db->prepare($query);
        if($stmt->execute(array($id))){
            $stmt = null;
            return true;
        } else {
            return false;
        }
    }
    public function secure($pass){
        $pass = md5($pass);
        $pass = md5($pass);
        $pass = md5($pass);
        $pass = md5($pass);
        $pass = md5($pass);
        $pass = md5($pass);
        return $pass;
    }
    
    public function totalUsers(){
        $query = "SELECT * FROM users";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->rowCount();
        $stmt = null;
    }
    
    
    public function totalArticles(){
        $query = "SELECT * FROM posts";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->rowCount();
        $stmt = null;
    }
    
    
    public function totalViews(){
        $query = "SELECT * FROM views";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->rowCount();
        $stmt = null;
    }
    
    
    public function totalSubscribers(){
        $query = "SELECT * FROM newsletter";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->rowCount();
        $stmt = null;
    }
    
    
    public function getUsers(){
        $query = "SELECT * FROM users";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt;
        $stmt = null;
    }
    
}