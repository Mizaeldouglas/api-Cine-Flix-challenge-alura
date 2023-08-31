<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Video;
use Illuminate\Http\Request;

class VideoController extends Controller
{

    public function index ()
    {
        $videos = Video::all();

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
                'required' => "O campo Title, Description, URL  é obrigatório",
            ];
            $validade = $request->validate([
                'title' => 'required',
                'url' => 'required',
                'description' => 'required',

            ], $messages);

            $newVideo = Video::create($validade);

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
