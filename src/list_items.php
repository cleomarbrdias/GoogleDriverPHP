<?php

function listGoogleDriveItems($folderId, $driveService, $indentLevel = 0, $isFirstFolder = false) {
    $parameters = [
        'q' => "'$folderId' in parents",
        'fields' => 'files(id, name, mimeType)',
        'supportsAllDrives' => true,
        'includeItemsFromAllDrives' => true,
    ];
    $fileList = $driveService->files->listFiles($parameters);
    $items = $fileList->getFiles();

    if (!empty($items)) {
        echo '<div class="folder-list">';
        foreach ($items as $item) {
            if ($item->getMimeType() === 'application/vnd.google-apps.folder') {
                $folderId = 'folder-' . $item->getId();
                $isOpen = $isFirstFolder ? 'block' : 'none';

                echo '<div class="folder">';
                echo '<div class="folder-header" onclick="toggleFolder(\'' . $folderId . '\')">';
                echo '<i class="far fa-folder-open"></i> <strong>' . htmlspecialchars($item->getName()) . '</strong>';
                echo '</div>';

                echo '<div id="' . $folderId . '" class="folder-content" style="display: ' . $isOpen . ';">';
                listGoogleDriveItems($item->getId(), $driveService, $indentLevel + 1, false);
                echo '</div>';
                echo '</div>';
            } else {
                echo '<div class="file"><i class="far fa-file"></i> <a href="?downloadFileId=' . $item->getId() . '">' . htmlspecialchars($item->getName()) . '</a></div>';
            }
        }
        echo '</div>';
    } else {
        echo "<p>Nenhum arquivo encontrado nesta pasta.</p>";
    }
}
