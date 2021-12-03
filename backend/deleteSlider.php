<?php
include('../dbconn.php');
if(isset($_POST['submit'])){
    $editSliderId=$_POST['editSliderId'];
    try{
        $ref=$firestore->collection('Sliders')->document($editSliderId);
        $ref->delete();
        header("Location: ../ListSlider.php");
    } catch (Exception $exception){
        print($exception->getMessage());
    }
}
?>