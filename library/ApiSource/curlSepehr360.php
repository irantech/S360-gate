<?php
$handle = curl_init('online.indobare.com/gds/library/ApiSource/CronJobsForSepehr360.php');
curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
$result = curl_exec($handle);
return json_decode($result, true);
?>