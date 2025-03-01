<?php

namespace App\Http\Controllers;
use App\Models\Gallery;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'caption' => 'required|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Simpan gambar ke storage dan dapatkan pathnya
        $path = $request->file('image')->store('gallery', 'public');

        // Simpan data ke database
        $gallery = Gallery::create([
            'gallery_uuid' =>  Str::uuid(),
            'image_url' => $path, 
            'content' => $request->caption,
        ]);

        DB::table('gallery_creators')->insert([
            'user_id' => Auth::user()->id,
            'gallery_id' => $gallery->id,
        ]);

        return response()->json([
            'status' => 200,
            'message' => 'Gallery Conntent berhasil ditambahkan',
        ], 200);
    }

    public function getAlllGallery(){
        $galleries = Gallery::all();
     
        return response()->json([
            'message' => 'Galleries retrieved successfully',
            'data' => $galleries
        ], 200);
    }

    public function getGalleryById(Gallery $gallery){
        return response()->json([
            'message' => 'Gallery Data retrieved successfully',
            'data' => $gallery
        ], 200);
    }

    public function destroy(Gallery $gallery){
        $gallery-> delete();

        return response()->json([
            'message' => 'Gallery delete successfully',
        ], 200);
    }

    public function update(Request $request, $uuid){
        $gallery = Gallery::where('gallery_uuid', $uuid)->firstOrFail();
        
        $request->validate([
            'caption' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            // delete old image
            if ($gallery->image_url) {
                Storage::disk('public')->delete($gallery->image_url);
            }
            // save new image
            $gallery->image_url = $request->file('image')->store('gallery', 'public');
        }
        if ($request->caption) {
            $gallery->caption = $request->caption;
        }

        $gallery->save();

        return response()->json([
            'message' => 'Gallery updated successfully',
            'data' => $gallery
        ], 200);
    }


    public function edit($uuid)
    {
        $gallery = Gallery::where('gallery_uuid', $uuid)->firstOrFail();
        return view('galleryUpdate', compact('gallery'));
    }
    
    
    

    
}
