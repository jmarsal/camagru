<?php
/**
 * Created by PhpStorm.
 * User: jmarsal
 * Date: 3/7/17
 * Time: 4:52 PM
 */

header("Content-Type: text/plain");

if (isset($_POST['filter']) && $_POST['filter'] === 'Blur'){
    var_dump($_POST);
} else {
    echo 'KO';
}