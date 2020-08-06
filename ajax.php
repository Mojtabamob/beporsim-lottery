<?php
require('./inc/Lottery.php');
$lottery=new Lottery();

$winners=$lottery->draw();

#Output
header('Content-Type: application/json');
echo json_encode(array(
    'status'=>0,
    'winners'=>$winners
));