<?php
if (isset($_POST['submit'])) {
    $isFile = 1;

    foreach ($_FILES['thumb'] as $something) {

        if ($something == '') {
            $isFile = 0;
            break;
        }
    }

    $videoname = $_POST['videoname'];
    $videolink = $_POST['videolink'];
    $Date = $_POST['date'];
    $description = $_POST['Des'];
    $location = $_POST['loc'];
    $live1 = $_POST['customRadio'];
    if ($live1 == "Yes") {
        $live = True;
    } else {
        $live = False;
    }

    $catarray = array();
    if (isset($_POST['categories'])) {
        $catarray = $_POST['categories'];
    } else {
        array_push($catarray, "Others");
    }
    $tagarray = array();
    if (isset($_POST['tags'])) {
        $tagarray = $_POST['tags'];
    } else {
        array_push($tagarray, "None");
    }

    $vidtype = $_POST['vitype'];

    $link_array = explode("=", $videolink);
    $video_id = $link_array[1];


    if ($isFile == 1) {

        $bucket_name = "sdi-ott.appspot.com";
        $bucket = $storage->bucket($bucket_name);
        $thumb_name = $vidtype . "/" . $video_id . '/' . $_FILES["thumb"]["name"];
        $object = $bucket->upload(
            file_get_contents($_FILES['thumb']['tmp_name']),
            [
                'name' => $thumb_name
            ]
        );
        $object->update(['acl' => []], ['predefinedAcl' => 'PUBLICREAD']);
        $videolink1 = 'https://storage.googleapis.com/' . $bucket_name . '/' . $object->name();
    }

    if ($isFile == 1) {


        try {
            $docRef = $firestore->collection('Videos')->document($video_id);
            $docRef->set([
                'Video Name' => $videoname,
                'Video Link' => $videolink,
                'Orator Name' => $_POST['orators'],
                'Categories' => $catarray,
                'Date' => $Date,
                'Description' => $description,
                'Location' => $location,
                'Tags' => $tagarray,
                'Is Live' => $live,
                'Type' => $vidtype,
                'Video ID' => $video_id,
                'Video Thumbnail' => $videolink1
            ], ['merge' => true]);
            $_SESSION['videoUpdated'] = 'Updated';
            header("Location: ListVideos.php");
        } catch (Exception $exception) {
            print($exception->getMessage());
        }
    } else {

        try {
            $docRef = $firestore->collection('Videos')->document($video_id);
            $docRef->set([
                'Video Name' => $videoname,
                'Video Link' => $videolink,
                'Orator Name' => $_POST['orators'],
                'Categories' => $catarray,
                'Date' => $Date,
                'Description' => $description,
                'Location' => $location,
                'Tags' => $tagarray,
                'Is Live' => $live,
                'Type' => $vidtype,
                'Video ID' => $video_id,
            ], ['merge' => true]);
            $_SESSION['videoUpdated'] = 'Updated';
            header("Location: ListVideos.php");
        } catch (Exception $exception) {
        }
    }
}
