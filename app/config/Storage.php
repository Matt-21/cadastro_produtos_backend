<?php

namespace app\config;

class Storage
{
    private static string $image_name;
    private static string $image_type;
    private static string $image_size;
    private static string $image_temp;
    private static string $uploads_folder = '/uploads/';
    private static int|float $uploads_max_size = 2*1024*1024;
    private static array $allowed_image_types = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
    public static $error;

    public static function Disk ($files): string
    {
        self::$image_name = $files['image']['name'];
        self::$image_size = $files['image']['size'];
        self::$image_temp = $files['image']['tmp_name'];
        self::$image_type = $files['image']['type'];

        self::isImage();
        self::imageNameValidation();
        self::sizeValidation();
        self::checkFile();

        if (is_null(self::$error)) {
           return self::moveFile();
        }
        return self::$error;
    }

    private static function isImage(): void
    {
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime = finfo_file($finfo, self::$image_temp);
        if(!in_array($mime, self::$allowed_image_types)){
            self::$error = 'Apenas [ .jpg, .png, .jpeg and .gif ] estás extensões são permitidas.';
            return;
        }
        finfo_close($finfo);
    }

    private static function imageNameValidation(): void
    {
        self::$image_name = filter_var(self::$image_name, FILTER_SANITIZE_STRING);
    }

    private static function sizeValidation(): void
    {
       if (self::$image_size > self::$uploads_max_size) {
           self::$error = 'O arquivo é maior que 2MB!';
       }
    }

    private static function checkFile(): void
    {
        if (file_exists(self::$uploads_folder.self::$image_name)) {
           self::$error = 'O arquivo já existe na pasta!';
        }
    }

    private static function moveFile(): string
    {
        if (!move_uploaded_file(self::$image_temp, getcwd().self::$uploads_folder.self::$image_name)) {
            return self::$error = 'Ocorreu um erro, por favor tente novamente!';
        }
        return self::$uploads_folder.self::$image_name;
    }
}