<?php
require_once('BaseEntity.php');
class Salt extends BaseEntity{
    private $name;
    private $formula;
    private $type;   
    private $purpose; 
    private $marking;
    private $properties;
    public function __construct($id, $name, $formula, $type, $purpose, $marking, $properties){
        $this->id=$id;
        $this->name=$name;
		$this->formula=$formula;
        $this->type=$type;
		$this->purpose=$purpose;
        $this->marking = $marking;
        $this->properties=$properties;
    }
    public function display(){
        echo $this->id.". ".$this->name." ".$this->formula."</br>";
        echo "Тип: <i>".$this->type."</i></br>";
        echo "Сфера призначення: <i>".$this->purpose."</i></br>";
        echo "Маркування: <i>".$this->marking."</i></br>";
        echo "<b>Характеристики:</b></br>";
        foreach (json_decode($this->properties) as $propertyName => $propertyValue) {
            echo $propertyName . ": " . $propertyValue . "</br>";
        }
    }
    public function update($name, $formula, $type, $purpose, $marking, $properties){
        $this->name=$name;
		$this->formula=$formula;
        $this->type=$type;
		$this->purpose=$purpose;
        $this->marking = $marking;
        $this->properties=$properties;
    }
    public function __destruct(){
        $this->id=null;
        $this->name=null;
		$this->formula=null;
        $this->type=null;
		$this->purpose=null;
        $this->marking = null;
        $this->properties=null;
    }
    public function getAsJSON(){
        return '{
            "id": "'.$this->id.'",
            "name": "'.$this->name.'",
            "formula": "'.$this->formula.'",
            "type": "'.$this->type.'",
            "purpose": "'.$this->purpose.'",
            "marking": "'.$this->marking.'",
            "properties": '.$this->properties.'
        }';
    }
    public function getAsXML(){
        $properties='';
        foreach (json_decode($this->properties) as $propertyName => $propertyValue) {
            $properties.='<property>
                            <name>'.$propertyName.'</name>
                            <value>'.$propertyValue.'</value>
            </property>';
        }
        return '<salt>
                    <id>'.$this->id.'</id>
                    <name>'.$this->name.'</name>
                    <formula>'.$this->formula.'</formula>
                    <type>'.$this->type.'</type>
                    <purpose>'.$this->purpose.'</purpose>
                    <marking>'.$this->marking.'</marking>
                    <properties>'.$properties.'</properties>
                </salt>';
    }
    public function getAsAssociativeArray(){
        return [
                'id'=>$this->id,
                'name'=>$this->name,
                'formula'=>$this->formula,
                'type'=>$this->type,
                'purpose'=>$this->purpose,
                'marking'=>$this->marking,
                'properties'=>$this->properties
                ];
    }
    public function getAsTableRow(){
        $properties="";
        foreach (json_decode($this->properties) as $propertyName => $propertyValue) {
            $properties.= $propertyName . ": " . $propertyValue . "</br>";
        }
        return '<tr>
                    <td>'.$this->id.'</td>
                    <td>'.$this->name.'</td>
                    <td>'.$this->formula.'</td>
                    <td>'.$this->type.'</td>
                    <td>'.$this->purpose.'</td>
                    <td>'.$this->marking.'</td>
                    <td>'.$properties.'</td>
                    <td>
                        <a class="btn btn-warning" href="./salts.php?action=update&id='.$this->id.'">Редагувати</a>
                        <a class="btn btn-danger" href="./salts.php?action=delete&id='.$this->id.'">Видалити</a>
                    </td>
                </tr>';
    }
    public function getAsIndexedArray(){
        return [$this->name,$this->formula,$this->type,$this->purpose,$this->marking,$this->properties];
    }
}