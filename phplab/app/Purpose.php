<?php
require_once('BaseEntity.php');
class Purpose extends BaseEntity{
    private $name;
    public function __construct($id, $name){
        $this->id=$id;
        $this->name=$name;
    }
    public function display(){
        echo $this->id.". ".$this->name."</br>";
    }
    public function update($name){
        $this->name=$name;
    }
    public function getAsJSON(){
        return '{
            "id": "'.$this->id.'",
            "name": "'.$this->name.'",
        }';
    }
    public function getAsXML(){
        return '<purpose>
                    <id>'.$this->id.'</id>
                    <name>'.$this->name.'</name>
                </purpose>';
    }
    public function __destruct(){
        $this->id=null;
        $this->name=null;
    }
    public function getAsIndexedArray(){
        return [$this->name];
    }
}