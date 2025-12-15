<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
abstract class BaseEntity{
    protected $id;
    public abstract function display();
	public abstract function update($params);
	public function getId(){
		return $this->id;
	}
}
abstract class BaseList{
	protected $lastId;
	protected $list;
	public function __construct(){
		$this->lastId=1;
		$this->list=array();
	}
	public abstract function add($params);
	public function display(){
		for($i=0;$i<count($this->list);$i++){
			$this->list[$i]->display();
		}
	}
	public function update($params){
		for($i=0;$i<count($this->list);$i++){
			if($this->list[$i]->getId()==$params['id']){
				$this->list[$i]->update($params);
				break;
			}
		}
	}
	public function delete($id){
		for($i=0;$i<count($this->list);$i++){
			if($this->list[$i]->getId()==$id){
				array_splice($this->list,$i,1);
				break;
			}
		}
	}
}
class Type extends BaseEntity{
    private $name;
    public function __construct($params){
        $this->id=$params['id'];
        $this->name=$params['name'];
    }
    public function display(){
        echo $this->id.". ".$this->name."</br>";
    }
    public function update($params){
        $this->id=$params['id'];
        $this->name=$params['name'];
    }
    public function __destruct(){
        $this->id=null;
        $this->name=null;
    }
}
class Purpose extends BaseEntity{
    private $name;
    public function __construct($params){
        $this->id=$params['id'];
        $this->name=$params['name'];
    }
    public function display(){
        echo $this->id.". ".$this->name." <i></br>";
    }
    public function update($params){
        $this->id=$params['id'];
        $this->name=$params['name'];
    }
    public function __destruct(){
        $this->id=null;
        $this->name=null;
    }
}
class Property extends BaseEntity{
    private $name;
    private $units;
    public function __construct($params){
        $this->id=$params['id'];
        $this->name=$params['name'];
		$this->units=$params['units'];
    }
    public function display(){
        echo $this->id.". ".$this->name." <i>(".$this->units.")</i></br>";
    }
    public function update($params){
        $this->id=$params['id'];
        $this->name=$params['name'];
		$this->units=$params['units'];
    }
    public function __destruct(){
        $this->id=null;
        $this->name=null;
        $this->units=null;
    }
}
class Salt extends BaseEntity{
    private $name;
    private $formula;
    private $type;   
    private $purpose; 
    private $marking;
    private $properties;
    public function __construct($params){
        $this->id=$params['id'];
        $this->name=$params['name'];
		$this->formula=$params['formula'];
        $this->type=$params['type'];
		$this->purpose=$params['purpose'];
        $this->marking = $params['marking'];
        $this->properties=$params['properties'];
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
    public function update($params){
        $this->id=$params['id'];
        $this->name=$params['name'];
		$this->formula=$params['formula'];
        $this->type=$params['type'];
		$this->purpose=$params['purpose'];
        $this->marking = $params['marking'];
        $this->properties=$params['properties'];
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
}
class TypeList extends BaseList{
	public function add($params){
		$params['id']=$this->lastId;
		$newObj=new Type($params);
		array_push($this->list,$newObj);
		$this->lastId++;
	}
}
class PurposeList extends BaseList{
	public function add($params){
		$params['id']=$this->lastId;
		$newObj=new Purpose($params);
		array_push($this->list,$newObj);
		$this->lastId++;
	}
}
class PropertyList extends BaseList{
	public function add($params){
		$params['id']=$this->lastId;
		$newObj=new Property($params);
		array_push($this->list,$newObj);
		$this->lastId++;
	}
}
class SaltList extends BaseList{
	public function add($params){
		$params['id']=$this->lastId;
		$newObj=new Salt($params);
		array_push($this->list,$newObj);
		$this->lastId++;
	}
}

/*$a=new Property(1, "Маса", "кг");
$a->display();
$a = new Salt(1, "Сіль кухонна", "NaCl", "Харчова", "Технічна", "CAS 7647-14-5", '{"Розчинність":"Добра",
"Колір":"Біла","Бренд":"SaltBrand","Країна":"Україна","Форма":"Кристали","Ціна":"25 грн","Маса":"0.5 кг"}');
$a->display();*/

/*$a = new Type(1, "Кислі солі");
$b = new Type(2, "Мішані солі");
$a->display();
$b->display();
$a->update(1, "Середні солі");
$a->display();*/

/*$a = new TypeList();
$a->add(['name' => 'Кислі солі']);
$a->add(['name' => 'Мішані солі']);
$a->display();
$a->update([
	'id' => '1',
	'name' => 'Основні солі'
]);
$a->delete(1);
$a->display();*/

/*$a = new Purpose(1, "Харчові солі");
$b = new Purpose(2, "Медичні солі");
$a->display();
$b->display();
$a->update(1, "Технічні солі");
$a->display();*/

/*$a = new PurposeList();
$a->add(['name' => 'Харчові солі']);
$a->add(['name' => 'Медичні солі']);
$a->display();
$a->update([
	'id' => '1',
	'name' => 'Технічні солі'
]);
$a->delete(1);
$a->display();*/

/*$b=new PropertyList();
$b->add(
	['name'=>'Вага', 'units'=>'кг']
);
$b->display();
$b->update(
	['id'=>'1', 'name'=>'Маса', 'units'=>'г']
);
$b->display();
$b->delete(1);
$b->display();*/

$c = new SaltList();

$c->add([
    'name' => 'Сіль кухонна',
    'formula' => 'NaCl',
    'type' => 'Середня',
    'purpose' => 'Харчова',
    'marking' => 'ДСТУ 3583-97',

    'properties' => '{
        "Розчинність":"Висока",
        "Колір":"Біла",
        "Бренд":"Артемсіль",
        "Країна":"Україна",
        "Форма":"Кристали",
        "Ціна":"25 грн",
        "Маса":"1 кг"
    }'
]);

$c->add([
    'name' => 'Сіль калійна',
    'formula' => 'KNO3',
    'type' => 'Мішана',
    'purpose' => 'Технічна',
    'marking' => 'CAS 7757-79-1',

    'properties' => '{
        "Розчинність":"Добра",
        "Колір":"Безбарвна",
        "Бренд":"Mineral",
        "Країна":"Польща",
        "Форма":"Порошок",
        "Ціна":"80 грн",
        "Маса":"0.5 кг"
    }'
]);

$c->display();

$c->update([
    'id' => 2,
    'name' => 'Сіль калійна',
    'formula' => 'KNO3',
    'type' => 'Середня',
    'purpose' => 'Харчова',
    'marking' => 'ДСТУ 1234-2020',

    'properties' => '{
        "Розчинність":"Висока",
        "Колір":"Біла",
        "Бренд":"Mineral+",
        "Країна":"Польща",
        "Форма":"Кристали",
        "Ціна":"95 грн",
        "Маса":"0.5 кг"
    }'
]);


$c->display();
$c->delete(1);
$c->display();
?>
