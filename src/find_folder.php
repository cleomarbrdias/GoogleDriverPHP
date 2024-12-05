<?php

function findFolderByName($driveService, $folderName, $rootFolderId) {
    $parameters = [
        'q' => "mimeType = 'application/vnd.google-apps.folder' and name = '$folderName' and '$rootFolderId' in parents",
        'fields' => 'files(id, name)',
        'supportsAllDrives' => true,
        'includeItemsFromAllDrives' => true,
    ];
    $fileList = $driveService->files->listFiles($parameters);
    $files = $fileList->getFiles();

    return !empty($files) ? $files[0]->getId() : null;
}
