<?php 
interface NodeDAO 
{
    public function insert($node);
    public function remove($node);
    public function update($node); 
    public function getNodeByName($node);
}
?>

