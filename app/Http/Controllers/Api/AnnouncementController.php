<?php

namespace App\Http\Controllers\Api;

use App\AdditionalInfo;
use App\Announcement;
use App\AnnouncementImage;
use App\City;
use App\Currency;
use App\Facility;
use App\Favorite;
use App\Http\Controllers\Controller;
use App\Type;
use App\State;
use App\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class AnnouncementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $query = Announcement::where('verify', 1);
        if ($request->input('data.place')) {
            $place = explode(",", $request->input('data.place'));
            if (count($place) > 1) {
                $query->where('state_id', (int)$place[0]);
                $query->where('city_id', (int)$place[1]);

            } else {
                $query->where('state_id', (int)$place[0]);
            }
        }
        $announcements = $query->orderBy('updated_at','DESC')->get();
        return response()->json(compact('announcements'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function similar(Request $request)
    {
        $announcements = Announcement::find($request->id);
        $arr = [
            ['verify', 1],
            ['category_id', $announcements->category_id],
            ['type_id', $announcements->type_id],
            ['state_id', $announcements->state_id],
            ['id', '!=', $announcements->id],
            ['price', '>=', $announcements->price - 10000],
            ['price', '<', $announcements->price + 10000],
        ];
        $announcements = Announcement::query()->where($arr)->with('category','currency')->paginate(6);
        return response()->json(compact('announcements'));
    }

    public function pricFormat($string)
    {
        return (int)preg_replace('/[^0-9]/', '', $string);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(Request $request)
    {
        $errors = [];
        $type = Type::find((int)$request->input('data.type'));
        $user = User::where('id', $request->input('data.user_id'))->first();
        if ($user->announcements_limit === 5) {
            return response()->json(['status' => 402, 'message' => 'limit_error']);
        }
        $validator = Validator::make($request->all(), [
            'data.price' => 'required',
            'data.address' => 'required|string|max:255',
            'data.area' => 'required|numeric',
            'data.sewer' => 'required',
            'data.distance_from_metro_station' => 'required',
            'data.distance_from_medical_center' => 'required',
            'data.distance_from_stations' => 'required',
            'data.agree' => 'required',
            'data.currency' => 'required',
        ]);
        if ($type->slug === 'land') {
            $validatorLand = Validator::make($request->all(), [
                'data.land_geometric' => 'required|string|max:255',
                'data.purpose' => 'required',
                'data.front_position' => 'required',
                'data.front_position_length' => 'required',
                'data.road_type' => 'required',
                'data.fence_type' => 'required',
                'data.infrastructure' => 'required',
                'data.building' => 'required',
            ]);
            if ($validatorLand->fails()) {
                array_push($errors, $validatorLand->messages());
            }
        } elseif ($type->slug === 'house') {
            $validatorHouse = Validator::make($request->all(), [
                'data.bedrooms' => 'required',
                'data.bathrooms' => 'required',
                'data.ceiling_height' => 'required',
                'data.balcony' => 'required',
                'data.cover' => 'required',
                'data.condition' => 'required',
                'data.building_type' => 'required',
                'data.storeys' => 'required|string|max:255',
                'data.furniture' => 'required',
                'data.year' => 'required',
                'data.degree' => 'required',
            ]);
            if ($validatorHouse->fails()) {
                array_push($errors, $validatorHouse->messages());
            }
        } elseif ($type->slug === 'apartment') {
            $validatorAppartment = Validator::make($request->all(), [
                'data.bedrooms' => 'required',
                'data.bathrooms' => 'required',
                'data.ceiling_height' => 'required',
                'data.balcony' => 'required',
                'data.cover' => 'required',
                'data.condition' => 'required',
                'data.building_type' => 'required',
                'data.floor' => 'required|string|max:255',
                'data.storeys' => 'required|string|max:255',
                'data.furniture' => 'required',
                'data.year' => 'required',
                'data.degree' => 'required',
                'data.condominium' => 'required',
            ]);
            if ($validatorAppartment->fails()) {
                array_push($errors, $validatorAppartment->messages());
            }
        } elseif ($type->slug === 'commercial') {
            $validatorCommercial = Validator::make($request->all(), [
                'data.bathrooms' => 'required',
                'data.ceiling_height' => 'required',
                'data.cover' => 'required',
                'data.condition' => 'required',
                'data.building_type' => 'required',
                'data.floor' => 'required|string|max:255',
                'data.storeys' => 'required|string|max:255',
                'data.furniture' => 'required',
                'data.land_type' => 'required',
                'data.property_place' => 'required',
                'data.year' => 'required',
                'data.degree' => 'required',
                'data.condominium' => 'required',
            ]);
            if ($validatorCommercial->fails()) {
                array_push($errors, $validatorCommercial->messages());
            }
        }
        if ($validator->fails()) {
            array_push($errors, $validator->messages());
            return response()->json(['status' => 400, 'message' => $errors]);
        }
        $addInfo = json_encode($request->input('additionalInformation'));
        $fac = json_encode($request->input('facilitiesaInformation'));
        $price = 0;
        if($request->price){
            $currency = Currency::find((int) $request->input('data.currency'));
            $price = $request->price / $currency->value;

        }else{
            $price = ($request->input('data.price') * 91)/100;
        }

        $data = [
            'price' => $this->pricFormat($request->input('data.price')),
            'address' => $request->input('data.address'),
            'cover' => $request->input('data.cover'),
            'floor' => (int)$request->input('data.floor'),
            'storeys' => (int)$request->input('data.storeys'),
            'area' => $request->input('data.area'),
            'land_area' => $request->input('data.land_area'),
            'land_type' => $request->input('data.land_type'),
            'property_place' => $request->input('data.property_place'),
            'sewer' => $request->input('data.sewer'),
            'distance_from_metro_station' => $request->input('data.distance_from_metro_station'),
            'distance_from_medical_center' => $request->input('data.distance_from_medical_center'),
            'distance_from_stations' => $request->input('data.distance_from_stations'),
            'infrastructure' => $request->input('data.infrastructure'),
            'fence_type' => $request->input('data.fence_type'),
            'road_type' => $request->input('data.road_type'),
            'front_position' => $request->input('data.front_position'),
            'front_position_length' => $request->input('data.front_position_length'),
            'land_geometric_appearance' => $request->input('data.land_geometric'),
            'rooms' => (int)$request->input('data.bedrooms'),
            'bathroom' => (int)$request->input('data.bathrooms'),
            'building_type' => $request->input('data.building_type'),
            'ceiling_height' => $request->input('data.ceiling_height'),
            'condition' => $request->input('data.condition'),
            'condominium' => $request->input('data.condominium'),
            'purpose' => $request->input('data.purpose'),
            'additional_infos' => $addInfo,
            'facilities' => $fac,
            'latitude' => $request->input('data.latitude'),
            'longitude' => $request->input('data.longitude'),
            'category_id' => (int)$request->input('data.category'),
            'type_id' => (int)$request->input('data.type'),
            'user_id' => (int)$request->input('data.user_id'),
            'description' => $request->input('data.description'),
            'balcony' => $request->input('data.balcony'),
            'furniture' => $request->input('data.furniture'),
            'rent_type' => $request->input('data.rent_type'),
            'building_number' => $request->input('data.building_number'),
            'building' => $request->input('data.building'),
            'year' => $request->input('data.year'),
            'degree' => $request->input('data.degree'),
            'city' => $request->input('data.city'),
            'city_id' => $request->input('data.city_id'),
            'state' => $request->input('data.state'),
            'state_id' => $request->input('data.region_id'),
            'currency_id' => $request->input('data.currency'),
            'zestimate' => $price
        ];
        if ($request->input('data.agent_id') === "broker") {
            $data['free'] = 1;
            $data['verify'] = 5;
        }elseif ($request->input('data.agent_id') === "agency"){
            $data['free'] = 2;
            $data['verify'] = 5;
        }else{
            $data['broker_id'] = $request->input('data.agent_id');
            $data['verify'] = 6;
        }
        $data['average_value'] = $this->averageValue($type->id ,$request->input('data.category'), $request->input('data.city_id'), $request->input('data.building_type'), $request->input('data.degree'), $request->input('data.cover'), $request->input('data.area'));
        $announcement = Announcement::create($data);
        $images = $request->input('files');
        if ($request->input('data.certificate')) {
            $certificate = $request->input('data.certificate');
            $image_parts_certif = explode(";base64,", $certificate[0]['data_url']);
            $image_type_aux_certif = explode("image/", $image_parts_certif[0]);
            $image_type_certif = $image_type_aux_certif[1];
            $certificateImage = base64_decode($image_parts_certif[1]);
            $file_certif = uniqid() . '.' . $image_type_certif;
            $img = Image::make($certificateImage);
            $img->resize(1024, 720)->insert(public_path('logo.png'), 'bottom-right', 10, 10)->save(storage_path() . '/app/public/uploads/announcements/' . $file_certif);

            $certificatePath = $file_certif;
        } else {
            $certificatePath = null;
        }
        $i = 0;
        $mainImage = [];
        foreach ($images as $image) {
            $image_parts = explode(";base64,", $image['data_url']);
            $image_type_aux = explode("image/", $image_parts[0]);
            $image_type = $image_type_aux[1];
            $oneImage = base64_decode($image_parts[1]);
            $file = uniqid() . '.' . $image_type;
            $img = Image::make($oneImage);
            $img->resize(1024, 720)->insert(public_path('logo.png'), 'bottom-right', 10, 10)->save(storage_path() . '/app/public/uploads/announcements/' . $file);
            if (!$i) {
                $i++;
                if ($certificatePath) {
                    $mainImage = [
                        'main_image' => $file,
                        'certificate' => $certificatePath
                    ];
                } else {
                    $mainImage = [
                        'main_image' => $file,
                    ];
                }
            } else {
                AnnouncementImage::create([
                    'announcement_id' => $announcement->id,
                    'name' => $file,
                ]);
            }
        }
        $user->update(['announcements_limit' => ++$user->announcements_limit]);
        $announcement->update($mainImage);
        return response()->json(['status' => 200, 'announcement' => $announcement]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function createHouse(Request $request)
    {
        $errors = [];
        $validator = Validator::make($request->all(), [
            'data.price' => 'required',
            'data.address' => 'required|string',
            'data.area' => 'required|numeric',
            'data.sewer' => 'required',
            'data.distance_from_metro_station' => 'required',
            'data.distance_from_medical_center' => 'required',
            'data.distance_from_stations' => 'required',
            'data.agree' => 'required',
            'data.recaptcha' => 'required',
            'data.currency' => 'required',
            'data.land_area' => 'required',
            'data.bedrooms' => 'required',
            'data.bathrooms' => 'required',
            'data.ceiling_height' => 'required',
            'data.balcony' => 'required',
            'data.cover' => 'required',
            'data.condition' => 'required',
            'data.building_type' => 'required',
            'data.storeys' => 'required|string|max:255',
            'data.furniture' => 'required',
            'data.year' => 'required',
            'data.degree' => 'required',
        ]);
        if ($validator->fails()) {
            array_push($errors, $validator->messages());
        }
        $addInfo = json_encode($request->input('additionalInformation'));
        $fac = json_encode($request->input('facilitiesaInformation'));
        $data = [
            'price' => $this->pricFormat($request->input('data.price')),
            'address' => $request->input('data.address'),
            'cover' => $request->input('data.cover'),
            'floor' => (int)$request->input('data.floor'),
            'storeys' => (int)$request->input('data.storeys'),
            'area' => $request->input('data.area'),
            'condominium' => $request->input('data.condominium'),
            'land_area' => $request->input('data.land_area'),
            'land_type' => $request->input('data.land_type'),
            'property_place' => $request->input('data.property_place'),
            'sewer' => $request->input('data.sewer'),
            'distance_from_metro_station' => $request->input('data.distance_from_metro_station'),
            'distance_from_medical_center' => $request->input('data.distance_from_medical_center'),
            'distance_from_stations' => $request->input('data.distance_from_stations'),
            'infrastructure' => $request->input('data.infrastructure'),
            'fence_type' => $request->input('data.fence_type'),
            'road_type' => $request->input('data.road_type'),
            'front_position' => $request->input('data.front_position'),
            'front_position_length' => $request->input('data.front_position_length'),
            'land_geometric_appearance' => $request->input('data.land_geometric'),
            'rooms' => (int)$request->input('data.bedrooms'),
            'bathroom' => (int)$request->input('data.bathrooms'),
            'building_type' => $request->input('data.building_type'),
            'ceiling_height' => $request->input('data.ceiling_height'),
            'condition' => $request->input('data.condition'),
            'purpose' => $request->input('data.purpose'),
            'additional_infos' => $addInfo,
            'facilities' => $fac,
            'latitude' => $request->input('data.latitude'),
            'longitude' => $request->input('data.longitude'),
            'category_id' => (int)$request->input('data.category'),
            'type_id' => (int)$request->input('data.type'),
            'user_id' => (int)$request->input('data.user_id'),
            'description' => $request->input('data.description'),
            'balcony' => $request->input('data.balcony'),
            'furniture' => $request->input('data.furniture'),
            'rent_type' => $request->input('data.rent_type'),
            'building_number' => $request->input('data.building_number'),
            'building' => $request->input('data.building'),
            'year' => $request->input('data.year'),
            'degree' => $request->input('data.degree'),
            'city' => $request->input('data.city'),
            'city_id' => $request->input('data.city_id'),
            'state' => $request->input('data.state'),
            'state_id' => $request->input('data.region_id'),
            'currency_id' => $request->input('data.currency'),
            'zestimate' => $request->price || (($request->input('data.price') * 91)/100),
        ];

        $announcement = Announcement::create($data);
        $images = $request->input('files');
        $folderPath = "uploads/announcements/";

        if ($request->input('data.certificate')) {
            $certificate = $request->input('data.certificate');
            $image_parts_certif = explode(";base64,", $certificate[0]['data_url']);
            $image_type_aux_certif = explode("image/", $image_parts_certif[0]);
            $image_type_certif = $image_type_aux_certif[1];
            $certificateImage = base64_decode($image_parts_certif[1]);
            $file_certif = uniqid() . '.' . $image_type_certif;
            $img = Image::make($certificateImage);
            $img->resize(1024, 720)->insert(public_path('logo.png'), 'bottom-right', 10, 10)->save(storage_path() . '/app/public/uploads/announcements/' . $file_certif);
            $certificatePath = $file_certif;
        }
        $i = 0;
        $mainImage = [];
        foreach ($images as $image) {
            $image_parts = explode(";base64,", $image['data_url']);
            $image_type_aux = explode("image/", $image_parts[0]);
            $image_type = $image_type_aux[1];
            $oneImage = base64_decode($image_parts[1]);
            $file = uniqid() . '.' . $image_type;
            $img = Image::make($oneImage);
            $img->resize(1024, 720)->insert(public_path('logo.png'), 'bottom-right', 10, 10)->save(storage_path() . '/app/public/uploads/announcements/' . $file);

            if (!$i) {
                $i++;
                if ($certificatePath) {
                    $mainImage = [
                        'main_image' => $file,
                        'certificate' => $certificatePath
                    ];
                } else {
                    $mainImage = [
                        'main_image' => $file,
                    ];
                }

            } else {
                AnnouncementImage::create([
                    'announcement_id' => $announcement->id,
                    'name' => $file,
                ]);
            }
        }
        $announcement->update($mainImage);
        return response()->json(['status' => 200, 'announcement' => $announcement]);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function announcement(Request $request)
    {
        $announcement = Announcement::where('id', $request->id)->with('announcementImages', 'category', 'broker', 'currency', 'user')->first();
        $user = "";
        if($announcement->broker_id){
            $user = User::where('id', $announcement->broker_id)->with('roles')->first();
        }else{
            $user = User::where('id', $announcement->user_id)->with('roles')->first();
        }
        $state = State::where('id', $announcement->state_id)->with('cities')->first();
        $currencies = Currency::all();
        return response()->json(compact('announcement', 'state', 'currencies', 'user'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit(Request $request)
    {

        $errors = [];
        $type = Type::find((int)$request->input('data.type'));
        $validator = Validator::make($request->all(), [
            'data.price' => 'required',
            'data.address' => 'required|string|max:255',
            'data.area' => 'required|numeric',
            'data.sewer' => 'required',
            'data.distance_from_metro_station' => 'required',
            'data.distance_from_medical_center' => 'required',
            'data.distance_from_stations' => 'required',
            'data.currency' => 'required',
        ]);
        if ($type->slug === 'land') {
            $validatorLand = Validator::make($request->all(), [
                'data.land_geometric' => 'required|string|max:255',
                'data.purpose' => 'required',
                'data.front_position' => 'required',
                'data.front_position_length' => 'required',
                'data.road_type' => 'required',
                'data.fence_type' => 'required',
                'data.infrastructure' => 'required',
                'data.building' => 'required',
            ]);
            if ($validatorLand->fails()) {
                array_push($errors, $validatorLand->messages());
            }
        } elseif ($type->slug === 'house') {
            $validatorHouse = Validator::make($request->all(), [
                'data.bedrooms' => 'required',
                'data.bathrooms' => 'required',
                'data.ceiling_height' => 'required',
                'data.balcony' => 'required',
                'data.cover' => 'required',
                'data.condition' => 'required',
                'data.building_type' => 'required',
                'data.storeys' => 'required|string|max:255',
                'data.furniture' => 'required',
                'data.year' => 'required',
                'data.condominium' => 'required',
            ]);
            if ($validatorHouse->fails()) {
                array_push($errors, $validatorHouse->messages());
            }
        } elseif ($type->slug === 'apartment') {
            $validatorAppartment = Validator::make($request->all(), [
                'data.bedrooms' => 'required',
                'data.bathrooms' => 'required',
                'data.ceiling_height' => 'required',
                'data.balcony' => 'required',
                'data.cover' => 'required',
                'data.condition' => 'required',
                'data.building_type' => 'required',
                'data.floor' => 'required|string|max:255',
                'data.storeys' => 'required|string|max:255',
                'data.furniture' => 'required',
                'data.year' => 'required',
            ]);
            if ($validatorAppartment->fails()) {
                array_push($errors, $validatorAppartment->messages());
            }
        } elseif ($type->slug === 'commercial') {
            $validatorCommercial = Validator::make($request->all(), [
                'data.bathrooms' => 'required',
                'data.ceiling_height' => 'required',
                'data.cover' => 'required',
                'data.condition' => 'required',
                'data.building_type' => 'required',
                'data.floor' => 'required|string|max:255',
                'data.storeys' => 'required|string|max:255',
                'data.furniture' => 'required',
                'data.land_type' => 'required',
                'data.property_place' => 'required',
                'data.condominium' => 'required',
            ]);
            if ($validatorCommercial->fails()) {
                array_push($errors, $validatorCommercial->messages());
            }
        }
        if ($validator->fails()) {
            array_push($errors, $validator->messages());
            return response()->json(['status' => 400, 'message' => $errors]);
        }
        $addInfo = json_encode($request->input('additionalInformation'));
        $fac = json_encode($request->input('facilitiesaInformation'));
        $data = [
            'price' => $this->pricFormat($request->input('data.price')),
            'address' => $request->input('data.address'),
            'cover' => $request->input('data.cover'),
            'floor' => (int)$request->input('data.floor'),
            'storeys' => (int)$request->input('data.storeys'),
            'area' => $request->input('data.area'),
            'land_area' => $request->input('data.land_area'),
            'land_type' => $request->input('data.land_type'),
            'property_place' => $request->input('data.property_place'),
            'check_broker' => $request->input('data.check_broker'),
            'sewer' => $request->input('data.sewer'),
            'distance_from_metro_station' => $request->input('data.distance_from_metro_station'),
            'distance_from_medical_center' => $request->input('data.distance_from_medical_center'),
            'distance_from_stations' => $request->input('data.distance_from_stations'),
            'infrastructure' => $request->input('data.infrastructure'),
            'fence_type' => $request->input('data.fence_type'),
            'road_type' => $request->input('data.road_type'),
            'front_position' => $request->input('data.front_position'),
            'front_position_length' => $request->input('data.front_position_length'),
            'land_geometric_appearance' => $request->input('data.land_geometric'),
            'rooms' => (int)$request->input('data.bedrooms'),
            'bathroom' => (int)$request->input('data.bathrooms'),
            'building_type' => $request->input('data.building_type'),
            'ceiling_height' => $request->input('data.ceiling_height'),
            'condition' => $request->input('data.condition'),
            'purpose' => $request->input('data.purpose'),
            'condominium' => $request->input('data.condominium'),
            'additional_infos' => $addInfo,
            'facilities' => $fac,
            'latitude' => $request->input('data.latitude'),
            'longitude' => $request->input('data.longitude'),
            'description' => $request->input('data.description'),
            'balcony' => $request->input('data.balcony'),
            'furniture' => $request->input('data.furniture'),
            'rent_type' => $request->input('data.rent_type'),
            'building_number' => $request->input('data.building_number'),
            'building' => $request->input('data.building'),
            'degree' => $request->input('data.degree'),
            'year' => $request->input('data.year'),
            'city' => $request->input('data.city'),
            'city_id' => $request->input('data.city_id'),
            'state' => $request->input('data.state'),
            'state_id' => $request->input('data.region_id'),
            'currency_id' => $request->input('data.currency'),
            'zestimate' => $request->price || (($request->input('data.price') * 91)/100),
        ];
        if ($request->input('data.check_agent') === "1") {
            $data['free'] = 1;
        }
        $announcement = Announcement::where('id', $request->input('data.id'))->first();
        $images = $request->input('files');
        $certificatePath = null;
        if ($request->input('data.certificate')) {
            $certificate = $request->input('data.certificate');
            $image_parts_certif = explode(";base64,", $certificate[0]['data_url']);
            $image_type_aux_certif = explode("image/", $image_parts_certif[0]);
            $image_type_certif = $image_type_aux_certif[1];
            $file_certif = uniqid() . '.' . $image_type_certif;
            $certificateImage = base64_decode($image_parts_certif[1]);
            $img = Image::make($certificateImage);
            $img->resize(1024, 720)->insert(public_path('logo.png'), 'bottom-right', 10, 10)->save(storage_path() . '/app/public/uploads/announcements/' . $file_certif);

            $certificatePath = $file_certif;
        }
        $main_imagePath = null;
        if ($request->input('data.main_image')) {
            $main_image = $request->input('data.main_image');
            $image_parts_certif = explode(";base64,", $main_image[0]['data_url']);
            $image = base64_decode($image_parts_certif[1]);
            $image_type_aux_certif = explode("image/", $image_parts_certif[0]);
            $image_type_certif = $image_type_aux_certif[1];
            $file_certif = uniqid() . '.' . $image_type_certif;
            $img = Image::make($image);
            $img->resize(1024, 720)->insert(public_path('logo.png'), 'bottom-right', 10, 10)->save(storage_path() . '/app/public/uploads/announcements/' . $file_certif);
            $main_imagePath = $file_certif;
        }
        if ($certificatePath) {
            $data = [
                'certificate' => $certificatePath
            ];
        }
        if ($main_imagePath) {
            $data = [
                'main_image' => $main_imagePath
            ];
        }
        $data['average_value'] = $this->averageValue($type->id ,$request->input('data.category'), $request->input('data.city_id'), $request->input('data.building_type'), $request->input('data.degree'), $request->input('data.cover'), $request->input('data.area'));
        foreach ($images as $image) {
            $image_parts = explode(";base64,", $image['data_url']);
            $image_type_aux = explode("image/", $image_parts[0]);
            $image_type = $image_type_aux[1];
            $oneImage = base64_decode($image_parts[1]);
            $file = uniqid() . '.' . $image_type;
            $img = Image::make($oneImage);
            $img->resize(1024, 720)->insert(public_path('logo.png'), 'bottom-right', 10, 10)->save(storage_path() . '/app/public/uploads/announcements/' . $file);

            AnnouncementImage::create([
                'announcement_id' => $announcement->id,
                'name' => $file,
            ]);
        }
        $announcement->update($data);
        return response()->json(['status' => 200, 'announcement' => $announcement]);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Request $request)
    {
        $announcement = Announcement::where('id', $request->id)->first();
        $announcement->favorites()->delete();
        $announcement->delete();
        return response()->json($announcement);
    }

    public function additionalInform(Request $request)
    {
        try {
            $additionalInfoAll = AdditionalInfo::query()->get();
            return response(['additionalInformation' => $additionalInfoAll], 200);
        } catch (\Exception $error) {
            return response($error->getMessage());
        }
    }

    public function facilitiesInform()
    {
        try {
            $facilitiesInfoAll = Facility::all();
            return response(['facilitiesInformation' => $facilitiesInfoAll], 200);
        } catch (\Exception $error) {
            return response($error->getMessage());
        }
    }

    public function favorites(Request $request)
    {
        $favorites = Favorite::where('user_id', $request->id)->get(['announcement_id']);
        return response()->json(compact('favorites'));
    }

    public function addBrokerAnnouncement(Request $request)
    {
        if ($announcement = Announcement::where('id', $request->announcement)->first()) {
            $data = [
                'broker_id' => (int)$request->broker
            ];
            $announcement->update($data);
            return response()->json([
                'status' => 'success',
                'announcement' => $announcement,
            ]);
        } else {
            return response()->json([
                'error' => 'Something went wrong please try again!',
            ]);
        }
    }

    public function search(Request $request)
    {
        $query = Announcement::where('verify', 1);
        if ($request->input('data.category')) {
            $query->where('category_id', (int)$request->input('data.category'));
        }
        if ($request->input('data.type')) {
            $query->where('type_id', (int)$request->input('data.type'));
        }
        if ($request->input('data.maxPrice')) {
            $query->where('price', '<=', $request->input('data.maxPrice'));
        }
        if ($request->input('data.minPrice')) {
            $query->where('price', '>=', (int)$request->input('data.minPrice'));
        }
        if ($request->input('data.currency')) {
            $query->where('currency_id', (int)$request->input('data.currency'));
        }
        if ($request->input('data.maxSize')) {
            $query->where('area', '<=', $request->input('data.maxSize'));
        }
        if ($request->input('data.minSize')) {
            $query->where('area', '>=', $request->input('data.minSize'));
        }
        if ($request->input('data.maxArea')) {
            $query->where('land_area', '<=', $request->input('data.maxArea'));
        }
        if ($request->input('data.minArea')) {
            $query->where('land_area', '>=', $request->input('data.minArea'));
        }
        if ($request->input('data.rooms')) {
            $query->where('rooms', '>=', (int)$request->input('data.rooms'));
        }
        if ($request->input('data.furniture')) {
            $query->where('furniture', $request->input('data.furniture'));
        }
        if ($request->input('data.land_type')) {
            $query->where('land_type', $request->input('data.land_type'));
        }
        if ($request->input('data.land_geometric_appearance')) {
            $query->where('land_geometric_appearance', $request->input('data.land_geometric_appearance'));
        }
        if ($request->input('data.front_position')) {
            $query->where('front_position', $request->input('data.front_position'));
        }
        if ($request->input('data.purpose')) {
            $query->where('purpose', $request->input('data.purpose'));
        }
        if ($request->input('data.floor')) {
            $query->where('floor', '>=', (int)$request->input('data.floor'));
        }
        if ($request->input('data.storeys')) {
            $query->where('storeys', '>=', (int)$request->input('data.storeys'));
        }
        if ($request->input('data.building_type')) {
            $query->where('building_type', $request->input('data.building_type'));
        }
        if ($request->input('data.condition')) {
            $query->where('condition', $request->input('data.condition'));
        }
        if ($request->input('data.ceiling_height')) {
            $query->where('ceiling_height', '>=', $request->input('data.ceiling_height'));
        }
        if ($request->input('data.bathroom')) {
            $query->where('bathroom', '>=', $request->input('data.bathroom'));
        }
        if ($request->input('data.place')) {
            $place = explode(",", $request->input('data.place'));
            if (count($place) > 1) {
                $query->where('state_id', (int)$place[0]);
                $query->where('city_id', (int)$place[1]);

            } else {
                $query->where('state_id', (int)$place[0]);
            }
        }
        $allAnnouncements = $query->with('currency')->get();
        if ($request->input('data.sort_by')) {
            $announcements = $query->orderBy($request->input('data.sort_by')[0], $request->input('data.sort_by')[1])->with('category', 'currency')->paginate(6);
        } else {
            $announcements = $query->orderBy('updated_at','DESC')->with('category', 'currency')->paginate(6);
        }
        return response()->json(compact('announcements', 'allAnnouncements'));
    }

    public function states()
    {
        $states = State::with('cities')->get();
        return response()->json(compact('states'));
    }

    public function cities()
    {
        $cities = City::all();
        return response()->json(compact('cities'));
    }

    public function userAnnouncements(Request $request)
    {
        $id = $request->id;
        $announcements = Announcement::where([['user_id', $id], ['category_id', 1], ['verify', 1]])->with('category', 'currency')->orderBy('updated_at','DESC')->paginate(5);
        return response()->json(compact('announcements'));
    }

    public function userRentAnnouncements(Request $request)
    {
        $id = $request->id;
        $announcements = Announcement::where([['user_id', $id], ['category_id', 2]])->with('category', 'currency')->paginate(5);
        return response()->json(compact('announcements'));
    }

    public function userUnverifiedAnnouncements(Request $request)
    {
        $id = $request->id;
        $announcements = Announcement::where([['user_id', $id], ['verify', 2]])->with('category', 'currency')->paginate(5);
        return response()->json(compact('announcements'));
    }
    public function userArchivedAnnouncements(Request $request)
    {
        $id = $request->id;
        $announcements = Announcement::where([['user_id', $id], ['verify', 3]])->with('category', 'currency')->paginate(5);
        return response()->json(compact('announcements'));
    }
    public function deArcheving(Request $request)
    {
        $id = $request->id;
        Announcement::where('id', $id)->update(['verify'=> 1]);
        $announcements = Announcement::where([['user_id', $request->user_id], ['verify', 3]])->with('category', 'currency')->paginate(5);
        return response()->json(compact('announcements'));
    }

    public function removeImage(Request $request)
    {
        $id = $request->id;
        $image_id = (int)$request->image_id;
        $image_name = $request->image_name;
        if ($image_id !== 0) {
            AnnouncementImage::where([['announcement_id', $id], ['name', $image_name]])->delete();
        } else {
            Announcement::where('id', $id)->first()->update(['main_image' => null]);
        }
        Storage::disk('public')->delete('uploads/announcements/' . $image_name);
        return response()->json('Image deleted');
    }

    /**
     */
    public function validateListing(Request $request)
    {
        $errors = [];
        $type = Type::find((int)$request->input('data.type'));
        $validator = Validator::make($request->all(), [
            'data.price' => 'required',
            'data.address' => 'required|string|max:255',
            'data.area' => 'required|numeric',
            'data.sewer' => 'required',
            'data.distance_from_metro_station' => 'required',
            'data.distance_from_medical_center' => 'required',
            'data.distance_from_stations' => 'required',
            'data.agree' => 'required',
            'data.recaptcha' => 'required',
            'data.currency' => 'required',
        ]);
        if ($validator->fails()) {
            array_push($errors, $validator->messages());
        }
        if ($type->slug === 'land') {
            $validatorLand = Validator::make($request->all(), [
                'data.land_geometric' => 'required|string|max:255',
                'data.purpose' => 'required',
                'data.front_position' => 'required',
                'data.front_position_length' => 'required',
                'data.road_type' => 'required',
                'data.fence_type' => 'required',
                'data.infrastructure' => 'required',
                'data.building' => 'required',
            ]);
            if ($validatorLand->fails()) {
                array_push($errors, $validatorLand->messages());
            }

        } elseif ($type->slug === 'house') {
            $validatorHouse = Validator::make($request->all(), [
                'data.bedrooms' => 'required',
                'data.bathrooms' => 'required',
                'data.ceiling_height' => 'required',
                'data.balcony' => 'required',
                'data.condition' => 'required',
                'data.building_type' => 'required',
                'data.storeys' => 'required',
                'data.furniture' => 'required',
                'data.year' => 'required',
                'data.degree' => 'required',
            ]);
            if ($validatorHouse->fails()) {
                array_push($errors, $validatorHouse->messages());
            }
        } elseif ($type->slug === 'apartment') {
            $validatorAppartment = Validator::make($request->all(), [
                'data.bedrooms' => 'required',
                'data.bathrooms' => 'required',
                'data.ceiling_height' => 'required',
                'data.balcony' => 'required',
                'data.condition' => 'required',
                'data.building_type' => 'required',
                'data.floor' => 'required',
                'data.storeys' => 'required',
                'data.furniture' => 'required',
                'data.year' => 'required',
                'data.degree' => 'required',
            ]);
            if ($validatorAppartment->fails()) {
                array_push($errors, $validatorAppartment->messages());
            }
        } elseif ($type->slug === 'commercial') {
            $validatorCommercial = Validator::make($request->all(), [
                'data.bathrooms' => 'required',
                'data.ceiling_height' => 'required',
                'data.condition' => 'required',
                'data.building_type' => 'required',
                'data.floor' => 'required',
                'data.storeys' => 'required',
                'data.furniture' => 'required',
                'data.land_type' => 'required',
                'data.property_place' => 'required',
                'data.year' => 'required',
                'data.degree' => 'required',
                'data.condominium' => 'required',
            ]);
            if ($validatorCommercial->fails()) {
                array_push($errors, $validatorCommercial->messages());
            }
        }
        if (!empty($errors)) {
            array_push($errors, $validator->messages());
            return response()->json(['status' => 400, 'message' => $errors]);
        }
        return response()->json(['status' => 200, 'message' => []]);
    }

    public function changeDatePicker(Request $request)
    {
        $announcement = Announcement::where('id', $request->id)->first();
        $date = [
            'start_date' => $request->start_date,
            'end_date' => $request->end_date
        ];
        $announcement->update($date);
        $rentAnnouncements = Announcement::where([['category_id', $announcement->category_id], ['user_id', $announcement->user_id]])->with('category', 'currency')->paginate(5);
        return response()->json(compact('rentAnnouncements'));
    }
    public function offersAndClosings(Request $request){
        $user_id = $request->user_id;
        $announcements = Announcement::where('user_id',$user_id)->where('verify',"4")->with('category', 'currency')->paginate(5);
        return response()->json(compact('announcements'));
    }
    public function addArchive(Request $request){
        Announcement::where('id',$request->id)->first()->update(['verify'=>3]);
        if($request->type === "my_announcements"){
            $announcements = Announcement::where([['user_id', $request->user_id], ['category_id', 1], ['verify', 1]])->with('category', 'currency')->paginate(5);
        }else{
            $announcements = Announcement::where([['user_id', $request->user_id], ['category_id', 2], ['verify', 1]])->with('category', 'currency')->paginate(5);
        }
        return response()->json(compact('announcements'));
    }
    public function completed(Request $request){
        Announcement::where('id',$request->id)->first()->update(['verify'=>4]);
        if($request->type === "my_announcements"){
            $announcements = Announcement::where([['user_id', $request->user_id], ['category_id', 1], ['verify', 1]])->with('category', 'currency')->paginate(5);
        }else{
            $announcements = Announcement::where([['user_id', $request->user_id], ['category_id', 2], ['verify', 1]])->with('category', 'currency')->paginate(5);
        }
        return response()->json(compact('announcements'));
    }
    public function averageValue($type, $category, $city, $building_type, $degree, $cover, $area) {
        $averages = Announcement::query()->where([
            ['type_id' , $type],
            ['category_id' , $category],
            ['city_id' , $city],
            ['building_type' , $building_type],
            ['degree' , $degree],
            ['cover' , $cover],
        ])->get(['zestimate','area', 'price']);
        $value = 0;
        foreach ($averages as $average) {
            $value += ($average->zestimate + $average->price) / (2 * $average->area);
        }
        return ($value * $area)/count($averages);
    }

    public function renew(Request $request){
        Announcement::where('id',$request->id)->first()->touch();
        if($request->type === "my_announcements"){
            $announcements = Announcement::where([['user_id', $request->user_id], ['category_id', 1], ['verify', 1]])->with('category', 'currency')->orderBy('updated_at','DESC')->paginate(5);
        }else{
            $announcements = Announcement::where([['user_id', $request->user_id], ['category_id', 2], ['verify', 1]])->with('category', 'currency')->orderBy('updated_at','DESC')->paginate(5);
        }
        return response()->json(compact('announcements'));
    }
}
