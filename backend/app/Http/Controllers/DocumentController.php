<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    public function store(Request $request)

    {

        if (!auth('api')->check()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        
        $request->validate([
            'title' => 'required|string|max:255',
            'documentType' => 'required|string|max:255',
            'document' => 'required|file',
        ]);

        // Save File
        $path = $request->file('document')->store('documents');

        // Create Document
        $document = Document::create([
            'title' => $request->title,
            'documentType' => $request->documentType,
            'path' => $path,
            'userid' => auth('api')->id(),
        ]);

        return response()->json($document, 201);
    }

    // Retrieve all documents
    public function index()
    {
        $documents = Document::all();
        return response()->json($documents);
    }

    // Retrieve a specific document
    public function show($id)
    {
        $document = Document::findOrFail($id);
        return response()->json($document);
    }

    // Update a specific document
    public function update(Request $request, $id)
    {
        $document = Document::findOrFail($id);

        $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'documentType' => 'sometimes|required|string|max:255',
            'document' => 'sometimes|required|file',
        ]);

        // Update the document fields
        if ($request->hasFile('document')) {
            // Delete old file if it exists
            Storage::delete($document->path);
            // Save new file
            $path = $request->file('document')->store('documents');
            $document->path = $path;
        }
        $document->title = $request->title ?? $document->title;
        $document->documentType = $request->documentType ?? $document->documentType;

        $document->save();

        return response()->json($document);
    }

    // Delete a specific document
    public function destroy($id)
    {
        $document = Document::findOrFail($id);
        
        // Delete the file from storage
        Storage::delete($document->path);
        
        $document->delete();

        return response()->json(null, 204);
    }

    
    
    // Add document to category

    public function addToCategory(Request $request, $categoryId)
    {
        $request->validate([
            'document_id' => 'required|integer|exists:documents,id',
        ]);

        // add to category
        $document = Document::findOrFail($request->document_id);
        $document->categorieId = $categoryId;
        $document->save();

        return response()->json($document, 200);
    }

}
