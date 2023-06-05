<?php

declare(strict_types=1);

namespace App;

class Config
{
    private array $config;

    function __construct(array $config)
    {
        $this->config = $config;
    }

    public function get(string $name, $default = null)
    {
        $path  = explode('.', $name);
        $value = $this->config[array_shift($path)] ?? null;

        if ($value === null) {
            return $default;
        }

        foreach ($path as $key) {
            if (!isset($value[$key])) {
                return $default;
            }

            $value = $value[$key];
        }

        return $value;
    }
}
