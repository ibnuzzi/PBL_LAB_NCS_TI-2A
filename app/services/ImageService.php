<?php
// File: /app/services/ImageService.php

class ImageService
{
    /**
     * Upload file gambar ke subfolder yang ditentukan.
     * @param array $file (entry dari $_FILES)
     * @param string $subdir (mis: 'berita' atau 'agenda')
     * @param string $prefix nama prefix file (mis: 'berita_' or 'agenda_')
     * @return string|false -> nama file jika sukses, false jika gagal
     */
    public static function uploadImage(array $file, $subdir = 'berita', $prefix = 'berita_')
    {
        if (empty($file) || empty($file['name'])) return false;

        $allowed = ['jpg', 'jpeg', 'png', 'gif'];
        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        if (!in_array($ext, $allowed)) return false;

        // batas 5MB
        $maxSize = 5 * 1024 * 1024;
        if ($file['size'] > $maxSize) return false;

        $uploadDir = __DIR__ . '/../../public/uploads/' . trim($subdir, '/') . '/';
        if (!is_dir($uploadDir)) {
            if (!mkdir($uploadDir, 0755, true)) return false;
        }

        // nama file yang aman
        try {
            $rand = random_int(1000, 9999);
        } catch (Exception $e) {
            $rand = mt_rand(1000, 9999);
        }
        $fileName = $prefix . time() . '_' . $rand . '.' . $ext;
        $target = $uploadDir . $fileName;

        if (!move_uploaded_file($file['tmp_name'], $target)) {
            return false;
        }

        return $fileName;
    }

    /**
     * Delete file gambar di subfolder tertentu jika ada.
     * @param string|null $fileName
     * @param string $subdir
     * @return bool
     */
    public static function deleteImage($fileName, $subdir = 'berita')
    {
        if (empty($fileName)) return false;
        $filePath = __DIR__ . '/../../public/uploads/' . trim($subdir, '/') . '/' . $fileName;
        if (file_exists($filePath) && is_file($filePath)) {
            return @unlink($filePath);
        }
        return false;
    }

    /**
     * Replace old image with uploaded one: upload new, delete old when new succeeded.
     * @param string|null $oldFile
     * @param array $newFile (from $_FILES)
     * @param string $subdir
     * @param string $prefix
     * @return string|false -> new filename or false on failure
     */
    public static function replaceImage($oldFile, array $newFile, $subdir = 'berita', $prefix = 'berita_')
    {
        $newName = self::uploadImage($newFile, $subdir, $prefix);
        if ($newName) {
            // delete old if exists
            if (!empty($oldFile)) {
                self::deleteImage($oldFile, $subdir);
            }
            return $newName;
        }
        return false;
    }
}
