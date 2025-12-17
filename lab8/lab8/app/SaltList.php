<?php
require_once('BaseList.php');
require_once('Salt.php');
require_once('DBConnect.php');
class SaltList extends BaseList{
    public function add($params){
        $elem=new Salt($params['id'],$params['name'],$params['formula'],$params['marking'],$params['type_id'],$params['typename'],$params['purpose_id'],$params['purposename']);
        array_push($this->list, $elem);
    }
    public function update($params){
        for ($i=0;$i<count($this->list);$i++){
            if($this->list[$i]->getId()==$params['id']){
                $this->list[$i]->update($params['name'],$params['formula'],$params['marking'],$params['type_id'],$params['purpose_id']);
                break;
            }
        }
    }
    public function getAsJSON(){
        $content='{
    "salts": [';
        for ($i=0;$i<count($this->list);$i++){
            $content.=$this->list[$i]->getAsJSON().",";
        }
        $content = substr($content, 0, -1);
        $content.='    ]
        }';
        return $content;
    }
    public function getAsXML(){
        $content='<salts>
        ';
        for ($i=0;$i<count($this->list);$i++){
            $content.=$this->list[$i]->getAsXML();
        }
        $content.='</salts>';
        return $content;
    }
    public function readFromCSV($filePath){
        $fp = fopen($filePath, 'r');
        if ($fp === false) {
            die('Error: Cannot open the CSV file.');
        }
        while (($row = fgetcsv($fp,10000,",","`","\\")) !== false) {
            $this->add(['name'=>$row[0],'formula'=>$row[1],'marking'=>$row[2],'type_id'=>$row[3],'purpose_id'=>$row[4]]);
        }
        fclose($fp);
    }
    public function getAllFromDatabase(){
        global $conn;
        $sql = "SELECT salts.*, types.name AS typename, purpose.name AS purposename
        FROM salts
        INNER JOIN types ON types.id=salts.type_id
        INNER JOIN purpose ON purpose.id = salts.purpose_id ORDER BY salts.id ASC";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
            $this->add($row);
        }
        }
    }
    public function getAllFromDatabaseById($id){
        global $conn;
        $stmt = $conn->prepare("SELECT salts.*, types.name AS typename, purpose.name AS purposename
        FROM salts
        INNER JOIN types ON types.id = salts.type_id
        INNER JOIN purpose ON purpose.id = salts.purpose_id WHERE salts.id = ?");
        $stmt->bind_param("s", $id);
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
    public function addSaltProperty($salt_id,$property_id,$value){
        global $conn;
        $stmt = $conn->prepare("INSERT INTO salt_properties VALUES (DEFAULT, ?,?,?)");
        $stmt->bind_param("sss", $salt_id,$property_id, $value);
        $stmt->execute();
        return $conn->insert_id;
    }
    public function updateSaltProperty($salt_id,$property_id,$value){
        global $conn;
        $stmt = $conn->prepare("SELECT * from `salt_properties` WHERE `salt_id`=? and `property_id`=?;");
        $stmt->bind_param("ss", $salt_id,$property_id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $stmt = $conn->prepare("UPDATE `salt_properties` SET `value`=? WHERE `salt_id`=? and `property_id`=?;");
            $stmt->bind_param("sss", $value,$salt_id,$property_id);
            $stmt->execute();
        } else{
            $stmt = $conn->prepare("INSERT INTO salt_properties VALUES (DEFAULT, ?,?,?)");
            $stmt->bind_param("sss", $salt_id,$property_id, $value);
            $stmt->execute();
        }
    }
    public function insertIntoDatabase($params){
        global $conn;
        $stmt = $conn->prepare("INSERT INTO salts  VALUES (DEFAULT, ?,?,?,?,?)");
        $stmt->bind_param("sssss", $params['name'],$params['formula'],$params['marking'],$params['type_id'],$params['purpose_id']);
        $stmt->execute();
        return $conn->insert_id;
    }
    public function updateDatabaseById($params){
        global $conn;
        $stmt = $conn->prepare("UPDATE `salts` SET `name`=?, `formula`=?,`marking`=?, `type_id`=?, `purpose_id`=? WHERE `id`=?");
        $stmt->bind_param("ssssss", $params['name'],$params['formula'],$params['marking'],$params['type_id'],$params['purpose_id'],$params['id']);
        $stmt->execute();
    }
    public function deleteFromDatabaseById($id){
        global $conn;
        $stmt = $conn->prepare("DELETE FROM salts WHERE id=?");
        $stmt->bind_param("s", $id);
        $stmt->execute();
    }
    public function getSaltPropertiesById($id){
        for ($i=0;$i<count($this->list);$i++){
            if($this->list[$i]->getId()==$id){
                return $this->list[$i]->getSaltProperties();
            }
        }
    }

        public function getAllFromDatabaseBySearchCriteria($search){
        global $conn;
        $stmt = $conn->prepare("SELECT salts.*, types.name AS typename, purpose.name AS purposename
        FROM salts
        INNER JOIN types ON types.id = salts.type_id
        INNER JOIN purpose ON purpose.id = salts.purpose_id
        WHERE salts.name LIKE ? OR salts.formula LIKE ? OR types.name LIKE ? OR purpose.name LIKE ?");
        $stmt->bind_param("ssss", $search,$search,$search,$search);
        $search="%".$search."%";
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
            $this->add($row);
        }
        }
    }
}

