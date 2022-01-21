<?php

namespace StratusCoreLaravelPresets;

use Illuminate\Support\Arr;

class JsonFile
{
    /**
     * The Json file path
     *
     * @var string
     */
    protected $path;

    /**
     * The json files contents
     *
     * @var array
     */
    protected $contents;

    /**
     * Creates an instance of this class from a path
     *
     * @param string $path
     *
     * @return $this
     */
    public static function createFromPath($path)
    {
        return new static($path);
    }

    /**
     * Creates an instance of this class
     *
     * @param string $path
     */
    public function __construct($path)
    {
        $this->path = $path;

        $this->contents = $this->readContentsFromPath($path);
    }

    /**
     * Gets the current file contents
     *
     * @return array
     */
    public function getContents()
    {
        return $this->contents;
    }

    /**
     * Merge stub from path
     *
     * @param string $path
     *
     * @return boolean
     */
    public function mergeStubFromPath($path)
    {
        $this->contents = $this->merge($this->contents, $this->readContentsFromPath($path));

        return $this;
    }

    /**
     * Saves the changes to the current file
     *
     * @param string|null $path
     *
     * @return boolean|int
     */
    public function save($path = null)
    {
        return file_put_contents(
            $path ?: $this->path,
            json_encode($this->contents, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) . PHP_EOL
        );
    }

    /**
     * Merges the given data into current content
     *
     * @param array $stub
     *
     * @return array
     */
    protected function merge(array $existing, array $stub)
    {
        foreach ($stub as $key => $value) {
            $existing[$key] = $this->toMergeIntoKeyValue($existing, $value, $key);
        }

        return $existing;
    }

    /**
     * Reads contents from a path
     *
     * @param string $path
     *
     * @return array
     */
    protected function readContentsFromPath($path)
    {
        return json_decode(file_get_contents($path), true);
    }

    /**
     * The final value to merge into a given key
     *
     * @param array $existing
     * @param mixed $value
     * @param string $key
     *
     * @return mixed
     */
    protected function toMergeIntoKeyValue(array $existing, $value, $key)
    {
        if (! is_array($value) || ! array_key_exists($key, $existing)) {
            return $value;
        }

        $existingArray = Arr::wrap($existing[$key] ?? []);

        if (Arr::isAssoc($value)) {
            return $this->merge($existingArray, $value);
        }

        //todo: Handle edge case for nested arrays

        return array_unique(array_merge($existingArray, $value));
    }
}
