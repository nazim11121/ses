<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CompanyProfile;
use Illuminate\Http\Request;

class CompanyProfileController extends Controller
{
    public function index()
    {
        $profiles = CompanyProfile::latest()->get();
        return view('admin.company_profiles.index', compact('profiles'));
    }

    public function create()
    {
        return view('admin.company_profiles.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:50',
            'address' => 'nullable|string',
            'website' => 'nullable|url|max:255',
            'tagline' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'facebook' => 'nullable|url|max:255',
            'instagram' => 'nullable|url|max:255',
            'active' => 'nullable|boolean',
        ]);

        CompanyProfile::create(array_merge($request->only([
            'name',
            'email',
            'phone',
            'address',
            'website',
            'tagline',
            'description',
            'facebook',
            'instagram',
        ]), ['active' => $request->has('active')]));

        return redirect()->route('admin.company-profiles.index')->with('success', 'Company profile created successfully.');
    }

    public function edit($id)
    {
        $profile = CompanyProfile::findOrFail($id);
        return view('admin.company_profiles.edit', compact('profile'));
    }

    public function update(Request $request, $id)
    {
        $profile = CompanyProfile::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:50',
            'address' => 'nullable|string',
            'website' => 'nullable|url|max:255',
            'tagline' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'facebook' => 'nullable|url|max:255',
            'instagram' => 'nullable|url|max:255',
            'active' => 'nullable|boolean',
        ]);

        $profile->update(array_merge($request->only([
            'name',
            'email',
            'phone',
            'address',
            'website',
            'tagline',
            'description',
            'facebook',
            'instagram',
        ]), ['active' => $request->has('active')]));

        return redirect()->route('admin.company-profiles.index')->with('success', 'Company profile updated successfully.');
    }

    public function destroy($id)
    {
        $profile = CompanyProfile::findOrFail($id);
        $profile->delete();

        return redirect()->route('admin.company-profiles.index')->with('success', 'Company profile deleted successfully.');
    }
}
