<?php

namespace App\Http\Controllers;

use App\Models\Carrer;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CarrerController extends Controller{

    public function getAllCarrer(){
        $carrers = Carrer::all();
        return response()->json($carrers);
    }
   
    public function getCarrerByUUID(Carrer $carrer){
        return response()->json($carrer);
    }
   
    public function store(Request $request){
        $request->validate([
              'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
              'description' => 'required|string',
              'link' => 'nullable|url',
        ]);
  
        $imagePath = null;
        if ($request->hasFile('image')) {
              $imagePath = $request->file('image')->store('carrers', 'public'); 
        }
  
        $carrer = Carrer::create([
              'carrer_uuid' => Str::uuid(),
              'image_url' => $imagePath,
              'description' => $request->description,
              'link' => $request->link,
        ]);

          
        DB::table('carrer_creators')->insert([
            'user_id' => Auth::user()->id,
            'carrer_id' => $carrer->id,
        ]);

  
        return response()->json([
            'message' => 'Carrer created successfully', 'data' => $carrer
        ], 201);
    }


      
    public function update(Request $request, Carrer $carrer){
        $request->validate([
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'description' => 'required|string',
            'link' => 'nullable|url',
        ]);

        if ($request->hasFile('image')) {
            if ($carrer->image_url) {
                Storage::disk('public')->delete($carrer->image_url);
            }
            $carrer->image_url = $request->file('image')->store('carrers', 'public');
        }

        $carrer->update([
            'description' => $request->description,
            'link' => $request->link,
        ]);

        return response()->json([
            'message' => 'Carrer updated successfully', 'data' => $carrer
            ]
        );
    }

  
    public function destroy(Carrer $carrer){
      
        if ($carrer->image_url) {
            Storage::disk('public')->delete($carrer->image_url);
        }

        $carrer->delete();

        return response()->json([
            'message' => 'Carrer deleted successfully'
            ]
        );
    }

    public function edit(Carrer $carrer){
        return view('carrerUpdate', compact('carrer'));
    }
}
