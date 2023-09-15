<?php
    $servername = 'localhost';
    $username = 'lottory';
    $password = 'abc123';
    $dbname = 'lottory';

    $connect = new mysqli($servername, $username, $password, $dbname);
    $connect->set_charset("utf8");
