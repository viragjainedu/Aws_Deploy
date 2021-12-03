<?php
    include('../dbconn.php');
    $enor = array();
    $orator_id =$_POST['OratorId'];
    $ty = array('Bayan','Naat Sharif','Series','Short Clip');
    foreach($ty as $t){
        if(isset($_POST[str_replace(' ', '', $t)])){
            array_push($enor,$t);
        }
    } 
    print_r($enor);
    $docRef = $firestore->collection('ShowOrators')->document($orator_id);
    $docRef->set([
        'orator name' => $_POST['orratorname'],
        'type' => $enor,
    ]);
    header("Location: ../ListOrators.php");
