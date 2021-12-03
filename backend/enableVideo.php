<?php

include('../dbconn.php');

if (isset($_POST['action']) && $_POST['action'] == 'makeLive') {

    $live=$_POST['isLive'];
    $video_id = $_POST['id'];
    
    try{
        $docRef = $firestore->collection('Videos')->document($video_id);
        $docRef->set([

            'Is Live' => $live], ['merge' => true]);
    } catch (Exception $exception){
        print($exception->getMessage());
    }
}
