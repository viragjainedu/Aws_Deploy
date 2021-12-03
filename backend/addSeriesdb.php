<?php
include('../dbconn.php');
use Google\Cloud\Core\Timestamp;

if(isset($_POST['submit'])){
    $seriesName=$_POST['seriesname'];
    $series_id = str_replace(' ', '', $seriesName);
    $Date=$_POST['date'];
    $description=$_POST['Des'];
    $timestamp = new Timestamp(new DateTime());
    $bucket_name="sdi-ott.appspot.com";
    $bucket = $storage->bucket($bucket_name);
    $thumb_name= 'Series/'.$seriesName.'/'.$_FILES["thumb"]["name"];
    $object = $bucket->upload(
        file_get_contents($_FILES['thumb']['tmp_name']),
        [
            'name' => $thumb_name
        ]
    );
    $object->update(['acl' => []], ['predefinedAcl' => 'PUBLICREAD']);
    $videolink = 'https://storage.googleapis.com/'.$bucket_name.'/'.$object->name(); 
    try{
        $docRef = $firestore->collection('Series')->document($series_id);
        $docRef->set([
            'Series Name' => $seriesName,
            'Categories' => $_POST['categories'],
            'Orator Name' => $_POST['orators'],
            'Date' => $Date,
            'Description' => $description,
            'Video Thumbnail' => $videolink,
            'DateCreated' => $timestamp
        ]);
        header("Location: ../addSeries.php");
    } catch (Exception $exception){
        print($exception->getMessage());
    }
}
?>