<?php
require_once('DBConnect.php');
class Profile{
    private $id;
    private $login;
    private $password;
    public function checkLogin($params){
        global $conn;
        $stmt = $conn->prepare("SELECT * FROM users WHERE login=? and password=?");
        $stmt->bind_param("ss", $params['login'],$params['password']);
        $params['password']=md5($params['password']);
        $stmt->execute();
        $result = $stmt->get_result();        
        if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
            return $row;
        }
        } else{
            return null;
        }
    }
}
?>