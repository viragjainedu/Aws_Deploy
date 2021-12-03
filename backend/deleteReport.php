<?php
include('../dbconn.php');
if(isset($_POST['submit'])){
    $editCatId=$_POST['ReportId'];
    
    try{
        $firestore->collection('Report')->document($editCatId)->delete();
        header("Location: ../Report.php");
    } catch (Exception $exception){
        print($exception->getMessage());
    }
}
