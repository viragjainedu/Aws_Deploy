<?php

$added = 0;
$errors = ['priority' => ''];
$category = $priority = $original_color = '';


if (isset($_POST['submit'])) {

    if ($category == '') {
        $category = $_POST['catName'];
    }
    $catedit_id = $_POST['categoryedit'];
    $priority = $_POST['priority'];
    if (!isset($cat_type)) {
        $cat_type = $_POST['vitype'];
    }
    $priority = (int)$priority;

    $original_color = $_POST['color'];

    $color = "0xff" . substr($_POST['color'], 1);


    if (!isset($_SESSION['editpriority'])) {

        $_SESSION['editpriority']  = 0;
    }
    if ($_SESSION['editCatId'] != '') {
        $editdocref = $firestore->collection('Categories');
        $editdoc = $editdocref->document($_SESSION['editCatId'])->snapshot();
        $_SESSION['editpriority'] = $editdoc['priority'];
    }

    $catRef = $firestore->collection('Categories');
    $snapshot_cat = $catRef->documents();

    foreach ($snapshot_cat as $vid) {
        if ($vid['priority'] == $priority && $vid['priority'] != $_SESSION['editpriority']) {

            $errors['priority'] = 'Priority already set for other category. Please set the priority again.';
            break;
        }
    }

    if ($errors['priority'] == '') {
        $added = 1;

        try {
            $docRef = $firestore->collection('Categories')->document($catedit_id);
            $docRef->set([
                'Type' => $cat_type,
                'color' => $color,
                'priority' => $priority,
            ], ['merge' => true]);
        } catch (Exception $exception) {
            print($exception->getMessage());
        }

        $category = $priority = '';
        $original_color = '#71b6f9';

        $_SESSION['categoryUpdated'] = 'Updated';
        header("Location: ListCategories.php");
    } else {
        $added = 2;
    }
}
