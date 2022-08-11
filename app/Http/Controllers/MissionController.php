<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mission;
use App\Models\Society;
use App\Models\Agency;
use App\Models\Comment;
use Illuminate\Support\Facades\Schema;
use App\Filters\FormFilters;
use JsonException;
use App\Widgets\MissionWidget;
use Session;
use File;
use Auth;

class MissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $table = 'missions';
        $keys = Schema::getColumnListing($table);
        $excepts = ['id', 'distribution_plan', 'clamping_plan', 'electrical_diagram', 'workshops_help', 'receipt', 'delivery_note', 'images', 'updated_at'];
        $thead = setColumns($keys, $excepts);
        $extracts = [
            'society' => [
                'route' => 'societies',
                'rel' => 'society_id'
            ],
            'agency' => [
                'route' => 'agencies',
                'rel' => 'agency_id'
            ]
        ];
        $filters = [];

        foreach ($thead as $filter) {
            if(!array_key_exists($filter, $extracts)) {
                $filters[] = $filter;
            }
        }

        $query = Mission::select(
            'missions.id',
            'missions.serial',
            'missions.review',
            'missions.description',
            'missions.society_id',
            'missions.agency_id',
            'missions.done',
            'societies.name as society',
            'agencies.name as agency',
            'missions.created_at',
        )
            ->join('societies', 'missions.society_id', '=', 'societies.id')
            ->join('agencies', 'missions.agency_id', '=', 'agencies.id');

        $data = FormFilters::getFilteredCollection($request, $query, $filters, $table);
        $compact = compact('thead', 'data', 'excepts', 'table', 'extracts');

        if (\Request::ajax()) {
            return view('cruds.table', $compact);
        }

        return view('cruds.index', $compact);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $societies = Society::get();
        $agencies = Agency::get();
        return view('cruds.missions.edit-show', compact('agencies', 'societies'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'serial' => 'required|max:255',
            'review' => 'required|max:80',
            'society_id' => 'required|integer',
            'agency_id' => 'required|integer',
            'done' => 'required'
        ]);

        $files = $request->file();
        $mission = Mission::create([
            'serial' => $request->input('serial'),
            'review' => $request->input('review'),
            'description' => $request->input('description'),
            'society_id' => $request->input('society_id'),
            'agency_id' => $request->input('agency_id'),
            'done' => $request->input('done'),
        ]);
        $this->uploadFiles($files, $mission->id);

        Session::flash('message', 'Successfully created mission!');
        return redirect()->route('missions.index');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     * @throws JsonException
     */
    public function show($id)
    {
        $data = Mission::select(
            'missions.id',
            'missions.serial',
            'missions.review',
            'missions.distribution_plan',
            'missions.clamping_plan',
            'missions.electrical_diagram',
            'missions.workshops_help',
            'missions.receipt',
            'missions.delivery_note',
            'missions.description',
            'missions.society_id',
            'missions.agency_id',
            'missions.done',
            'missions.images',
            'societies.name as society',
            'agencies.name as agency',
            'missions.created_at',
        )
            ->join('societies', 'missions.society_id', '=', 'societies.id')
            ->join('agencies', 'missions.agency_id', '=', 'agencies.id')
            ->where('missions.id', $id)
            ->firstOrFail();

        $data->images = (!is_null($data->images) && $data->images !== '')
            ? json_decode($data->images, true, 512, JSON_THROW_ON_ERROR)
            : [];

        $societies = Society::get();
        $agencies = Agency::get();
        $comments = Comment::select('comments.id', 'comments.comment', 'users.name', 'comments.created_at')
            ->join('users', 'comments.user_id', '=', 'users.id')
            ->where('comments.mission_id', $id)
            ->get();

        return view('cruds.missions.edit-show', compact('data', 'id', 'societies', 'agencies', 'comments'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     * @throws JsonException
     */
    public function edit($id)
    {
        $data = Mission::select(
            'missions.id',
            'missions.serial',
            'missions.review',
            'missions.distribution_plan',
            'missions.clamping_plan',
            'missions.electrical_diagram',
            'missions.workshops_help',
            'missions.receipt',
            'missions.delivery_note',
            'missions.description',
            'missions.society_id',
            'missions.agency_id',
            'missions.done',
            'missions.images',
            'societies.name as society',
            'agencies.name as agency',
            'missions.created_at',
        )
            ->join('societies', 'missions.society_id', '=', 'societies.id')
            ->join('agencies', 'missions.agency_id', '=', 'agencies.id')
            ->where('missions.id', $id)
            ->firstOrFail();

        $data->images = (!is_null($data->images))
            ? json_decode($data->images, true, 512, JSON_THROW_ON_ERROR)
            : [];

        $societies = Society::get();
        $agencies = Agency::get();
        $comments = Comment::select('comments.id', 'comments.comment', 'users.name', 'comments.created_at')
            ->join('users', 'comments.user_id', '=', 'users.id')
            ->where('comments.mission_id', $id)
            ->get();

        return view('cruds.missions.edit-show', compact('data', 'id', 'societies', 'agencies', 'comments'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     * @throws JsonException
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'serial' => 'required|max:255',
            'review' => 'required|max:80',
            'society_id' => 'required|integer',
            'agency_id' => 'required|integer',
            'done' => 'required'
        ]);

        $mission = Mission::select('images')->where('id', $id)->first();
        $images = (!is_null($mission->images) && $mission->images !== '')
            ? json_decode($mission->images, true, 512, JSON_THROW_ON_ERROR)
            : [];

        $comment = $request->input('comments');
        if ($comment !== null) {
            Comment::create([
                'comment' => $comment,
                'user_id' => Auth::user()->id,
                'mission_id' => $id
            ]);
        }

        $files = $request->file();
        Mission::where('id', $id)->update([
            'serial' => $request->input('serial'),
            'review' => $request->input('review'),
            'description' => $request->input('description'),
            'society_id' => $request->input('society_id'),
            'agency_id' => $request->input('agency_id'),
            'done' => $request->input('done'),
        ]);
        $this->uploadFiles($files, $id, $images);
        
        Session::flash('message', 'Successfully updated mission!');
        return redirect()->route('missions.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Mission::where('id', $id)->delete();
        $this->deleteFiles($id);
        Session::flash('message', 'Successfully deleted mission!');
        return redirect()->route('missions.index');
    }

    /**
     * @throws JsonException
     */
    private function uploadFiles($files, $id, $imagePaths = []): void
    {
        $filePaths = [];
        if (!empty($files)) {

            $path = '/storage/';
            foreach ($files as $name => $file) {

                if ($name !== 'images') {

                    $extension = pathinfo($file->getClientOriginalName(), PATHINFO_EXTENSION);
                    $fileName = $name . '.' . $extension;
                    $dirPath = 'missions/' . $id;
                    $filePaths[$name] = $dirPath . '/' . $fileName;
                    $file->storeAs($dirPath, $fileName, 'public');

                } else {

                    foreach ($file as $img) {

                        $fileName = date("YmdHis") . '-' . $img->getClientOriginalName();
                        $dirPath = 'missions/' . $id . '/images';
                        $imagePaths[] = $dirPath . '/' . $fileName;
                        $img->storeAs($dirPath, $fileName, 'public');
                    }

                    $filePaths['images'] = json_encode($imagePaths, JSON_THROW_ON_ERROR);
                }
            }

            Mission::where('id', $id)->update($filePaths);
        }
    }

    private function deleteFiles($id): void
    {
        $storageDestinationPath = storage_path('app/public/missions/' . $id);
        if (File::exists($storageDestinationPath)) {
            File::deleteDirectory($storageDestinationPath);
        }
    }
}
