<?php
include('../dbconn.php');
use Google\Cloud\Core\Timestamp;

if(isset($_POST['submit'])){
    $video_id = $_POST['viId'];
    $videos=$firestore->collection('Videos')->document($video_id)->snapshot();
    $videoType=$videos['Type'];
    $isLive=$videos['Is Live'];
    $priority =$_POST['priority'];
    $timestamp = new Timestamp(new DateTime());
    try{
        $docRef = $firestore->collection('Sliders')->document($video_id);
        $docRef->set([
            'Video ID' => $video_id,
            'Video Type' => $videoType,
            'Priority' => $priority,
            'Is Live' => $isLive,
            'DateCreated' => $timestamp,
            'Video Name' => $videos['Video Name'],
            'Video Thumbnail' => $videos['Video Thumbnail'],
        ]);
        header("Location: ../ListSlider.php");
    } catch (Exception $exception){
        print($exception->getMessage());
    }
}
?>