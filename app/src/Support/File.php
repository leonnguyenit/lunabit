<?php

namespace Luna\Support;

class File
{
    /**
     * Write File
     *
     * Writes data to the file specified in the path.
     * Creates a new file if non-existent.
     *
     * @param   string $path File path
     * @param   string $data Data to write
     * @param   string $mode fopen() mode (default: 'wb')
     * @return  bool
     */
    public static function writeFile($path, $data, $mode = 'wb')
    {
        if (!$fp = @fopen($path, $mode)) {
            return false;
        }

        flock($fp, LOCK_EX);

        for ($result = $written = 0, $length = strlen($data); $written < $length; $written += $result) {
            if (($result = fwrite($fp, substr($data, $written))) === false) {
                break;
            }
        }

        flock($fp, LOCK_UN);
        fclose($fp);

        return is_int($result);
    }
}
