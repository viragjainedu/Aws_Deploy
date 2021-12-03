<?php

require __DIR__.'/vendor/autoload.php';

use Google\Cloud\Firestore\FirestoreClient;
use Google\Cloud\Storage\StorageClient;

$firestore = new FirestoreClient([
    'projectId' => 'sdi-ott',
]);

$storage = new StorageClient([
    'keyFilePath' => getcwd(). '\sdi-ott-firebase-adminsdk-oqiyh-8cfe5be259.json',
]);
