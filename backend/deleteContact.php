<?php
include('../dbconn.php');
if(isset($_POST['submit'])){
    $editCatId=$_POST['ContactId'];
    
    try{
        $firestore->collection('Contact_Us')->document($editCatId)->delete();
        header("Location: ../ContactUs.php");
    } catch (Exception $exception){
        print($exception->getMessage());
    }
}
