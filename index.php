<?php
require('./inc/Lottery.php');
$lottery=new Lottery();

$prizes=$lottery->count_available_prizes($lottery->current_contest);
$participants=$lottery->count_available_participants($lottery->current_contest);

?>
<!DOCTYPE html>
<html>
<head>
    <title>قرعه کشی بپرسیم</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <link rel="stylesheet" type="text/css" href="./public/css/app.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
</head>
<body>
<header>
    <h1 class="right">
        <img class="logo" src="public/images/logo.png">
        <img class="logo-txt" src="public/images/logo-txt.png">
    </h1>
    <h3 class="left">
        <!-- <h3> -->
        قرعه کشی دوره <?=$lottery->current_contest?>
        <span>با <?=$participants?> شرکت کننده</span>
        <!-- </h3> -->
    </h3>
</header>
<div class="main inner_wrapper">
    <div class="main-box">
        <div class="counter-box">
            <span><i></i></span>
            <span><i></i></span>
            <span><i></i></span>
            <span><i></i></span>
            <div class="num-counter">1000</div>
            <!-- <div class="num-counter"></div> -->
        </div>
        <div class="button">
            <span>بزن بریم!</span>
        </div>
        <div class="content">
            <h5 id="wmobile">0912 *** 0000</h5>
            <h6 id="wname">نامشخص</h6>
            <h4 id="wprize">نامشخص</h4>
        </div>
    </div>
</div>
<script type="text/javascript" src="./public/js/jquery.min.js"></script>
<script type="text/javascript" src="./public/js/jquery.waypoints.min.js"></script>
<script type="text/javascript" src="./public/js/jquery.counterup.min.js"></script>
<script type="text/javascript" src="./public/js/app.js"></script>
</body>
</html>
