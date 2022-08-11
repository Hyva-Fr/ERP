<?php

namespace App\Widgets;

use App\Widgets\Interfaces\RenderInterface;
use App\Models\Agency;
use App\Models\User;
use App\Models\Mission;
use App\Widgets\Traits\WidgetsTrait;

class AgencyWidget implements RenderInterface
{
    use WidgetsTrait;

	public static function single(int $id): ?object
	{
        $array = ['users' => [], 'missions' => []];
        foreach (User::where(['agency_id' => $id, 'employed' => 1])->get() as $user) {
            $array['users'][] = '<a href="' . route('users.show', ['user' => $user->id]) . '">' . $user->name . '</a>';
        }

        foreach (Mission::where(['agency_id' => $id])->get() as $mission) {
            $array['missions'][] = '<a href="' . route('missions.show', ['mission' => $mission->id]) . '">' . $mission->serial . '</a>';
        }

        return self::render($array, self::class, 'single');
	}

	public static function all(): ?object
	{
        $array = [];
        foreach (Agency::get() as $agency) {
            $s = [
                'link' => '<a href="' . route('agencies.show', ['agency' => $agency->id]) . '">' . $agency->name . '</a>'
            ];
            $users = [];
            $missions = [];
            foreach (User::where(['agency_id' =>  $agency->id, 'employed' => 1])->get() as $user) {
                $users[] = [
                    'link' => '<a href="' . route('users.show', ['user' => $user->id]) . '">' . $user->name . '</a>'
                ];
            }
            $s['users'] = $users;
            foreach (Mission::where(['agency_id' => $agency->id])->get() as $mission) {
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