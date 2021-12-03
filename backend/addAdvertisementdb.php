<?php

use Google\Cloud\Core\Timestamp;

$added = 0;
$errors = ['priority' => ''];
$adlink = $priority = '';

if (isset($_POST['submit'])) {
    $added = 1;
    $adlink = $_POST['adlink'];
    $priority = $_POST['priority'];
    $priority = (int)$priority;
    $timestamp = new Timestamp(new DateTime());


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


    $catRef = $firestore->collection('Advertisements');
    $snapshot_cat = $catRef->documents();

    $max_priority = 0;
    foreach ($snapshot_cat as $ad) {
        $max_priority = max($max_priority, $ad['Priority']);
    }
    $max_priority = $max_priority + 1;

    foreach ($snapshot_cat as $ad) {
        if ($ad['Priority'] == $priority) {
            $errors['priority'] = 'Priority already set for other advertisement. Please set the priority again.';
            break;
        }
    }

    $max_priority2 = $max_priority;

    $advertisement_id = "ad" . ($max_priority);
    foreach ($snapshot_cat as $ad) {
        if ($ad->id() == $advertisement_id) {
            $max_priority2 = $max_priority2 + 1;
            break;
        }
    }

    while ($max_priority2 != $max_priority) {
        $max_priority = $max_priority2;
        $advertisement_id = "ad" . ($max_priority);
        foreach ($snapshot_cat as $ad) {
            if ($ad->id() == $advertisement_id) {
                $max_priority2 = $max_priority2 + 1;
                break;
            }
        }
    }


    if ($errors['priority'] == '') {
        $added = 1;

        try {
            $docRef = $firestore->collection('Advertisements')->document($advertisement_id);
            $docRef->set([
                'Link' => $adlink,
                'Priority' => $priority,
                'photo' => $videolink1,
                'DateCreated' => $timestamp

            ]);
            $errors = ['priority' => ''];
            $adlink = $priority = '';
        } catch (Exception $exception) {
            print($exception->getMessage());
        }
    } else {
        $added = 2;
    }
}
