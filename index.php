<?php
require __DIR__ . '/src/initialize.php';
require __DIR__ . '/src/list_items.php';
require __DIR__ . '/src/download_file.php';
require __DIR__ . '/src/find_folder.php';

$driveService = initializeGoogleDriveApi();
$rootFolderId = getenv('ROOT_FOLDER_ID');

if (isset($_GET['downloadFileId'])) {
    downloadFile($_GET['downloadFileId'], $driveService);
} else {
    $folderName = 'rl-ctvisa';
    $folderId = findFolderByName($driveService, $folderName, $rootFolderId);

    if ($folderId) {
        echo '<h3>Resumos Executivos</h3>';
        listGoogleDriveItems($folderId, $driveService);
    } else {
        echo "<p>Pasta não encontrada.</p>";
    }
}
