<?php

namespace App\Http\Controllers;

use App\Models\Section;
use App\Models\Components;
use App\Models\Services;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SectionController extends Controller
{
    /** 
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $list = DB::table('sections')  
            ->leftJoin('components', 'components.id', '=', 'sections.componentsId')
            ->select(['sections.key as key', 'components.title as title', 'sections.id', 
                        'components.description as description',
                        'components.image as image', 'components.id as comId'
                        ])
            ->orderBy('id', 'ASC')
            ->get();

        foreach ($list as $post) {

            $component = [
                'id' => $post->comId,   
                'title' => $post->title,   
                'description' => $post->description, 
                'image' => $post->image
            ];
            
            $service = Services::where('componentsId', $post->comId)
                ->select(['componentsId', 'key', 'icon', 'name', 'description'])
                ->get();
 
            $res = array_merge($component, ['services' => $service]);
            
            $result[] = [
                'id' => $post->id,
                'key' => $post->key,
                'components'=>  $res
                
            ];
            }; 
        
            

            return response()->json([
            'data'=>$result
        ]);

    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $section = Section::create([
            'key' => $request -> key,
            'componentsId' => $request -> componentsId,
        ]);

        return response()->json([
            'data'=>$section
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Section  $section
     * @return \Illuminate\Http\Response
     */
    public function show(Section $section)
    {
        return response()->json([
            'data' => $section
        ]);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Section  $section
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Section $section)
    {   
        
        $section->key = $request->key;
        $section->componentsId = $request->componentsId;
        $section->save();

        return response()->json([
            'data' => $section
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Section  $section
     * @return \Illuminate\Http\Response
     */
    public function destroy(Section $section)
    {   
        $section->delete();
        return response()->json([
            'data' => $section
        ]);
    }
}
