<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Tymon\JWTAuth\Facades\JWTAuth;


class DocumentController extends Controller
{
    public function store(Request $request)
{
    if (!Auth::check()) {
        return response()->json(['error' => 'Unauthorized'], 401);
    }

    $request->validate([
        'title' => 'required|string|max:255',
        'documentType' => 'required|string|max:255',
        'document' => 'required|file|mimes:pdf,doc,docx,xls,xlsx|max:2048',
        'categoryId' => 'required|exists:categories,id',
    ]);

    // Get the authenticated user's ID using JWTAuth
    $userId = JWTAuth::user()->id; 

    $path = $request->file('document')->store('documents');

    $document = Document::create([
        'title' => $request->title,
        'documentType' => $request->documentType,
        'path' => $path,
        'userid' => $userId,
        'categoryId' => $request->categoryId,
    ]);

    return response()->json($document, 201);
}

    public function index()
    {
        if (!Auth::check()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $userId = JWTAuth::user()->id; 

        $documents = Document::with('category')->where('userid', $userId)->get();
        return response()->json($documents);
    }

    public function show($id)
    {
        if (!Auth::check()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $document = Document::findOrFail($id);
        return response()->json($document);
    }

    public function update(Request $request, $id)
{
    if (!Auth::check()) {
        return response()->json(['error' => 'Unauthorized'], 401);
    }

    $document = Document::findOrFail($id);


    $request->validate([
        'title' => 'sometimes|required|string|max:255', // Optional: only validate if provided
        'documentType' => 'sometimes|required|string|max:255',
        'document' => 'sometimes|required|file',
    ]);

    if ($request->hasFile('document')) {
        Storage::delete($document->path);
        $document->path = $request->file('document')->store('documents');
    }

    // Only update the title if it's provided in the request
    if ($request->has('title')) {
        $document->title = $request->title;
    }

    // Always update documentType if provided
    if ($request->has('documentType')) {
        $document->documentType = $request->documentType;
    }

    $document->save();

    return response()->json($document);
}



    public function destroy($id)
    {
        if (!Auth::check()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $document = Document::findOrFail($id);
        Storage::delete($document->path);
        $document->delete();

        return response()->json(null, 204);
    }

    public function addToCategory(Request $request, $categoryId)
    {
        if (!Auth::check()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $request->validate(['document_id' => 'required|integer|exists:documents,id']);
        $document = Document::findOrFail($request->document_id);
        $document->categoryId = $categoryId;
        $document->save();

        return response()->json($document, 200);
    }
}
