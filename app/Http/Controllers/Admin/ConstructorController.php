<?php

namespace App\Http\Controllers\Admin;

use App\City;
use App\Constructor;
use App\ConstAgency;
use App\ConstructorImage;
use App\ConstructorTranslation;
use App\Currency;
use App\Http\Controllers\Controller;
use App\Role;
use App\State;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class ConstructorController extends Controller
{

    public function index()
    {
        $constructors = Constructor::orderBy('id', 'desc')->paginate(20);

       return view('admin.constructor.index', compact('constructors'));
    }

    public function create()
    {
        $constructors = Constructor::all();
        $languages = config('translatable.locales');
        $currencies = Currency::all();
        $states = State::query()->with('cities')->get();
        $cities = City::where('state_id',$states[0]->id)->get();
        $constructor_agencies = Role::where('slug','super_broker')->first()->users()->get();
        return view('admin.constructor.create_constructor', compact('constructors', 'languages','currencies','constructor_agencies','states','cities'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'property_name_en' => 'required',
            'property_name_am' => 'required',
            'property_name_ru' => 'required',
            'property_description_am' => 'required',
            'property_description_ru' => 'required',
            'property_description_en' => 'required',
            'features_en' => 'required',
            'features_am' => 'required',
            'features_ru' => 'required',
            'price_start' => 'required|numeric',
            'available_apartments' => 'required|numeric',
            'apartment_counts' => 'required|numeric',
            'sold_apartments' => 'required|numeric',
            'reserved_apartments' => 'required|numeric',
            'start_date' => 'required',
            'end_date' => 'required',
            'max_room' => 'required',
            'min_room' => 'required',
            'floor_height' => 'required',
            'property_type'=>'required',
            'storeys' => 'required|numeric',
            'parking' => 'required|numeric',
            'available_parking' => 'required|numeric',
            'underground_parking' => 'required|numeric',
            'available_underground_parking' => 'required|numeric',
            'office_space' => 'required|numeric',
            'available_office_space' => 'required|numeric',
            'area' => 'required',
            'lot' => 'required|numeric',
            'latitude' => 'required',
            'longitude' => 'required',
            'currency'=> 'required',
            'constructor_agency'=>'required',
            'distance_from_school' => 'required',
            'distance_from_kindergarten' => 'required',
            'distance_from_supermarket' => 'required',
            'distance_from_pharmacy' => 'required',

        ]);

        $data = [
            'price_start' => $request->price_start,
            'price_end' => $request->price_end,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'floor_height' => $request->floor_height,
            'storeys' => (int)$request->storeys,
            'parking' => (int)$request->parking,
            'type' => $request->property_type,
            'min_room' => (float)$request->min_room,
            'max_room' =>(float) $request->max_room,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'area' => $request->area,
            'lot' => $request->lot,
            'property_type' => $request->lot,
            'available_apartments' => (int)$request->available_apartments,
            'apartment_counts' => (int)$request->apartment_counts,
            'sold_apartments' => (int)$request->sold_apartments,
            'reserved_apartments' => (int)$request->reserved_apartments,
            'available_parking' => (int)$request->available_parking,
            'underground_parking' => (int)$request->underground_parking,
            'available_underground_parking' => (int)$request->available_underground_parking,
            'office_space' => (int)$request->office_space,
            'available_office_space' => (int)$request->available_office_space,
            'currency_id'=> (int)$request->currency,
            'const_agency_id'=> (int)$request->constructor_agency,
            'city_id' => $request->city_id,
            'state_id' => $request->state_id,
            'live_video_url' => $request->live_video_url,
            'distance_from_school' => $request->distance_from_school,
            'distance_from_kindergarten' => $request->distance_from_kindergarten,
            'distance_from_supermarket' => $request->distance_from_supermarket,
            'distance_from_pharmacy' => $request->distance_from_pharmacy,
        ];
        if ($request->hasFile('main_image')) {
            $imagePath = $request->file('main_image');
            $imageName = time() . '_' . $imagePath->getClientOriginalName();
            $img = Image::make($request->file('main_image')->path());
            $img->resize(1028, 700)->insert(public_path('logo.png'), 'bottom-right', 10, 10)->save(storage_path().'/app/public/uploads/constructors/'.$imageName);
            $data['main_image']=$imageName;
        }
        foreach (config('translatable.locales') as $locale) {
            $data[$locale] = [
                'property_name' => $request->{'property_name_'. $locale},
                'sub_title' => $request->{'sub_title_'. $locale},
                'property_description' => $request->{'property_description_'. $locale},
                'address' => $request->{'address_'.$locale},
                'features' => $request->{'features_'.$locale},
                'renovation' => $request->{'renovation_'.$locale},
            ];
        }
        $constructor = Constructor::create($data);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $fileName = time() . '_' . $image->getClientOriginalName();
                $img = Image::make($image->path());
                $img->resize(1028,700)->insert(public_path('logo.png'), 'bottom-right', 10, 10)->save(storage_path().'/app/public/uploads/constructors/'.$fileName);
                ConstructorImage::create([
                    'constructor_id' => $constructor->id,
                    'name' => $fileName,
                ]);
            }
        }
        toastr()->success("Successfully Created");
        return redirect('/admin/constructors');
    }

    public function edit($id)
    {
        $constructor = Constructor::find($id);
        $currencies = Currency::all();
        $constructor_agencies = Role::where('slug','super_broker')->first()->users()->get();
        $states = State::query()->with('cities')->get();
        $state_id = $constructor->state_id;
        $cities = City::where('state_id',$state_id)->get();
        $languages = config('translatable.locales');
        return view('admin.constructor.edit_constructor', compact('constructor', 'languages','currencies','constructor_agencies','states','cities'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'property_name_en' => 'required',
            'property_name_am' => 'required',
            'property_name_ru' => 'required',
            'property_description_am' => 'required',
            'property_description_ru' => 'required',
            'property_description_en' => 'required',
            'features_en' => 'required',
            'features_am' => 'required',
            'features_ru' => 'required',
            'price_start' => 'required|numeric',
            'available_apartments' => 'required|numeric',
            'apartment_counts' => 'required|numeric',
            'sold_apartments' => 'required|numeric',
            'reserved_apartments' => 'required|numeric',
            'start_date' => 'required',
            'end_date' => 'required',
            'max_room' => 'required',
            'min_room' => 'required',
            'floor_height' => 'required',
            'property_type'=>'required',
            'storeys' => 'required|numeric',
            'parking' => 'required|numeric',
            'available_parking' => 'required|numeric',
            'underground_parking' => 'required|numeric',
            'available_underground_parking' => 'required|numeric',
            'office_space' => 'required|numeric',
            'available_office_space' => 'required|numeric',
            'area' => 'required',
            'lot' => 'required|numeric',
            'latitude' => 'required',
            'longitude' => 'required',
            'currency'=> 'required',
            'constructor_agency'=>'required',
            'distance_from_school' => 'required',
            'distance_from_kindergarten' => 'required',
            'distance_from_supermarket' => 'required',
            'distance_from_pharmacy' => 'required',
        ]);

        $data = [
            'price_start' => $request->price_start,
            'price_end' => $request->price_end,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'floor_height' => $request->floor_height,
            'storeys' => (int)$request->storeys,
            'parking' => (int)$request->parking,
            'type' => $request->property_type,
            'min_room' => (float)$request->min_room,
            'max_room' =>(float) $request->max_room,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'area' => $request->area,
            'lot' => $request->lot,
            'property_type' => $request->lot,
            'available_apartments' => (int)$request->available_apartments,
            'apartment_counts' => (int)$request->apartment_counts,
            'sold_apartments' => (int)$request->sold_apartments,
            'reserved_apartments' => (int)$request->reserved_apartments,
            'available_parking' => (int)$request->available_parking,
            'underground_parking' => (int)$request->underground_parking,
            'available_underground_parking' => (int)$request->available_underground_parking,
            'office_space' => (int)$request->office_space,
            'available_office_space' => (int)$request->available_office_space,
            'currency_id'=> (int)$request->currency,
            'const_agency_id'=> (int)$request->constructor_agency,
            'city_id' => $request->city_id,
            'state_id' => $request->state_id,
            'live_video_url' => $request->live_video_url,
            'distance_from_school' => $request->distance_from_school,
            'distance_from_kindergarten' => $request->distance_from_kindergarten,
            'distance_from_supermarket' => $request->distance_from_supermarket,
            'distance_from_pharmacy' => $request->distance_from_pharmacy,

        ];

        foreach (config('translatable.locales') as $locale) {
            $data[$locale] = [
                'property_name' => $request->{'property_name_'. $locale},
                'sub_title' => $request->{'sub_title_'. $locale},
                'property_description' => $request->{'property_description_'. $locale},
                'address' => $request->{'address_'.$locale},
                'features' => $request->{'features_'.$locale},
                'renovation' => $request->{'renovation_'.$locale},
            ];
        }

        if ($request->hasFile('main_image')) {
            $imagePath = $request->file('main_image');
            $imageName = time() . '_' . $imagePath->getClientOriginalName();
            $img = Image::make($request->file('main_image')->path());
            $img->resize(1028,700)->insert(public_path('logo.png'), 'bottom-right', 10, 10)->save(storage_path().'/app/public/uploads/constructors/'.$imageName);
            $data['main_image']=$imageName;
        }

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $fileName = time() . '_' . $image->getClientOriginalName();
                $img = Image::make($image->path());
                $img->resize(1028,700)->insert(public_path('logo.png'), 'bottom-right', 10, 10)->save(storage_path().'/app/public/uploads/constructors/'.$fileName);
                ConstructorImage::create([
                    'constructor_id' => $id,
                    'name' => $fileName,
                ]);
            }
        }
        $constructor = Constructor::findOrFail($id);
        $constructor->update($data);

        toastr()->success("Constructor Updated!");

        return redirect('/admin/constructors');
    }


    public function destroy($id)
    {
        if ($constructor = Constructor::findOrFail($id)){
            $constructor_images = ConstructorImage::query()->where('constructor_id',$constructor->id)->get();
            foreach($constructor_images as $i){
                Storage::disk('public')->delete('uploads/constructors/'.$i->name);
            }
            Storage::disk('public')->delete('uploads/constructors/'.$constructor->main_image);
            $constructor->delete();
            toastr()->success("Constructor deleted!");
            return redirect('/admin/constructors');
        }else{
            toastr()->error("Something went wrong!");
        }
    }

    public function removeImage(Request $request)
    {
        if ($request->type && $request->type == 'main_image') {
            if (Constructor::where('id', $request->id)->update(['main_image' => null])) {
                Storage::disk('public')->delete('uploads/constructors/'.$request->image);
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
        } else {
            if (ConstructorImage::where('id', $request->id)->delete()) {
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
    }

    public function floor($id,$type)
    {
        $constructor = ConstructorTranslation::find($id);
        $languages = config('translatable.locales');
        return view('admin.constructor.floors', compact('constructor', 'languages','type'));
    }

    public function savePlans(Request $request){
        if(ConstructorTranslation::where("id", $request->id)->update(["plans" => $request->plans,'plans_id'=>$request->plans_id])){
            return response()->json([
                'alert' => 'success',
                'message' => 'Saved!',
            ]);
        }
    }
    public function saveFloors(Request $request){
       if(ConstructorTranslation::where("id", $request->id)->update(["floors" => $request->plans,'floors_id'=>$request->plans_id])){
           return response()->json([
               'alert' => 'success',
               'message' => 'Saved!',
           ]);
       }
    }

    public function saveImage(Request $request){

        $image = $request->file;  // your base64 encoded
        $image = str_replace('data:image/png;base64,', '', $image);
        $image = str_replace(' ', '+', $image);
        $imageName = time().'.'.'png';

        if ($request->id){
            $imageName = $request->id;
        }
        $appURL = "https://business.1sq.realty";

        $img = Image::make(base64_decode($image));
        $img->resize(1028, 700)->insert(public_path('logo.png'), 'bottom-right', 10, 10)->save(storage_path().'/app/public/uploads/constructors/'.$imageName);
        return response()->json([
            'alert' => 'success',
            'message' => $imageName,
            'appURL' => $appURL,
        ]);
    }
    public function deleteImage(Request $request){

        Storage::delete('public/uploads/constructors/'.$request->id . '.jpg');
        return response()->json([
            'alert' => 'success',
        ]);
    }
}

