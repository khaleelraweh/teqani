<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\AboutInstatuteRequest;
use App\Models\AboutInstatute;
use DateTimeImmutable;
use Illuminate\Http\Request;

use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

use Illuminate\Support\Facades\File;

class AboutInsatatuteController extends Controller
{

    public function index()
    {
        if (!auth()->user()->ability('admin', 'manage_about_instatutes , show_about_instatutes')) {
            return redirect('admin/index');
        }

        $about_instatutes = AboutInstatute::query()
            ->when(\request()->keyword != null, function ($query) {
                $query->search(\request()->keyword);
            })
            ->when(\request()->status != null, function ($query) {
                $query->where('status', \request()->status);
            })
            ->orderBy(\request()->sort_by ?? 'published_on', \request()->order_by ?? 'desc')
            ->paginate(\request()->limit_by ?? 10);



        return view('backend.about_instatutes.index', compact('about_instatutes'));
    }

    public function create()
    {
        if (!auth()->user()->ability('admin', 'create_about_instatutes')) {
            return redirect('admin/index');
        }

        return view('backend.about_instatutes.create');
    }

    public function store(AboutInstatuteRequest $request)
    {
        if (!auth()->user()->ability('admin', 'create_about_instatutes')) {
            return redirect('admin/index');
        }



        $input['title'] = $request->title;
        $input['content'] = $request->content;

        $input['status']            =   $request->status;
        $input['created_by'] = auth()->user()->full_name;
        $published_on = $request->published_on . ' ' . $request->published_on_time;
        $published_on = new DateTimeImmutable($published_on);
        $input['published_on'] = $published_on;

        if ($image = $request->file('promotional_image')) {

            $manager = new ImageManager(new Driver());
            $file_name = 'pormotional' . '_' . time() .  "." . $image->getClientOriginalExtension();

            $img = $manager->read($request->file('promotional_image'));
            // $img = $img->resize(370, 246);

            $img->toJpeg(100)->save(base_path('public/assets/about_instatutes/' . $file_name));



            $input['promotional_image'] = $file_name;
        }

        $about_instatute = AboutInstatute::create($input);


        if ($about_instatute) {
            return redirect()->route('admin.about_instatutes.index')->with([
                'message' => __('panel.created_successfully'),
                'alert-type' => 'success'
            ]);
        }

        return redirect()->route('admin.about_instatutes.index')->with([
            'message' => __('panel.something_was_wrong'),
            'alert-type' => 'danger'
        ]);
    }



    public function show($id)
    {
        if (!auth()->user()->ability('admin', 'display_about_instatutes')) {
            return redirect('admin/index');
        }
        return view('backend.about_instatutes.show');
    }

    public function edit($about_instatute)
    {
        if (!auth()->user()->ability('admin', 'update_about_instatutes')) {
            return redirect('admin/index');
        }


        $about_instatute = AboutInstatute::where('id', $about_instatute)->first();

        return view('backend.about_instatutes.edit', compact('about_instatute'));
    }

    public function update(AboutInstatuteRequest $request, $about_instatute)
    {

        $about_instatute = AboutInstatute::where('id', $about_instatute)->first();

        $input['title'] = $request->title;
        $input['content'] = $request->content;

        $input['status']            =   $request->status;
        $input['created_by'] = auth()->user()->full_name;
        $published_on = $request->published_on . ' ' . $request->published_on_time;
        $published_on = new DateTimeImmutable($published_on);
        $input['published_on'] = $published_on;


        if ($image = $request->file('promotional_image')) {
            if ($about_instatute->promotional_image != null && File::exists('assets/about_instatutes/' . $about_instatute->promotional_image)) {
                unlink('assets/about_instatutes/' . $about_instatute->promotional_image);
            }

            $manager = new ImageManager(new Driver());
            $file_name = 'pormotional' . '_' . time() .  "." . $image->getClientOriginalExtension();

            $img = $manager->read($request->file('promotional_image'));
            // $img = $img->resize(370, 246);

            $img->toJpeg(100)->save(base_path('public/assets/about_instatutes/' . $file_name));

            $input['promotional_image'] = $file_name;
        }

        $about_instatute->update($input);

        if ($about_instatute) {
            return redirect()->route('admin.about_instatutes.index')->with([
                'message' => __('panel.updated_successfully'),
                'alert-type' => 'success'
            ]);
        }

        return redirect()->route('admin.about_instatutes.index')->with([
            'message' => __('panel.something_was_wrong'),
            'alert-type' => 'danger'
        ]);
    }


    public function destroy($about_instatute)
    {
        if (!auth()->user()->ability('admin', 'delete_about_instatutes')) {
            return redirect('admin/index');
        }

        $about_instatute = AboutInstatute::where('id', $about_instatute)->first()->delete();

        if ($about_instatute) {
            return redirect()->route('admin.about_instatutes.index')->with([
                'message' => __('panel.deleted_successfully'),
                'alert-type' => 'success'
            ]);
        }

        return redirect()->route('admin.about_instatutes.index')->with([
            'message' => __('panel.something_was_wrong'),
            'alert-type' => 'danger'
        ]);
    }


    public function remove_image(Request $request)
    {

        if (!auth()->user()->ability('admin', 'delete_about_instatutes')) {
            return redirect('admin/index');
        }

        $about_instatute = AboutInstatute::findOrFail($request->about_instatute_id);
        if (File::exists('assets/about_instatutes/' . $about_instatute->promotional_image)) {
            unlink('assets/about_instatutes/' . $about_instatute->promotional_image);
            $about_instatute->promotional_image = null;
            $about_instatute->save();
        }
        if ($about_instatute->promotional_image != null) {
            $about_instatute->promotional_image = null;
            $about_instatute->save();
        }

        return true;
    }
}
