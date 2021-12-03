<?php
include('../dbconn.php');
if(isset($_POST['submit3'])){
    $seasonId=$_POST['epidet'];
    $seriesId=$_POST['serdet'];
    try{
        $ref=$firestore->collection('Series')->document($seriesId)->collection('Seasons');
        $seasons=$ref->document($seasonId);
        $ref2=$ref->document($seasonId)->collection('Episodes')->documents();
        foreach($ref2 as $doc){
            $doc->reference()->delete();
        }
        $seasons->delete();
        header("Location: ../ListSeries.php");
    } catch (Exception $exception){
        print($exception->getMessage());
    }
}
?>