<?php
include('../dbconn.php');
if (isset($_POST['submit'])) {
    $editAdId = $_POST['editAdId'];

    try {
        $ref = $firestore->collection('Advertisements')->document($editAdId);
        $filename=str_replace("https://storage.googleapis.com/sdi-ott.appspot.com/","",$ref->snapshot()['Video Thumbnail']);
        $imagedeleted = $storage->bucket("sdi-ott.appspot.com")->object($filename)->delete();
        $ref->delete();
        header("Location: ../ListAdvertisement.php");
    } catch (Exception $exception) {
        print($exception->getMessage());
    }
}
