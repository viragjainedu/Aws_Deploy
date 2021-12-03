<?php
include('../dbconn.php');
use Google\Cloud\Core\Timestamp;

if(isset($_POST['submit'])){
    $series_id=$_POST['serdet'];
    $season_id=$_POST['epidet'];
    $videoname=$_POST['videoname'];
    $videolink=$_POST['videolink'];
    $Date=$_POST['date'];
    $description=$_POST['Des'];
    $location=$_POST['loc'];
    $episodeNo = $_POST['episodeno'];
    $thumb=$_FILES['thumb']['tmp_name'];
    $timestamp = new Timestamp(new DateTime());
    $bucket_name="sdi-ott.appspot.com";
    $bucket = $storage->bucket($bucket_name);
    
    $link_array = explode("=",$videolink);
    $video_id = $link_array[1];
    $thumb_name= 'Series/'.$series_id.'/'.$season_id.'/'.$video_id.'/'.$_FILES["thumb"]["name"];
    $object = $bucket->upload(
        file_get_contents($_FILES['thumb']['tmp_name']),
        [
            'name' => $thumb_name
        ]
    );
    $object->update(['acl' => []], ['predefinedAcl' => 'PUBLICREAD']);
    $videolink1 = 'https://storage.googleapis.com/'.$bucket_name.'/'.$object->name();
    
    try{
        $docRef = $firestore->collection('Series')->document($series_id)->collection('Seasons')->document($season_id)->collection('Episodes')->document($video_id);
        $docRef->set([
            'Video Name' => $videoname,
            'Video Link' => $videolink,
            'Orator Name' => $_POST['orators'],
            'Categories' => $_POST['categories'],
            'Date' => $Date,
            'Description' => $description,
            'Location' => $location,
            'Is Live' => $live,
            'Tags' => $_POST['tags'],
            'Video ID' => $video_id,
            'Episode No' => $episodeNo,
            'Video Thumbnail' => $videolink1,
            'DateCreated' => $timestamp
        ]);
        printf('Added data to the lovelace document in the users collection.' . PHP_EOL);
        header("Location: ../ListSeries.php");
    } catch (Exception $exception){
        print($exception->getMessage());
    }
}
?>