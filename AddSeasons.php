<?php
include("dbconn.php");
if (isset($_POST['submit'])) {
    $seriesid = $_POST['seriesdet'];
    $ref = $firestore->collection('Series')->document($seriesid)->collection('Seasons');
    $seasons = $ref->documents();
    $temp = 1;
    foreach ($seasons as $document) {
        if ($document->exists()) {
            $temp = $temp + 1;
        }
    }
    try {
        $str = "Season " . $temp;
        $docRef = $ref->document($str);
        $docRef->set([
            'Season Name' => $str,
            'Season No' => $temp,
        ]);
        header("Location: ListSeries.php");
    } catch (Exception $exception) {
        print($exception->getMessage());
    }
}
