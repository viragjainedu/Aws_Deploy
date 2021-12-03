<?php

use Google\Cloud\Core\Timestamp;

$added = 0;
$isFile = 1;
$errors = ['oratorDescription' => '', 'name' => ''];

$oratorName = $oratorDescription = '';
$oratorVideotype = array();

if (isset($_POST['submit'])) {
    $oratorName = $_POST['oratorName'];
    $orator_id = str_replace(' ', '', $oratorName);
    $oratorDescription = $_POST['Des'];
    $oratorVideotype = $_POST['oratorVideotype'];
    $timestamp = new Timestamp(new DateTime());


    foreach ($_FILES['thumb'] as $something) {

        if ($something == '') {
            $isFile = 0;
            break;
        }
    }
    if ($isFile == 1) {

        $thumb = $_FILES['thumb']['tmp_name'];
        $bucket_name = "sdi-ott.appspot.com";
        $bucket = $storage->bucket($bucket_name);
        $thumb_name = 'Orators/' . $oratorName . '/' . $_FILES["thumb"]["name"];
        $object = $bucket->upload(
            file_get_contents($_FILES['thumb']['tmp_name']),
            [
                'name' => $thumb_name
            ]
        );
        $object->update(['acl' => []], ['predefinedAcl' => 'PUBLICREAD']);
        $photolink = 'https://storage.googleapis.com/' . $bucket_name . '/' . $object->name();


        $bucket->upload(
            file_get_contents($_FILES['thumb']['tmp_name']),
            [
                'name' => 'raPADJCLsrc'
            ]
        );
    } else {
        $photolink = "https://storage.googleapis.com/sdi-ott.appspot.com/Orators/defaultorator/defaultOrator.jpeg";
    }

    if (trim($oratorDescription) == '') {
        $errors['oratorDescription'] = 'Description cannot be empty.';
    }

    $catRef = $firestore->collection('Orators');
    $snapshot_cat = $catRef->documents();
    foreach ($snapshot_cat as $vid) {
        if ($vid['name'] == $oratorName) {
            $errors['name'] = 'Orator already exists.';
            break;
        }
    }

    if ($errors['oratorDescription'] == '' && $errors['name'] == '') {
        $added = 1;

        try {
            $docRef = $firestore->collection('Orators')->document($orator_id);
            $docRef->set([
                'description' => $oratorDescription,
                'name' => $oratorName,
                'photo' => $photolink,
                'videoType' => $_POST['oratorVideotype'],
                'DateCreated' => $timestamp

            ]);
            $oratorName = $oratorDescription = '';
            $oratorVideotype = array();
        } catch (Exception $exception) {
        }
    } else {
        $added = 2;
    }
}
