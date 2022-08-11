<?php

namespace App\Dimmers;

use Exception;

class Dimmer
{
    private array $dimmers = [];
    private array $sizes = ['1/1', '1/2', '1/3', '1/4', '2/3'];

    public function __construct()
    {
        $this->collect();
    }

    /**
     * @throws Exception
     */
    private function collect(): void
    {
        $collector = config('dimmers.dimmers');
        foreach ($collector as $dimmer) {

            if (class_exists($dimmer['class'])) {

                if (in_array($dimmer['size'], $this->sizes, true)) {

                    $this->dimmers[] = $dimmer;

                } else {

                    throw new Exception(
                        sprintf('The size "%s" is not supported.', $dimmer['size'])
                    );
                }

            } else {

                throw new Exception(
                    sprintf('The class "%s" doesn\'t exists.', $dimmer['class'])
                );
            }
        }
    }

    public function activate(): object
    {
        $activates = [];
        foreach ($this->dimmers as $dimmer) {

            $class = new $dimmer['class'];
            $size = ($dimmer['size'] !== '2/3')
                ? 100 / (int) str_replace('1/', '', $dimmer['size'])
                : 66.66;
            $cssSize = number_format($size, 2, '.', '') . '%';

            if (is_int($size)) {
                $cssSize = $size . '%';
            }

            $activates[] = ['class' => $class->index(), 'size' => $cssSize];
        }
        return $this->render($activates);
    }

    private function render($dimmers) :object
    {
        return view('dimmers.index', compact('dimmers'));
    }
}