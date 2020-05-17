<?php

include './model/dao/NodeDAO.php';
include './model/dto/Type.php';

class NodeDAOImpl extends SQLite3 implements NodeDAO { 

    function __construct($dbPath) {
        $this->open($dbPath); 
    }

    public function insert($node, $parentNode = null){
        //if the parent is null insert straight
        if($parentNode != null) {
            //insert the node with the id of the parent node
            //find out the id of the parent node
            $sql = 'INSERT INTO node(parent_id, name, type)
                VALUES("' . $this->getIdFromNode($parentNode) 
                . '","' . $node
                . '","' .  $this->isFile($node) . '");'; 

            $this->exec($sql);
            
        } else {
            $sql = 'INSERT INTO node(name, type)
                VALUES("' . $node . '","' .  $this->isFile($node) . '");'; 

            $this->exec($sql);
        }
    }

    public function remove($node){
    }

    public function update($node){
    } 

    public function getNodeByName($name) /* SQLite3Result */{
        $sql = " 
            WITH RECURSIVE tmp as (
            SELECT
            f.parent_id,
            f.name,
            f.type,
            row_number() over() as row_numb
            FROM node f
            WHERE f.name LIKE '" . $name . "%'

            UNION ALL

            SELECT  
            s.parent_id,
            s.name,
            s.type,
            p.row_numb
            FROM node s
            JOIN tmp p ON p.parent_id = s.id
            )
            SELECT * FROM tmp ORDER BY row_numb, coalesce(parent_id, 0)
            ";

        return $this->query($sql);
    }

    private function isFile($filename) /* Type enum */{
        if(strpos($filename, '.') !== false) {
            return Type::FILE;
        } else {
            return Type::DIRECTORY;
        }
    }

    private function getIdFromNode($nodeName) /* int id */ {
        $sql = 'SELECT id FROM node WHERE name = "' . $nodeName . '";'; 
        $results = $this->query($sql);
        $parentId = 1;
        while($row = $results->fetchArray()){
            $parentId = $row[0]; 
        }

        return $parentId;
    }
}

?>

