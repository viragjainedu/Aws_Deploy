<?php
include('dbconn.php');

$usersRef = $firestore->collection('Categories');
$snapshot = $usersRef->documents();
$vid_type=$_POST['vid_type'];

foreach ($snapshot as $cat) {
    if($cat['Type'] == $vid_type){
    $new[] =  $cat->data();
    }
}
echo json_encode($new);
?>