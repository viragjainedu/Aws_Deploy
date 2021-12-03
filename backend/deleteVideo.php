<?php
include('../dbconn.php');
if (isset($_POST['submit'])) {
    $editVideoId = $_POST['editVideoId'];

    try {
        $ref = $firestore->collection('Videos')->document($editVideoId);
        if ($ref->snapshot()['Video Thumbnail'] != "https://storage.googleapis.com/sdi-ott.appspot.com/Orators/defaultVideo/defaultVideoThumbnail.jpeg") {
            $filename = str_replace("https://storage.googleapis.com/sdi-ott.appspot.com/", "", $ref->snapshot()['Video Thumbnail']);
            $imagedeleted = $storage->bucket("sdi-ott.appspot.com")->object($filename)->delete();
        }
        $ref->delete();
        header("Location: ../ListVideos.php");
    } catch (Exception $exception) {
        print($exception->getMessage());
    }
}
