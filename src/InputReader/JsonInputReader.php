<?php

namespace App\InputReader;

use App\InputReader;
use App\Service\FileSystemFile;

class JsonInputReader implements InputReader
{
    private FileSystemFile $file;

    public function __construct(FileSystemFile $file)
    {
        $this->file = $file;
    }

    public function read(...$params): array
    {
        $data = (array) explode(PHP_EOL, $this->file->read($params[0]));

        try {
            return array_map(fn ($item) => json_decode(
                $item,
                true,
                512,
                JSON_THROW_ON_ERROR
            ), $data);
        } catch (\Exception $e) {
            throw new \RuntimeException('Wrong file name or malformed json provided');
        }
    }
}
