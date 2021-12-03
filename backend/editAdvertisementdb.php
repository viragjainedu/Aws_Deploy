<?php
$added = 0;
$errors = ['priority' => ''];
$adlink = $priority = '';
$oratorprevimg = '';

if (isset($_POST['submit'])) {

    $isFile = 1;

    foreach ($_FILES['thumb'] as $something) {

        if ($something == '') {
            $isFile = 0;
            break;
        }
    }

    $adlink = $_POST['adlink'];
    $priority = $_POST['priority'];
    $oratorprevimg = $_POST['oratorprevimg'];

    $priority = (int)$priority;

    if ($isFile == 1) {

        $bucket_name = "sdi-ott.appspot.com";
        $bucket = $storage->bucket($bucket_name);
        $thumb_name = 'Advertisements/' . $adlink . '/' . $_FILES["thumb"]["name"];

        $object = $bucket->upload(
            file_get_contents($_FILES['thumb']['tmp_name']),
            [
                'name' => $thumb_name
            ]
        );
        $object->update(['acl' => []], ['predefinedAcl' => 'PUBLICREAD']);
        $videolink1 = 'https://storage.googleapis.com/' . $bucket_name . '/' . $object->name();
    }

    if (!isset($_SESSION['editApriority'])) {

        $_SESSION['editApriority']  = 0;
    }

    if ($_SESSION['editAdId'] != '') {
        $editdocref = $firestore->collection('Advertisements');
        $editdoc = $editdocref->document($_SESSION['editAdId'])->snapshot();
        $_SESSION['editApriority'] = $editdoc['Priority'];
    }

    $catRef = $firestore->collection('Advertisements');
    $snapshot_cat = $catRef->documents();

    foreach ($snapshot_cat as $ad) {
        if ($ad['Priority'] == $priority && $ad['Priority'] != $_SESSION['editApriority']) {
            $errors['priority'] = 'Priority already set for other advertisement. Please set the priority again.';
            break;
        }
    }



    if ($errors['priority'] == '') {
        $added = 1;

        if ($isFile == 1) {
            echo "File is uploaded";


            try {
                $docRef = $firestore->collection('Advertisements')->document($_SESSION['editAdId']);
                $docRef->set([
                    'Link' => $adlink,
                    'Priority' => $priority,
                    'photo' => $videolink1
                ], ['merge' => true]);
            } catch (Exception $exception) {
                print($exception->getMessage());
            }
        } else {

            echo "File not uploaded";

            try {
                $docRef = $firestore->collection('Advertisements')->document($_SESSION['editAdId']);
                $docRef->set([
                    'Link' => $adlink,
                    'Priority' => $priority,
                ], ['merge' => true]);
            } catch (Exception $exception) {
                print($exception->getMessage());
            }
        }

        $_SESSION['AdUpdated'] = 'Updated';
        header("Location: ListAdvertisement.php");
    } else {
        $added = 2;
    }
}
