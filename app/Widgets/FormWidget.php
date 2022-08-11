<?php

namespace App\Widgets;

use App\Widgets\Interfaces\RenderInterface;
use App\Models\Form;
use App\Models\Category;
use App\Widgets\Traits\WidgetsTrait;

class FormWidget implements RenderInterface
{
    use WidgetsTrait;

	public static function single(int $id): ?object
	{
        $cat = Form::select('categories.id', 'categories.name')
            ->join('categories', 'forms.category_id', '=', 'categories.id')
            ->where('forms.id', $id)
            ->firstOrFail();
        $forms = ['id' => $cat->id, 'name' => $cat->name, 'forms' => []];
        foreach (Form::where('category_id', $cat->id)->get() as $form) {
            $forms['forms'][] = [
                'link' => '<a href="' . route('forms.show', ['form' => $form->id]) . '">' . $form->name . '</a>'
            ];
        }

        return self::render($forms, self::class, 'single');
	}

	public static function all(): ?object
	{
        $array = [];
        foreach (Category::get() as $category) {
            $c = [
                'link' => '<a href="' . route('categories.show', ['category' => $category->id]) . '">' . $category->name . '</a>'
            ];
            $forms = [];
            foreach (Form::where('category_id', $category->id)->get() as $form) {
                $forms[] = [
                    'link' => '<a href="' . route('forms.show', ['form' => $form->id]) . '">' . $form->name . '</a>'
                ];
            }
            $c['forms'] = $forms;
            $array[] = $c;
        }

        return self::render($array, self::class, 'all');
	}
}