<?php

namespace App\Widgets;

use App\Widgets\Interfaces\RenderInterface;
use App\Models\Country;
use App\Models\State;
use App\Models\Agency;
use App\Widgets\Traits\WidgetsTrait;

class CountryWidget implements RenderInterface
{
    use WidgetsTrait;

	public static function single(int $id): ?object
	{
        $array = [];
        foreach (State::where('country_id', $id)->get() as $state) {
            $s = [
                'link' => '<a href="' . route('states.show', ['state' => $state->id]) . '">' . $state->name . '</a>'
            ];
            $agencies = [];
            foreach (Agency::where('state_id', $state->id)->get() as $agency) {
                $agencies[] = [
                    'link' => '<a href="' . route('agencies.show', ['agency' => $agency->id]) . '">' . $agency->name . '</a>'
                ];
            }
            $s['agencies'] = $agencies;
            $array[] = $s;
        }

        return self::render($array, self::class, 'single');
	}

	public static function all(): ?object
	{
        $array = [];
        foreach (Country::get() as $country) {
            $c = [
                'link' => '<a href="' . route('countries.show', ['country' => $country->id]) . '">' . $country->name . '</a>'
            ];
            $states = [];
            foreach (State::where('country_id', $country->id)->get() as $state) {
                $s = [
                    'link' => '<a href="' . route('states.show', ['state' => $state->id]) . '">' . $state->name . '</a>'
                ];
                $agencies = [];
                foreach (Agency::where('state_id', $state->id)->get() as $agency) {
                    $agencies[] = [
                        'link' => '<a href="' . route('agencies.show', ['agency' => $agency->id]) . '">' . $agency->name . '</a>'
                    ];
                }
                $s['agencies'] = $agencies;
                $states[] = $s;
            }
            $c['states'] = $states;
            $array[] = $c;
        }

        return self::render($array, self::class, 'all');
	}
}