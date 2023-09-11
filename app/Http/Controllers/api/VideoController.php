<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Video;
use Illuminate\Http\Request;

class VideoController extends Controller
{

    public function searchVideosByTitle($search)
    {
        try {
            $videos = Video::where('title', 'like', "%$search%")->get();

            if ($videos->isEmpty()) {
                return response()->json(['error' => 'Nenhum vídeo encontrado'], 404);
            }

            return response()->json(compact('videos'), 200);
        } catch (\Throwable $th) {
            return response()->json($th, 400);
        }
    }



    public function index ()
    {
        $videos = Video::with('category')->paginate(5);

        return response()->json($videos, 200);
    }

    public function create ()
    {
        //
    }

    public function store (Request $request)
    {
        try {
            $messages = [
                'required' => "O campo Title, Description, URL, category_id é obrigatório",
            ];

            $jsonData = json_decode($request->getContent(), true);
            $videoData = $jsonData['videos'];

            $validator = validator($videoData, [
                'title' => 'required',
                'url' => 'required',
                'description' => 'required',
                'category_id' => 'sometimes|exists:categories,id',
            ], $messages);

            // Verifica se a validação falhou
            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()], 400);
            }

            $validateData = $validator->validate();

            if (!isset($validateData['category_id'])) {
                $validateData['category_id'] = 1;
            }

            $newVideo = Video::create($validateData);

//            $response = [
////                'videos' => $newVideo
//            ];

        } catch (\Throwable $th) {
            return response()->json($th, 400);
        }

        return response()->json($newVideo, 201);
    }


    public function show (string $id)
    {
        $video = Video::find($id);

        if (is_null($video)) {
            return response()->json(['error' => 'Video not found'], 404);
        }

        return response()->json($video, 200);
    }

    public function edit (string $id)
    {
        //
    }

    public function update (Request $request, string $id)
    {
        $video = Video::find($id);
        if (is_null($video)) {
            return response()->json(['error' => 'Video not found'], 404);
        }
        $video->update($request->all());


        return response()->json($video, 200);
    }

    public function destroy (string $id)
    {
        $video = Video::find($id);
        if (is_null($video)) {
            return response()->json(['error' => 'Video not found'], 404);
        }
        $video->delete();
        return response()->json('Video deleted', 200);
    }
}
