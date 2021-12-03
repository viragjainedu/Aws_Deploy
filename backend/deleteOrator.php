<?php
include('../dbconn.php');
if (isset($_POST['submit'])) {
    $editOratorId = $_POST['editOratorId'];

    try {
        $ref = $firestore->collection('Orators')->document($editOratorId);
        if ($ref->snapshot()['photo'] != "https://storage.googleapis.com/sdi-ott.appspot.com/Orators/defaultorator/defaultOrator.jpeg") {
            $filename = str_replace("https://storage.googleapis.com/sdi-ott.appspot.com/", "", $ref->snapshot()['photo']);
            $imagedeleted = $storage->bucket("sdi-ott.appspot.com")->object($filename)->delete();
        }
        $ref->delete();
        header("Location: ../ListOrators.php");
    } catch (Exception $exception) {
        print($exception->getMessage());
    }
}
