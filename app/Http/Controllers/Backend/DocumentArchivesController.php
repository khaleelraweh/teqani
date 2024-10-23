<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\DocumentArchive;
use Illuminate\Http\Request;

class DocumentArchivesController extends Controller
{
    public function index()
    {
        if (!auth()->user()->ability('admin', 'manage_document_archives , show_document_archives')) {
            return redirect('admin/index');
        }

        // $documentArchives = DocumentArchive::all();


        $documentArchives = DocumentArchive::query()
            ->when(\request()->keyword != null, function ($query) {
                $query->search(\request()->keyword);
            })
            ->when(\request()->status != null, function ($query) {
                $query->where('status', \request()->status);
            })
            ->orderBy(\request()->sort_by ?? 'id', \request()->order_by ?? 'desc')
            ->paginate(\request()->limit_by ?? 10);


        return view('backend.document_archives.index', compact('documentArchives'));
    }

    public function create()
    {
        if (!auth()->user()->ability('admin', 'create_document_archives')) {
            return redirect('admin/index');
        }
        return view('backend.document_archives.create');
    }

    public function store(Request $request)
    {
        if (!auth()->user()->ability('admin', 'create_document_archives')) {
            return redirect('admin/index');
        }



        $validatedData = $request->validate([
            'doc_archive_name' => 'required|string',
            'doc_archive_attached_file' => 'nullable|file|mimes:pdf,docx|max:2048', // Validate each file

        ]);

        $data['doc_archive_name']          = $validatedData['doc_archive_name'];
        $data['created_by']                = auth()->user()->full_name;


        // Handle file uploads
        if ($file = $request->file('doc_archive_attached_file')) {
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = public_path('assets/document_archives');
            $file->move($filePath, $fileName); // Move image file
            $data['doc_archive_attached_file'] = $fileName;
        }

        $documentArchive = DocumentArchive::create($data);

        if ($documentArchive) {
            return redirect()->route('admin.document_archives.index')->with([
                'message' => __('panel.created_successfully'),
                'alert-type' => 'success'
            ]);
        }

        return redirect()->route('admin.document_archives.index')->with([
            'message' => __('panel.something_was_wrong'),
            'alert-type' => 'danger'
        ]);
    }
}
