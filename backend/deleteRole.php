<?php
include('../dbconn.php');
if(isset($_POST['submit'])){
    $editStaffId=$_POST['editStaffId'];
    
    try{
        $ref=$firestore->collection('Admin_Roles')->document($editStaffId);
        $ref->delete();
        header("Location: ../ListRoles.php");
    } catch (Exception $exception){
        print($exception->getMessage());
    }
}
