<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ip;
use App\Models\Mission;
use Barryvdh\Debugbar\Facade as Debugbar;
use App;

class AjaxController extends Controller
{
    public function index($slug, Request $request)
    {
        if (App::environment('local')) {
            Debugbar::disable();
        }

        if ($request->ajax()) {

            $transformSlug = strtolower($slug);
            $transformSlug = str_replace(['-', '_'], ' ', $transformSlug);
            $transformSlug = 'process' . str_replace(' ', '',ucwords($transformSlug));

            if (method_exists($this, $transformSlug)) {
                return $this->$transformSlug($request);
            }
        }
        return abort(404);
    }

    private function processUnbanIp(Request $request)
    {
        $id = (int) $request->input('id');
        Ip::where('id', $id)->delete();
        return $id;
    }

    /**
     * @throws \JsonException
     */
    private function processDeleteMissionImage(Request $request): string
    {
        $data = $request->input('data');
        $mission = Mission::select('images')->where('id', (int) $data['id'])->first();

        if ($mission !== null) {

            $images = ($mission->images !== null && $mission->images !== '')
                ? json_decode($mission->images, true, 512, JSON_THROW_ON_ERROR)
                : [];

            if (!empty($images)) {

                $newArray = [];
                foreach ($images as $image) {

                    if ($image !== $data['path']) {
                        $newArray[] = $image;
                    }
                }
                Mission::where('id', (int) $data['id'])->update(['images' => json_encode($newArray, JSON_THROW_ON_ERROR)]);
                return 'ok';
            }
        }
        return 'error';
    }
}
