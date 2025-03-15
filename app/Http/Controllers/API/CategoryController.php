<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function getAll()
    {
        $categories = Category::all();
        return response()->json([
            'status' => true,
            'code' => 200,
            'message' => 'All Categories ⚡',
            'data' => $categories,
        ]);
    }

    public function get(string $id)
    {
        try {
            $posts = Category::where('id', $id)->first()->posts;

            return response()->json([
                'status' => true,
                'code' => 200,
                'message' => 'Category products ⚡',
                'data' => $posts,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'code' => $e->getCode(),
                'message' => $e->getMessage(),
                'data' => null,
            ]);
        }


    }

    public function store(Request $request)
    {
        try {
            
                $category = new Category();
                $category->name = $request->name;
                if ($request->hasFile('image')) {
                    $path = $request->file('image')->store('images', 'public'); // Rasm 'storage/app/public/images' ichiga saqlanadi
                    $category->image = $path;
                }
                $category->save(); 
                


                return response()->json([
                    'status' => true,
                    'code' => 200,
                    'message' => 'Category success created ⚡',
                    'data' => $category,
                ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'code' => $e->getCode(),
                'message' => $e->getMessage(),
                'data' => null,
            ]);
        }
    }

    public function show($id)
    {
        $category = Category::findOrFail($id);
        return response()->json($category);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $category = Category::findOrFail($id);
        $category->update(['name' => $request->name]);

        return response()->json($category);
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();

        return response()->json(['message' => 'Category deleted']);
    }
}
