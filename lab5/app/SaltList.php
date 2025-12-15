<?php
require_once('BaseList.php');
require_once('Salt.php');
class SaltList extends BaseList{
    public function add($params){
        $this->lastId++;
        $elem=new Salt($this->lastId,$params['name'],$params['formula'],$params['type'],$params['purpose'],$params['marking'],$params['properties']);
        array_push($this->list, $elem);
    }
    public function update($params){
        for ($i=0;$i<count($this->list);$i++){
            if($this->list[$i]->getId()==$params['id']){
                $this->list[$i]->update($params['name'],$params['formula'],$params['type'],$params['purpose'],$params['marking'],$params['properties']);
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
            $this->add(['name'=>$row[0],'formula'=>$row[1],'type'=>$row[2],'purpose'=>$row[3],'marking'=>$row[4],'properties'=>$row[5]]);
        }
        fclose($fp);
    }
    
}