<?php 
include './impl/NodeDAOImpl.php'; 
include_once './model/dto/Type.php';

ini_set('display_errors', 1); 
ini_set('display_startup_errors', 1); 

$dao = new NodeDAOImpl('./db/netpay.db');
$nodeName = $_GET['node'];

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>Search results</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body>
<?php 

$result_set = $dao->getNodeByName($nodeName);

$results = array();

while($res = $result_set -> fetchArray(1)) {
    //push the row the array
    array_push($results, $res); 
}

for($i = 0; $i < count($results); $i++) {   
    //count until the last element of the array and then break like
    //break at the last array of each array 

   if($results[$i]['parent_id'] == null) {
        //if its a file dont put slash
       print('</br>C:\\' . $results[$i]['name'] . "\\");

    } else {
        if($results[$i]['type'] == Type::FILE) { 
            print_r($results[$i]['name']);
        } else {
            print_r($results[$i]['name'] . "\\");
        }
    }
}

?>      
</br>
<a href='./'>Search again</a>

</body> 
</html>
