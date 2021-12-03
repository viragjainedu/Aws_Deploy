<?php

include('../dbconn.php');

if (isset($_POST['action']) && $_POST['action'] == 'makeLive') {

    $live=$_POST['isLive'];
    $episode_id = $_POST['id'];
    $series_id=$_POST['seriesid'];
    $season_id=$_POST['seasonid'];
    
    try{
        $docRef = $firestore->collection('Series')->document($series_id)->collection('Seasons')->document($season_id)->collection('Episodes')->document($episode_id);
        $docRef->set(
            ['Is Live' => $live], ['merge' => true]
        );
    } catch (Exception $exception){
        print($exception->getMessage());
    }
}
?>