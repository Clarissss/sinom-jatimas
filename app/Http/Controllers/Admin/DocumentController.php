<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Document;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    protected $allowedTypes = [
        'application/pdf' => 'pdf',
        'image/jpeg' => 'jpg',
        'image/png' => 'png',
        'image/jpg' => 'jpg',
        'application/vnd.openxmlformats-officedocument.wordprocessingml.document' => 'docx',
        'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' => 'xlsx',
    ];

    public function index()
    {
        $documents = Document::with(['project', 'uploader'])->latest()->paginate(15);
        return view('admin.documents.index', compact('documents'));
    }

    public function create()
    {
        $projects = Project::all();
        return view('admin.documents.create', compact('projects'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'project_id' => ['required', 'exists:projects,id'],
            'type' => ['required', 'in:contract,technical_drawing,bast,material_report,other'],
            'file' => ['required', 'file', 'mimes:pdf,jpg,png,docx,xlsx', 'max:10240'], // Max 10MB
        ]);

        $file = $request->file('file');
        
        if (!array_key_exists($file->getMimeType(), $this->allowedTypes)) {
            return back()->withErrors(['file' => 'Tipe file tidak diizinkan.']);
        }

        $path = $file->store('documents', 'local');

        Document::create([
            'project_id' => $validated['project_id'],
            'type' => $validated['type'],
            'file_name' => $file->getClientOriginalName(),
            'file_path' => $path,
            'file_type' => $file->getMimeType(),
            'file_size' => $file->getSize(),
            'uploaded_by' => auth()->id(),
        ]);

        return redirect()->route('admin.documents.index')->with('success', 'Dokumen berhasil diupload.');
    }

    public function download(Document $document)
    {
        if (!Storage::exists($document->file_path)) {
            abort(404, 'File tidak ditemukan.');
        }

        return Storage::download($document->file_path, $document->file_name);
    }

    public function destroy(Document $document)
    {
        Storage::delete($document->file_path);
        $document->delete();

        return back()->with('success', 'Dokumen berhasil dihapus.');
    }
}
