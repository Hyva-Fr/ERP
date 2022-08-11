<?php

namespace App\Dimmers\Containers;

use App\Dimmers\DimmerInterface\RenderInterface;

class Banner implements RenderInterface
{
    public function index()
    {
        return view('dimmers.containers.banner');
    }
}