<?php
include('../dbconn.php');
if(isset($_POST['submit'])){
    $editSeriesId=$_POST['editSeriesId'];
    
    try{
        $ref=$firestore->collection('Series')->document($editSeriesId);
        $Seasons=$ref->collection('Seasons');
        $ref2=$Seasons->documents();
        foreach($ref2 as $doc){
            $id=$doc->id();
            $ref3=$Seasons->document($id)->collection('Episodes')->documents();
            foreach($ref3 as $doc1){
                $doc1->reference()->delete();
            }
            $doc->reference()->delete();
        }
        $filename=str_replace("https://storage.googleapis.com/sdi-ott.appspot.com/","",$ref->snapshot()['Video Thumbnail']);
        $imagedeleted = $storage->bucket("sdi-ott.appspot.com")->object($filename)->delete();
        $ref->delete();
        header("Location: ../ListSeries.php");
    } catch (Exception $exception){
        print($exception->getMessage());
    }
}
?>