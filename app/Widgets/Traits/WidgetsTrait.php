<?php

namespace App\Widgets\Traits;

trait WidgetsTrait
{
    public static function render(array $data, string $class, string $type): ?object
    {
        if (!empty($data)) {
            $blade = strtolower(str_replace(['App\\Widgets\\', 'Widget'], '', $class));
            return view('widgets.' . $blade, compact('type', 'data'));
        }
        return null;
    }
}