<?php


namespace modules\storage;


class DataType {

    /**
     * Data for convert to target type
     *
     * @var array
     */
    protected $data = [];

    public function __construct(array $data)
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
        return implode(',', $this->data);
    }

    /**
     * As array by lines
     *
     * @return array
     */
    public function toArray(): array
    {
        return $this->data;
    }

    /**
     * As array from JSON
     *
     * @return array
     */
    public function fromJson(): array
    {
        return array_map(function($e) {
            return json_decode($e, true);
        }, $this->data);
    }

    /**
     * As JSON from array by lines
     *
     * @return string
     */
    public function toJson(): string
    {
        return json_encode($this->toText());
    }
}
