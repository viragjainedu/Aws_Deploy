<?php
$added = 0;
$errors = ['oratorDescription' => ''];

if (!isset($oratorprevimg)) {
    $oratorprevimg = '';
}

if (isset($_POST['submit'])) {

    $isFile = 1;

    foreach ($_FILES['thumb'] as $something) {

        if ($something == '') {
            $isFile = 0;
            break;
        }
    }
    if (!isset($oratorName)) {
        $oratorName = $_POST['oratorName'];
    }
    $oratoredit_id = $_POST['oratoredit'];
    $oratorDescription = $_POST['Des'];
    $oratorVideotype = $_POST['oratorVideotype'];
    if ($oratorprevimg == '') {
        $oratorprevimg = $_POST['oratorprevimg'];
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
    }


    if (trim($oratorDescription) == '') {
        $errors['oratorDescription'] = 'Description cannot be empty.';
    }

    if ($errors['oratorDescription'] == '') {

        $showOratorRef = $firestore->collection('ShowOrators');
        $showOratorDet = $showOratorRef->document($oratoredit_id)->snapshot();
        $updated_type = array();

        foreach ($showOratorDet['type'] as $o_type) {
            if (in_array($o_type, $_POST['oratorVideotype'])) {
                array_push($updated_type, $o_type);
            }
        }

        $orator_updateRef = $firestore->collection('ShowOrators')->document($oratoredit_id);
        $orator_updateRef->set([
            'orator name' => $oratorName,
            'type' => $updated_type,
        ], ['merge' => true]);

        // echo $oratorDescription . " " . $oratoredit_id . " <br/>";

        // foreach ($_POST['oratorVideotype'] as $oratort) {
        //     echo $oratort . " ";
        // }

        $added = 1;

        if ($isFile == 1) {

            try {
                $docRef = $firestore->collection('Orators')->document($oratoredit_id);
                $docRef->set([
                    'description' => $oratorDescription,
                    'photo' => $photolink,
                    'videoType' => $_POST['oratorVideotype'],
                ], ['merge' => true]);
            } catch (Exception $exception) {
                print($exception->getMessage());
            }

            $_SESSION['oratorUpdated'] = 'Updated';
            header("Location: ListOrators.php");
        } else {

            try {
                $docRef = $firestore->collection('Orators')->document($oratoredit_id);
                $docRef->set([
                    'description' => $oratorDescription,
                    'videoType' => $_POST['oratorVideotype'],
                ], ['merge' => true]);
            } catch (Exception $exception) {
                print($exception->getMessage());
            }

            $_SESSION['oratorUpdated'] = 'Updated';
            header("Location: ListOrators.php");
        }
    } else {
        $added = 2;
    }
}
