<?php
require('./inc/Lottery.php');
$lottery=new Lottery();
$contest=9;
$winners=$lottery->draw($contest);

#Output
header('Content-Type: application/json');
echo json_encode(array(
    'status'=>0,
    'winners'=>$winners
));