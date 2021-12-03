<?php

use Google\Cloud\Core\Timestamp;

$added = 0;
$errors = ['priority' => '', 'name' => ''];

$category = $priority = '';
$original_color = '#71b6f9';

if (isset($_POST['submit'])) {
    $category = $_POST['catName'];
    $category_id = str_replace(' ', '', $category);
    $priority = $_POST['priority'];
    $vidtype = $_POST['vitype'];
    $priority = (int)$priority;
    $timestamp = new Timestamp(new DateTime());

    $original_color = $_POST['color'];
    $color = "0xff" . substr($_POST['color'], 1);

    $catRef = $firestore->collection('Categories');
    $snapshot_cat = $catRef->documents();

    foreach ($snapshot_cat as $vid) {
        if ($vid['priority'] == $priority) {
            $errors['priority'] = 'Priority already set for other category. Please set the priority again.';
            break;
        }
    } 

    foreach ($snapshot_cat as $vid) {
        if ($vid['name'] == $category) {
            $errors['name'] = 'Category already exists.';
            break;
        }
    }

    if ($errors['priority'] == '' && $errors['name'] == '') {
        $added = 1;

        try {
            $docRef = $firestore->collection('Categories')->document($category_id);
            $docRef->set([
                'color' => $color,
                'name' => $category,
                'priority' => $priority,
                'Type' => $vidtype,
                'DateCreated' => $timestamp
            ]);
        } catch (Exception $exception) {
            print($exception->getMessage());
        }

        $category = $priority = '';
        $original_color = '#71b6f9';
    } else {
        $added = 2;
    }
}
