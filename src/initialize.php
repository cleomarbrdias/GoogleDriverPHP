<?php
require __DIR__ . '/../vendor/autoload.php';

function initializeGoogleDriveApi() {
    $serviceAccountJson = json_decode(file_get_contents(__DIR__ . '/../config/service_account.json'), true);

    $client = new Google_Client();
    $client->setAuthConfig($serviceAccountJson);
    $client->setScopes([Google_Service_Drive::DRIVE]);

    return new Google_Service_Drive($client);
}
