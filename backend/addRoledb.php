<?php
include('../dbconn.php');

use Google\Cloud\Core\Timestamp;

if (isset($_POST['submit'])) {
    $staffName = $_POST['staffname'];
    $email = $_POST['email'];
    $password = $_POST['newpass'];
    $password1 = password_hash($password, PASSWORD_DEFAULT);
    $role = $_POST['role'];
    $timestamp = new Timestamp(new DateTime());
    $acc = array();
    $roles = array('All_pages', 'Add_Video', 'Videos_List', 'Add_Series', 'Series_List', 'Add_Category', 'Categories_List', 'Add_Orator', 'Orators_List', 'Slider', 'Add_Slider', 'Create_Roles', 'Users_List', 'Add_Advertisement', 'Advertisements_List', 'Donations', 'About_Us', 'Contact_Us', 'Report', 'SocialMedia', 'Terms_and_Conditions', 'Privacy_Policy');

    if (isset($_POST['All_pages'])) {
        foreach ($roles as $val) {
            if ($val != 'All_pages') {
                array_push($acc, $val);
            }
        }
    } else {

        foreach ($roles as $val) {
            if (isset($_POST[$val])) {
                array_push($acc, $_POST[$val]);
            }
        }
    }

    try {
        $docRef = $firestore->collection('Admin_Roles')->document($email);
        $docRef->set([
            'Username' => $staffName,
            'EmailId' => $email,
            'Password' => $password1,
            'Role' => $role,
            'Access' => $acc,
            'DateCreated' => $timestamp
        ]);
        header("Location: ../addRole.php");
    } catch (Exception $exception) {
        print($exception->getMessage());
    }
}
