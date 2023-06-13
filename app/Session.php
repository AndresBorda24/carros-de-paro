<?php

declare(strict_types = 1);

namespace App;

class Session
{
    public function start(): void
    {
        if ($this->isActive()) {
            throw new \RuntimeException('Ya se ha iniciado la sesion');
        }

        if (headers_sent($fileName, $line)) {
            throw new \RuntimeException('Headers have already sent by ' . $fileName . ':' . $line);
        }

        if (! session_start()) {
            throw new \RuntimeException('No se ha podido iniciar sesion');
        }
    }

    public function isActive(): bool
    {
        return session_status() === PHP_SESSION_ACTIVE;
    }

    public function get(string $key, $default = null)
    {
        return $this->has($key) ? $_SESSION[$key] : $default;
    }

    public function has(string $key): bool
    {
        return array_key_exists($key, $_SESSION);
    }

    public function regenerate(): bool
    {
        return session_regenerate_id();
    }
}
