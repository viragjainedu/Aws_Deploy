<?php

include('../dbconn.php');

if (isset($_POST['action']) && $_POST['action'] == 'makeLive') {

    $live=$_POST['isLive'];
    $orator_id = $_POST['id'];
    
    try{
        
        $docRef = $firestore->collection('Orators')->document($orator_id);
        $docRef->set([
            'Is Live' => $live], ['merge' => true]);
    } catch (Exception $exception){
        print($exception->getMessage());
    }
}
