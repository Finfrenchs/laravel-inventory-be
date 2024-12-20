<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CompanyController extends Controller
{
    /**
     * Show company information.
     */
    public function show()
    {
        $company = Company::first(); // because this single company

        return response()->json([
            'message' => 'Company information retrieved successfully',
            'company' => $company,
        ], 200);
    }

    /**
     * Edit Company Information.
     */
    public function update(Request $request)
    {

        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|nullable|string|email|max:255',
            'phone' => 'sometimes|nullable|string|max:20',
            'website' => 'sometimes|nullable|string|max:255',
            'logo' => 'sometimes|nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'address' => 'sometimes|nullable|string|max:255',
            'status' => 'sometimes|required|string|in:active,inactive',
            'total_users' => 'sometimes|required|integer|min:1',
            'clock_in_time' => 'sometimes|required|date_format:H:i:s',
            'clock_out_time' => 'sometimes|required|date_format:H:i:s',
            'early_clock_in_time' => 'sometimes|nullable|integer|min:0',
            'allow_clock_out_till' => 'sometimes|nullable|integer|min:0',
            'self_clocking' => 'sometimes|required|boolean',
        ]);

        // Ambil perusahaan pertama (karena ini single company)
        $company = Company::first();
        //$company = Company::where('id', 1)->first();

        // Handle upload logo baru jika ada
        if ($request->hasFile('logo')) {
            // Hapus logo lama jika ada
            if ($company->logo) {
                Storage::disk('public')->delete($company->logo);
            }

            $file = $request->file('logo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('logos', $filename, 'public');
            $validated['logo'] = $filePath;
        }

        // Update data perusahaan
        $company->update($validated);

        return response()->json([
            'message' => 'Company information updated successfully',
            'company' => $company,
        ], 200);
    }
}
