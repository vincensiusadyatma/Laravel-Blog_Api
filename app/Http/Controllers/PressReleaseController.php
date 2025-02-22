<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use App\Models\PressRelease;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\PressReleaseContent;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Console\View\Components\Warn;

class PressReleaseController extends Controller{
    public function getAlllPress(){
        $pressReleases = PressRelease::with(['contents' => function ($query) {
            $query->orderBy('id', 'asc'); 
        }])->orderBy('id', 'asc')->get(); 

        return response()->json([
            'message' => 'Press releases retrieved successfully',
            'data' => $pressReleases
        ], 200);
    }

    public function getPressById(PressRelease $pressRelease){
        return response()->json([
            'message' => 'Press release retrieved successfully',
            'data' => $pressRelease->load(['contents' => function ($query) {
                $query->orderBy('id', 'asc');
            }]),
        ], 200);
    }
    

    public function edit($id){
        $pressRelease = PressRelease::with(['contents' => function ($query) {
            $query->orderBy('id', 'asc'); 
        }])->findOrFail($id);
    
        return view('pressReleaseUpdate', compact('pressRelease'));
    }
    

    public function store(Request $request){
        try {
            $validatedData = $request->validate([
                'title' => 'required|string|max:255',
                'date' => 'required|date',
                'time' => 'required',
                'contents' => 'required|array',
                'contents.*.content' => 'nullable|string',
                'contents.*.image' => 'nullable|image|max:2048', 
            ]);
    
            $pressRelease = PressRelease::create([
                'title' => $validatedData['title'],
                'press_uuid'=> Str::uuid(),
                'date' => $validatedData['date'],
                'time' => $validatedData['time'],
            ]);
    
            // save every press content
            foreach ($validatedData['contents'] as $content) {
                $imageUrl = null;
    
                if (!empty($content['image'])) {
                    $path = $content['image']->store('press_images', 'public');
                    $imageUrl = "storage/$path"; 
                }
    
                PressReleaseContent::create([
                    'press_release_id' => $pressRelease->id,
                    'content' => $content['content'] ?? null,
                    'image_url' => $imageUrl,
                ]);
            }

            DB::table('press_releases_creators')->insert([
                'user_id' => Auth::user()->id,
                'press_id' => $pressRelease->id,
            ]);
    
            return response()->json([
                'message' => 'Press release created successfully',
                'data' => $pressRelease->load('contents'),
            ], 201);
    
        } catch (\Illuminate\Validation\ValidationException $e) {
            // validate fail
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $e->errors(),
            ], 422);
            
        } catch (\Exception $e) {
            // if another error 
            return response()->json([
                'message' => 'Something went wrong',
                'error' => $e->getMessage(),
            ], 500);
        }
    }


    public function destroy(PressRelease $pressRelease){
        foreach ($pressRelease->contents as $content) {
            if ($content->image_url) {

                $path = $content->image_url;
    
                if (Storage::disk('public')->exists($path)) {
                    Storage::disk('public')->delete($path);
                }
            }
            $content->delete(); 
        }
    
        // Hapus press release
        $pressRelease->delete();
    
        return response()->json([
            'message' => 'Press release deleted successfully'
        ], 200);
    }
    
     public function update(Request $request, $id){
         $request->validate([
             'title' => 'required|string|max:255',
             'date' => 'required|date',
             'time' => 'required',
             'contents' => 'required|array',
             'contents.*.content' => 'nullable|string',
             'contents.*.image' => 'nullable|image|max:2048', 
         ]);
     
         // Update Press Release 
         $pressRelease = PressRelease::findOrFail($id);
         $pressRelease->update([
             'title' => $request->title,
             'date' => $request->date,
             'time' => $request->time,
         ]);
     
         // Loop fot press content update
         foreach ($request->contents as $content) {
             if (!empty($content['id'])) {
          
                 $pressReleaseContent = PressReleaseContent::find($content['id']);
     
                 if ($pressReleaseContent) {
                     $imageUrl = $pressReleaseContent->image_url; 
                     
                     if (isset($content['image'])) {
                       
                         $path = $content['image']->store('press_images', 'public');
                         $imageUrl = asset("storage/$path");
                     }
     
                     $pressReleaseContent->update([
                         'content' => $content['content'] ?? $pressReleaseContent->content,
                         'image_url' => $imageUrl, 
                     ]);
                 }
             } else {
            
                 $imageUrl = null;
                 if (isset($content['image'])) {
                     $path = $content['image']->store('press_images', 'public');
                     $imageUrl = asset("storage/$path");
                 }
     
                 PressReleaseContent::create([
                     'press_release_id' => $pressRelease->id,
                     'content' => $content['content'] ?? null,
                     'image_url' => $imageUrl,
                 ]);
             }
         }
     
         return response()->json([
            'message' => 'Press release updated successfully',
            'data' => $pressRelease->load(['contents' => function ($query) {
                $query->orderBy('id', 'asc'); 
            }]),
        ], 200);
        
     }
     

    

}
