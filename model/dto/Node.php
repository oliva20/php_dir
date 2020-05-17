<?php 

class Node {
    public $name;
    public $id;
    public $parentId; //sub dir parent id
    public $type;

    function __construct($name, $id) {
        $this->name = $name;
        $this->id = $id;
    }

    function setParentId($id) {
        $this->parentId = $id;
    }
}

?>

