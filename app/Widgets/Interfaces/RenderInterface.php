<?php

namespace App\Widgets\Interfaces;

interface RenderInterface
{
    public static function single(int $id): ?object;
    public static function all(): ?object;
}