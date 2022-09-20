<?php


namespace modules\storage;


class DataType {

    /**
     * Data for convert to target type
     *
     * @var string
     */
    protected string $data;

    public function __construct(string $data)
    {
        $this->data = $data;
    }

    /**
     * As string
     *
     * @return string
     */
    public function toText(): string
    {
        return $this->data;
    }

    /**
     * As array by lines
     *
     * @return array
     */
    public function toArray(): array
    {
        return explode(PHP_EOL, $this->data);
    }

    /**
     * As array from JSON
     *
     * @return array
     */
    public function fromJson(): array
    {
        return json_decode($this->data, true);
    }

    /**
     * As JSON from array by lines
     *
     * @return string
     */
    public function toJson(): string
    {
        return json_encode(explode(PHP_EOL, $this->data));
    }
}
