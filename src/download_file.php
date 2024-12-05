<?php

function downloadFile($fileId, $driveService) {
    try {
        $file = $driveService->files->get($fileId, [
            'fields' => 'name, mimeType, size',
            'supportsAllDrives' => true,
        ]);

        $response = $driveService->files->get($fileId, [
            'alt' => 'media',
            'supportsAllDrives' => true,
        ]);

        while (ob_get_level()) {
            ob_end_clean();
        }

        header('Content-Description: File Transfer');
        header('Content-Type: ' . $file->getMimeType());
        header('Content-Disposition: attachment; filename="' . basename($file->getName()) . '"');
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . $file->getSize());

        $stream = $response->getBody();
        while (!$stream->eof()) {
            echo $stream->read(1024 * 8);
            flush();
        }

        exit;
    } catch (Exception $e) {
        error_log("Erro ao baixar o arquivo: " . $e->getMessage());
        header("HTTP/1.1 500 Internal Server Error");
        echo "Erro ao baixar o arquivo.";
        exit;
    }
}
