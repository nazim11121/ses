<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use Illuminate\Http\Request;

class SliderController extends Controller
{
    public function index()
    {
        $slides = Slider::orderBy('position')->get();
        return view('admin.sliders.index', compact('slides'));
    }

    public function create()
    {
        return view('admin.sliders.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'button_text' => 'nullable|string|max:100',
            'button_link' => 'nullable|string|max:255',
            'image' => 'required|string|max:255',
            'position' => 'nullable|integer|min:0',
            'active' => 'nullable|boolean',
        ]);

        Slider::create(array_merge($request->all(), ['active' => $request->has('active')]));

        return redirect()->route('admin.sliders.index')->with('success', 'Slider item saved successfully.');
    }

    public function edit($id)
    {
        $slide = Slider::findOrFail($id);
        return view('admin.sliders.edit', compact('slide'));
    }

    public function update(Request $request, $id)
    {
        $slide = Slider::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'button_text' => 'nullable|string|max:100',
            'button_link' => 'nullable|string|max:255',
            'image' => 'required|string|max:255',
            'position' => 'nullable|integer|min:0',
            'active' => 'nullable',
        ]);

        $slide->update(array_merge($request->all(), ['active' => $request->has('active')]));

        return redirect()->route('admin.sliders.index')->with('success', 'Slider item updated successfully.');
    }

    public function destroy($id)
    {
        $slide = Slider::findOrFail($id);
        $slide->delete();

        return redirect()->route('admin.sliders.index')->with('success', 'Slider item deleted successfully.');
    }
}
