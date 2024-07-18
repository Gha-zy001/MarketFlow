<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoriesController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    $categories = Category::all();
    return view('dashboard.categories.index', compact('categories'));
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
    $categories = Category::all();
    return view('dashboard.categories.create', compact('categories'));
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {
    $request->merge([
      'slug' => Str::slug($request->name),
    ]);

    $data = $request->except('image');
    if ($request->hasFile('image')) {
      $file = $request->file('image');
      $path = $file->store('categories', 'public');
      $data['image'] = $path;
    }
    $category = Category::create($data);

    return redirect()->route('dashboard.categories.index')
      ->with('Success', 'Category created!');
  }

  /**
   * Display the specified resource.
   */
  public function show(string $id)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(string $id)
  {
    $category = Category::findOrFail($id);
    $parents = Category::where('id', '<>', $id)
      ->where(function ($query) use ($id) {
        $query->whereNull('parent_id')
          ->orWhere('parent_id', '<>', $id);
      })
      ->get();
    return view('dashboard.categories.edit', compact('category', 'parents'));
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, string $id)
  {
    $category = Category::findOrFail($id);
    $category->update($request->all());
    return redirect()
      ->route('dashboard.categories.index')
      ->with('success', 'Category updated!');
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(string $id)
  {
    Category::destroy($id);
    return redirect()
      ->route('dashboard.categories.index')
      ->with('success', 'Category deleted!');
  }
}
