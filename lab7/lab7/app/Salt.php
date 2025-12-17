<?php
require_once('BaseEntity.php');
require_once('DBConnect.php');
class Salt extends BaseEntity{
    private $name;
    private $formula;
    private $marking;
    private $type_id;   
    private $typename;
    private $purpose_id; 
    private $purposename;
    public function __construct($id,$name,$formula,$marking,$type_id,$typename,$purpose_id,$purposename){
        $this->id=$id;
        $this->name=$name;
        $this->formula=$formula;
        $this->marking=$marking;
        $this->type_id=$type_id;
        $this->typename=$typename;
        $this->purpose_id=$purpose_id;
        $this->purposename=$purposename;
    }
    public function display(){
        echo $this->id.". ".$this->name." ".$this->formula."</br>";
        echo "Маркування: ".$this->marking."</br>";
        echo "Тип: <i>".$this->type_id."</i></br>";
        echo "Сфера призначення: <i>".$this->purpose_id."</i></br>";
    }
    public function update($name,$formula,$marking,$type_id,$purpose_id){
        $this->name=$name;
        $this->formula=$formula;
        $this->marking=$marking;
        $this->type_id=$type_id;
        $this->purpose_id=$purpose_id;
    }
    public function __destruct(){
        $this->id=null;
        $this->name=null;
        $this->formula=null;
        $this->marking=null;
        $this->type_id=null;
        $this->purpose_id=null;
    }
    public function getAsJSON(){
        return '{
            "id": "'.$this->id.'",
            "name": "'.$this->name.'",
            "formula": "'.$this->formula.'",
            "marking": "'.$this->marking.'",
            "type_id": "'.$this->type_id.'",
            "typename": "'.$this->typename.'",
            "purpose_id": "'.$this->purpose_id.'",
            "purposename": "'.$this->purposename.'",
            "properties":'.json_encode($this->getSaltProperties()).'
        }';
    }
    public function getAsXML(){
        return '<salt>
                    <id>'.$this->id.'</id>
                    <name>'.$this->name.'</name>
                    <formula>'.$this->formula.'</formula>
                    <marking>'.$this->marking.'</marking>
                    <type>'.$this->type_id.'</type>
                    <purpose>'.$this->purpose_id.'</purpose>
                </salt>';
    }
    public function getAsAssociativeArray(){
        return [
                'id'=>$this->id,
                'name'=>$this->name,
                'formula'=>$this->formula,
                'marking'=>$this->marking,
                'type_id'=>$this->type_id,
                'purpose_id'=>$this->purpose_id,
                ];
    }
    public function getSaltProperties(){
        global $conn;
        $stmt = $conn->prepare("SELECT salt_properties.*, properties.name, properties.units FROM salt_properties
        INNER JOIN properties ON properties.id=salt_properties.property_id WHERE salt_id=?");
        $stmt->bind_param("s", $this->id);
        $stmt->execute();
        $result = $stmt->get_result();
        $array=[];
        if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
            array_push($array,$row);
        }
        } 
        return $array;
    }
    public function getAsTableRow(){
        $propArray=$this->getSaltProperties();
        $propertiesContent='';
        for($i=0; $i<count($propArray); $i++){
            if (!empty($propArray[$i]['value'])) {
                $propertiesContent .= $propArray[$i]['name'].': '.$propArray[$i]['value'].' '.$propArray[$i]['units'].'</br>';
            }
        }
        
        return '<tr>
                    <td>'.$this->id.'</td>
                    <td>'.$this->name.'</td>
                    <td>'.$this->formula.'</td>
                    <td>'.$this->typename.'</td>
                    <td>'.$this->purposename.'</td>
                    <td>'.$this->marking.'</td>
                    <td>'.$propertiesContent.'</td>
                    <td>
                        <a class="btn btn-warning" href="./salts.php?action=update&id='.$this->id.'">Редагувати</a>
                        <a class="btn btn-danger" href="./salts.php?action=delete&id='.$this->id.'">Видалити</a>
                    </td>
                </tr>';
    }
    public function getAsIndexedArray(){
        return [$this->name,$this->formula,$this->marking,$this->type_id,$this->purpose_id];
    }
}