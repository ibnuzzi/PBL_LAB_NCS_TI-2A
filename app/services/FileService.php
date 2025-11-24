<?php

class FileService
{
    public static function uploadFile($file, $folder, $prefix = "file_")
    {
        if (!isset($file) || $file['error'] !== UPLOAD_ERR_OK) {
            return false;
        }

        $allowed = ['pdf', 'doc', 'docx', 'zip'];
        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

        if (!in_array($ext, $allowed)) {
            return false;
        }

        if ($file['size'] > 5 * 1024 * 1024) { // 5 MB
            return false;
        }

        $targetFolder = __DIR__ . "/../../public/uploads/$folder/";
        if (!is_dir($targetFolder)) {
            mkdir($targetFolder, 0777, true);
        }

        $newName = $prefix . time() . '.' . $ext;
        $path = $targetFolder . $newName;

        if (move_uploaded_file($file['tmp_name'], $path)) {
            return $newName;
        }

        return false;
    }

    public static function deleteFile($filename, $folder)
    {
        $path = __DIR__ . "/../../public/uploads/$folder/" . $filename;
        if (file_exists($path)) {
            unlink($path);
        }
    }

    public static function replaceFile($oldFile, $newFile, $folder, $prefix = "file_")
{
    // Upload baru
    $uploaded = self::uploadFile($newFile, $folder, $prefix);

    if ($uploaded === false) {
        return false;
    }

    // Hapus lama
    if (!empty($oldFile)) {
        self::deleteFile($oldFile, $folder);
    }

    return $uploaded;
}

}
