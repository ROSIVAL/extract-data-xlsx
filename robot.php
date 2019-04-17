<?php

ini_set('memory_limit', '2048M');

include './class/SimpleXLSX.class.php';

$xlsx = new SimpleXLSX('./_files/DATA.xlsx');


try {

    $conn = new PDO("mysql:host=localhost;dbname=data", "root", "");

    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {

    print $sql . "\n" . $e->getMessage();
}

$stmt = $conn->prepare("INSERT INTO data.data (
    GENDER,	
    AGE,
    PAYMENT_METHOD,
    CHURN,
    LAST_TRANSACTION
    ) 
    VALUES 
    (
        ?, 
        ?, 
        ?, 
        ?, 
        ?
    )
        ");

$stmt->bindParam(1, $GENDER);
$stmt->bindParam(2, $AGE);
$stmt->bindParam(3, $PAYMENT_METHOD);
$stmt->bindParam(4, $CHURN);
$stmt->bindParam(5, $LAST_TRANSACTION);

$data = array();

foreach ($xlsx->rows() as $fields) {

    array_push($data, $fields);
}

array_shift($data);

foreach ($data as $value) {

    $GENDER           = $value[0];
    $AGE              = $value[1];
    $PAYMENT_METHOD   = $value[2];
    $CHURN            = $value[3];
    $LAST_TRANSACTION = $value[4];

    if($stmt->execute()){
        print "Inserted => ".$GENDER." => ".$AGE. " => ".$PAYMENT_METHOD;
        print "\n";
    }else{
        print "Error!!";
        print "\n";
    }
}

print "\n :) Done!...\n";

?>