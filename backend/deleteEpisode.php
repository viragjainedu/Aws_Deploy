<?php
include('../dbconn.php');
if(isset($_POST['submit'])){
    $seriesId=$_POST['serdet'];
    $seasonid=$_POST['epidet'];
    $episodeId=$_POST['editEpisodeId'];
    try{
        $ref=$firestore->collection('Series')->document($seriesId)->collection('Seasons')->document($seasonid)->collection("Episodes")->document($episodeId);
        $filename=str_replace("https://storage.googleapis.com/sdi-ott.appspot.com/","",$ref->snapshot()['Video Thumbnail']);
        $imagedeleted = $storage->bucket("sdi-ott.appspot.com")->object($filename)->delete();
        $ref->delete();
        header("Location: ../ListSeries.php");
    } catch (Exception $exception){
        print($exception->getMessage());
    }
}
?>