<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\CreditCompany;
use Illuminate\Support\Facades\Storage;

class CreditCompanyController extends Controller
{

    public function index()
    {
        $companies = CreditCompany::paginate(10);
        return view('admin.credit_company.index', compact('companies'));
    }

    public function create()
    {
        $companies = CreditCompany::all();
        $languages = config('translatable.locales');
        return view('admin.credit_company.create_company', compact('companies', 'languages'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name_am' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
            'name_ru' => 'required|string|max:255',
            'address_am' => 'required|string|max:255',
            'address_en' => 'required|string|max:255',
            'address_ru' => 'required|string|max:255',
            'description_am' => 'required|string|max:255',
            'description_en' => 'required|string|max:255',
            'description_ru' => 'required|string|max:255',
            'image' => 'mimes:png,jpg,jpeg|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image');
            $imageName = time() . '_' . $imagePath->getClientOriginalName();
            $request->file('image')->storeAs('uploads/companies', $imageName, 'public');
        } else {
            $imageName = null;
        }

        $data = [
            'image' => $imageName,
            'phone' => $request->input('phone'),
            'whatsapp' => $request->input('whatsapp'),
            'viber' => $request->input('viber'),
        ];

        foreach (config('translatable.locales') as $locale) {
            $data[$locale] = [
                'name' => $request->{'name_' . $locale},
                'description' => $request->{'description_' . $locale},
                'address' => $request->{'address_' . $locale}
            ];
        }

        CreditCompany::create($data);

        toastr()->success("Company saved!");

        return redirect('/admin/credit_companies');
    }


    public function edit($id)
    {
        $company = CreditCompany::find($id);
        $languages = config('translatable.locales');
        return view('admin.credit_company.edit_company', compact('company', 'languages'));
    }

    public function update(Request $request, $id)
    {

        $request->validate([
            'name_am' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
            'name_ru' => 'required|string|max:255',
            'address_am' => 'required|string|max:255',
            'address_en' => 'required|string|max:255',
            'address_ru' => 'required|string|max:255',
            'description_am' => 'required|string|max:255',
            'description_en' => 'required|string|max:255',
            'description_ru' => 'required|string|max:255',
        ]);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image');
            $imageName = time() . '_' . $imagePath->getClientOriginalName();
            $request->file('image')->storeAs('uploads/companies', $imageName, 'public');
        } else {
            $imageName = $request->old_image;
        }
        $data = [
            'image' => $imageName,
            'phone' => $request->input('phone'),
            'whatsapp' => $request->input('whatsapp'),
            'viber' => $request->input('viber'),
        ];


        foreach (config('translatable.locales') as $locale) {
            $data[$locale] = [
                'name' => $request->{'name_' . $locale},
                'address' => $request->{'address_' . $locale},
                'description' => $request->{'description_' . $locale}
            ];
        }

        $company = CreditCompany::findOrFail($id);
        $company->update($data);

        toastr()->success("Company Updated!");

        return redirect('/admin/credit_companies');
    }

    public function removeImage(Request $request)
    {
        if (CreditCompany::where('id', $request->id)->update(['image' => null])) {
            Storage::disk('public')->delete('uploads/companies/'.$request->image);
            return response()->json([
                'alert' => 'success',
                'message' => 'Deleted!',
            ]);
        } else {
            return response()->json([
                'alert' => 'error',
                'message' => 'Something went wrong please try again!',
            ]);
        }
    }

    public function destroy($id)
    {
        $company = CreditCompany::findOrFail($id);
        Storage::disk('public')->delete('uploads/companies/'.$company->image);
        $company->delete();

        toastr()->success("Company deleted!");

        return redirect('/admin/credit_companies');
    }
}
