<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CompanyProfile;
use Illuminate\Http\Request;

class CompanyProfileController extends Controller
{
    public function index()
    {
        $profile = CompanyProfile::first();
        return view('admin.company_profiles.index', compact('profile'));
    }

    public function create()
    {
        if ($profile = CompanyProfile::first()) {
            return redirect()->route('admin.company-profiles.edit', $profile->id)
                ->with('info', 'A company profile already exists. You can update it here.');
        }

        return view('admin.company_profiles.create');
    }

    public function store(Request $request)
    {
        if (CompanyProfile::exists()) {
            return redirect()->route('admin.company-profiles.index')->with('info', 'A company profile already exists. You can update it instead.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'owner_name' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:50',
            'mobile_number' => 'nullable|string|max:50',
            'address' => 'nullable|string',
            'website' => 'nullable|url|max:255',
            'tagline' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'company_logo' => 'nullable|image|mimes:jpeg,png,jpg,svg,ico|max:2048',
            'favicon_icon' => 'nullable|image|mimes:jpeg,png,jpg,svg,ico|max:2048',
            'facebook' => 'nullable|url|max:255',
            'instagram' => 'nullable|url|max:255',
            'dhaka_delivery_charge' => 'nullable|integer|min:0',
            'outside_dhaka_delivery_charge' => 'nullable|integer|min:0',
            'default_courier_provider' => 'nullable|string|max:100',
            'courier_settings' => 'nullable|array',
            'active' => 'nullable',
        ]);

        $data = $request->only([
            'name',
            'owner_name',
            'email',
            'phone',
            'mobile_number',
            'address',
            'website',
            'tagline',
            'description',
            'facebook',
            'instagram',
            'dhaka_delivery_charge',
            'outside_dhaka_delivery_charge',
            'default_courier_provider',
        ]);

        $data['courier_settings'] = $request->input('courier_settings', []);

        if ($request->hasFile('company_logo')) {
            $data['company_logo'] = $request->file('company_logo')->store('company_profiles', 'public');
        }

        if ($request->hasFile('favicon_icon')) {
            $data['favicon_icon'] = $request->file('favicon_icon')->store('company_profiles', 'public');
        }

        CompanyProfile::create(array_merge($data, ['active' => $request->has('active')]));

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
            'owner_name' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:50',
            'mobile_number' => 'nullable|string|max:50',
            'address' => 'nullable|string',
            'website' => 'nullable|url|max:255',
            'tagline' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'company_logo' => 'nullable|image|mimes:jpeg,png,jpg,svg,ico|max:2048',
            'favicon_icon' => 'nullable|image|mimes:jpeg,png,jpg,svg,ico|max:2048',
            'facebook' => 'nullable|url|max:255',
            'instagram' => 'nullable|url|max:255',
            'dhaka_delivery_charge' => 'nullable|integer|min:0',
            'outside_dhaka_delivery_charge' => 'nullable|integer|min:0',
            'default_courier_provider' => 'nullable|string|max:100',
            'courier_settings' => 'nullable|array',
            'active' => 'nullable',
        ]);

        $data = $request->only([
            'name',
            'owner_name',
            'email',
            'phone',
            'mobile_number',
            'address',
            'website',
            'tagline',
            'description',
            'facebook',
            'instagram',
            'dhaka_delivery_charge',
            'outside_dhaka_delivery_charge',
            'default_courier_provider',
        ]);

        $data['courier_settings'] = $request->input('courier_settings', []);

        if ($request->hasFile('company_logo')) {
            $data['company_logo'] = $request->file('company_logo')->store('company_profiles', 'public');
        }

        if ($request->hasFile('favicon_icon')) {
            $data['favicon_icon'] = $request->file('favicon_icon')->store('company_profiles', 'public');
        }

        $profile->update(array_merge($data, ['active' => $request->has('active')]));

        return redirect()->route('admin.company-profiles.index')->with('success', 'Company profile updated successfully.');
    }

    public function destroy($id)
    {
        $profile = CompanyProfile::findOrFail($id);
        $profile->delete();

        return redirect()->route('admin.company-profiles.index')->with('success', 'Company profile deleted successfully.');
    }
}
