<?php


namespace modules\storage;


class Disk {

    const PROJECT_ROOT = __DIR__ . '/../../';

    /**
     * Массив пути к файлу хранилища
     *
     * @var array
     */
    protected array $parts = [];

    public function __construct(string $settings)
    {
         $this->parts = explode('.', $settings);
    }

    /**
     * If file exist in the storage
     *
     * @param string $file_name
     * @return bool
     */
    public function exists(string $file_name): bool
    {
        return file_exists($this->getFullPath($file_name));
    }


    public function get(string $file_name)
    {
        if (!$this->exists($file_name)) {
            return false;
        }

        return new DataType(file_get_contents($this->getFullPath($file_name)));
    }

    /**
     * Save data into the storage
     *
     * @param string $file_name
     * @param string $data
     * @return bool
     */
    public function put(string $file_name, string $data): bool
    {
        if ($this->exists($file_name)) {
            return false;
        }

        file_put_contents($this->getFullPath($file_name), $data);

        return true;
    }

    /**
     * Append file in the storage with data
     *
     * @param string $file_name
     * @param string $data
     * @return bool
     */
    public function append(string $file_name, string $data): bool
    {
        if (!$this->exists($file_name)) {
            return false;
        }

        file_put_contents($this->getFullPath($file_name), $data, FILE_APPEND);

        return true;
    }

    /**
     * Delete file in the storage
     *
     * @param string $file_name
     * @return bool
     */
    public function delete(string $file_name): bool
    {
        if (!$this->exists($file_name)) {
            return false;
        }

        unlink($this->getFullPath($file_name));

        return true;
    }

    /**
     * Get full path to file from ROOT DIR
     *
     * @param string $file_name
     * @return string
     */
    private function getFullPath(string $file_name): string
    {
        return self::PROJECT_ROOT . 'storage/'. implode('/', $this->parts) . '/' . $file_name . '.st';
    }
}
