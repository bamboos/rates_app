<?php

namespace App\Service;

class FileSystemFile
{
    public function read(string $fileName): string
    {
        set_error_handler(
            function ($severity, $message, $file, $line) {
                throw new \ErrorException($message, $severity, $severity, $file, $line);
            }
        );

        $contents = file_get_contents($fileName);

        restore_error_handler();

        return $contents;
    }
}
