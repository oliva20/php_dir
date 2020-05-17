<?php

require_once './impl/NodeDAOImpl.php';

class Initdb {

    public $dao;

    function __construct() {

        $this->dao = new NodeDAOImpl('./db/netpay.db');

        if(!$this->dao) {
            echo $this->dao->lastErrorMsg(); 
        } else {
            echo 'Database opened' . "\n";
        }
       
       $this->insertData();
    } 

    public function insertData(){
        //TODO check if file exists first.
        $existingNodes = array(); //keeps track of $nodes that have already been inserted

        if ($file = fopen("./db/data.txt", "r")) {
         while(!feof($file)) {
                $line = fgets($file);
                $nodes = explode('\\', $line);

                for($x = 0; $x < count($nodes); $x++) {

                    if($x != 0) { //if we are not dealing with the first node

                        if(in_array($nodes[$x], $existingNodes)) {
                            continue; 
                        } else {
                            $parentNode = $nodes[$x - 1];
                            $this->dao->insert($nodes[$x], $parentNode);
                            array_push($existingNodes, $nodes[$x]);
                        }

                    } else {

                        if(in_array($nodes[$x], $existingNodes)) {
                            continue; 
                        } else {
                            $this->dao->insert($nodes[$x]);
                            array_push($existingNodes, $nodes[$x]);
                        }
                    }
                } 

         }

        }
        fclose($file);
    }
}

?>
