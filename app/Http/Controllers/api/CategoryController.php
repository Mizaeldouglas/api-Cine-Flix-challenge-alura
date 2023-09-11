<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

    public function videosPorCategoria ($id)
    {
        try {
            $categories = Category::findOrfail($id);
            $videos = $categories->videos;

            if ($videos->isEmpty()) {
                return response()->json(['error' => 'Nenhum vídeo encontrado'], 404);
            }

            return response()->json(compact('videos'), 200);
        } catch (\Throwable $th) {
            return response()->json($th, 400);
        }
    }

    public function index()
    {
        $categories = Category::all();
        return response()->json($categories);

    }

    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        $validade = $request->validate([
            'title' => 'required',
            'color' => 'required|regex:/^#[a-f0-9]{6}$/i',
        ]);
        $newCategory = Category::create($validade);

        return response()->json($newCategory, 201);
    }

    public function show(string $id)
    {
        $category = Category::find($id);
        if (is_null($category)) {
            return response()->json(['error' => 'Category not found'], 404);
        }
        return response()->json($category, 200);
    }

    public function edit(string $id)
    {
        //
    }


    public function update(Request $request, string $id)
    {
        $category = Category::find($id);
        if (is_null($category)) {
            return response()->json(['error' => 'Category not found'], 404);
        }
        $category->update($request->all());

        return response()->json($category, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

        $category = Category::find($id);
        if (is_null($category)) {
            return response()->json(['error' => 'Category not found'], 404);
        }
        $category->delete();
        return response()->json('Category deleted', 200);
    }
}
