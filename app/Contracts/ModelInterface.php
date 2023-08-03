<?php
declare(strict_types=1);

namespace App\Contracts;

interface ModelInterface
{
    public function getModel(): string;

    public function create(array $data);

    public function update(int $id, array $data);

    public function delete(int $id);

    public function getFromCarro(int $carroId);
}
