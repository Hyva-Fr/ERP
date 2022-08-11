<?php

namespace App\Widgets;

use App\Widgets\Interfaces\RenderInterface;
use App\Models\Society;
use App\Models\Mission;
use App\Widgets\Traits\WidgetsTrait;

class SocietyWidget implements RenderInterface
{
    use WidgetsTrait;

	public static function single(int $id): ?object
	{
        $array = [];
        foreach (Mission::where(['society_id' => $id])->get() as $mission) {
            $array[] = [
                'link' => '<a href="' . route('missions.show', ['mission' => $mission->id]) . '">' . $mission->serial . '</a>'
            ];
        }

        return self::render($array, self::class, 'single');
	}

	public static function all(): ?object
	{
        $array = [];
        foreach (Society::get() as $society) {
            $s = [
                'link' => '<a href="' . route('societies.show', ['society' => $society->id]) . '">' . $society->name . '</a>'
            ];
            $missions = [];
            foreach (Mission::where(['society_id' => $society->id])->get() as $mission) {
                $missions[] = [
                    'link' => '<a href="' . route('missions.show', ['mission' => $mission->id]) . '">' . $mission->serial . '</a>'
                ];
            }
            $s['missions'] = $missions;
            $array[] = $s;
        }

        return self::render($array, self::class, 'all');
	}
}