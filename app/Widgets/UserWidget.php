<?php

namespace App\Widgets;

use App\Widgets\Interfaces\RenderInterface;
use App\Models\User;
use App\Models\Validate;
use App\Models\Mission;
use App\Widgets\Traits\WidgetsTrait;

class UserWidget implements RenderInterface
{
    use WidgetsTrait;

	public static function single(int $id): ?object
	{
		$array = [];
        $vals = Validate::select('validates.mission_id')
            ->join('users', 'validates.user_id', '=', 'users.id')
            ->where('validates.user_id', $id)
            ->get();
        $ids = [];
        foreach ($vals as $val) {
            $ids[] = $val->mission_id;
        }
        foreach (Mission::whereIn('id', $ids)->get() as $mission) {
            $m = [
                'link' => '<a href="' . route('missions.show', ['mission' => $mission->id]) . '">' . $mission->serial . '</a>'
            ];
            $forms = [];
            $v = Validate::select('validates.id', 'forms.name')
                ->join('forms', 'validates.form_id', '=', 'forms.id')
                ->where(['user_id' => $id, 'mission_id' => $mission->id])
                ->get();
            foreach ($v as $form) {
                $forms[] = [
                    'link' => '<a href="' . route('completed-forms.show', ['completed_form' => $form->id]) . '">' . $form->name . '</a>'
                ];
            }
            $m['forms'] = $forms;
            $array[] = $m;
        }

        return self::render($array, self::class, 'single');
	}

	public static function all(): ?object
	{
		$users = User::get();
        $active = 0;
        $inactive = 0;
        $total = 0;

        foreach ($users as $user) {
            if ((int) $user->employed === 1) {
                $active++;
            } else {
                $inactive++;
            }
            $total++;
        }
        $array = [
            'active' => $active,
            'inactive' => $inactive,
            'total' => $total
        ];

        return self::render($array, self::class, 'all');
	}
}