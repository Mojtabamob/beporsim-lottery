<?php
require('./inc/Lottery.php');
$lottery=new Lottery();

$winners=$lottery->draw();

#Output
header('Content-Type: application/json');
echo json_encode(array(
    'status'=>($winners!=false && count($winners)>0)?0:-1,
    'winners'=>$winners
));