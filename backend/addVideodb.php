<?php

use Google\Cloud\Core\Timestamp;
 
$added = 0;
$isFile = 1;

if (isset($_POST['submit'])) {
    $added = 1;
    $videoname = $_POST['videoname'];
    $videolink = $_POST['videolink'];
    $Date = $_POST['date'];
    $description = $_POST['Des'];
    $timestamp = new Timestamp(new DateTime());
    $location = $_POST['loc'];
    $live1 = $_POST['customRadio'];
    $vidtype = $_POST['vitype']; 
    $link_array = explode("=", $videolink);
    $video_id = $link_array[1];

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

    foreach ($_FILES['thumb'] as $something) {

        if ($something == '') {
            $isFile = 0;
            break;
        }
    }

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
    } else {
        $videolink1 = "https://storage.googleapis.com/sdi-ott.appspot.com/Orators/defaultVideo/defaultVideoThumbnail.jpeg";
    }
    try {
        $docRef = $firestore->collection('Videos')->document($video_id);
        $docRef->set([
            'Video Name' => $videoname,
            'Video Link' => $videolink,
            'DateCreated' => $timestamp,
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
        ]);
        $url = 'https://fcm.googleapis.com/fcm/send';
        $apiKey = "AAAAcRTLp4I:APA91bGa8fb4MlLtx5hkzEofQRLKypChYH4Em0pK4MJPoafjN28Q3PNSAOWUdHuvw-BPMUj3ujnsYjd0xDCkBBDaTm2-IH6kiN4p0BkgG__PJnkRQ_zeIqBcMvOBrgotf6UdNi4B9jtl";
        $headers = array(
            'Authorization: key=' . $apiKey,
            'Content-Type: application/json'
        );
        $notification = array(
            'title' => 'New Video Added',
            'body' => $videoname.' Added',
            'image' => $videolink1,
            'sound' => 'default',
            'badge' => '1'
        );
        // Create api body
        // Send to all devies

        $apiBody = [
            'notification' => $notification,
            'time_to_live' => 3600,
            //'registration_ids' = ID ARRAY
            'to' => '/topics/all'
        ];
        $ch = curl_init();
        curl_setopt ($ch, CURLOPT_URL, $url);
        curl_setopt ($ch, CURLOPT_POST, true);
        curl_setopt ($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt ($ch, CURLOPT_POSTFIELDS, json_encode($apiBody));
        $result = curl_exec($ch);
        // print($result);
        curl_close($ch);
        
    } catch (Exception $exception) {
        // print($exception->getMessage());
    }
}
