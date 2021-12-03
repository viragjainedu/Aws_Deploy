<?php
include('../dbconn.php');
if(isset($_POST['submit'])){
    $editCatId=$_POST['editCatId'];
    
    try{
        $firestore->collection('Categories')->document($editCatId)->delete();
        header("Location: ../ListCategories.php");
    } catch (Exception $exception){
        print($exception->getMessage());
    }
}
