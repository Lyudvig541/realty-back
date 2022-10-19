<?php

namespace App\Http\Controllers\Admin;

use App\AdditionalInfo;
use App\AnnouncementImage;
use App\Category;
use App\City;
use App\Currency;
use App\Facility;
use App\Http\Controllers\Controller;
use App\Announcement;
use App\Http\Requests\ApartementPost;
use App\Http\Requests\CommercialPost;
use App\Http\Requests\HomePost;
use App\Http\Requests\LandPost;
use App\Notification;
use App\State;
use App\Type;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;

class AnnouncementController extends Controller
{
    /**
     * verified announcements
    */
    protected $coefficient = [
        'price'=> ['monolith' => 230000, 'stone' => 255000, 'panel' => 255000, 'other' => 255000],
        'region' => [
            1 => [0.17, 1],
            9=> [0.055, 0.26],
            4=> [0.044, 0.32],
            3=> [0.035, 0.32],
            8=> [0.035, 0.32],
            2=> [0.035, 0.21],
            6=> [0.035, 0.26],
            7=> [0.035, 0.17],
            5=> [0.035, 0.13],
            11=> [0.035, 0.13],
            10=> [0.035, 0.13],
        ],
        'cover' => [
            'reinforced_concrete' => 1,
            'panel' => 1,
            'wood' => 0.9
        ],
        'ceiling_height' => [
            2.7 => 0.9,
            3.0 => 1,
            4 => 1.1
        ],
        'floor' => [
            1 => 0.95,
            2 => 0.95,
            3 => 1,
            4 => 1,
            5 => 1,
            6 => 1,
            7 => 0.9,
            8 => 0.9,
            9 => 0.9,
            10 => 0.8,
            11 => 0.7,
            'basement' => 0.65,
        ],
        'degree' => [
            0 => 1,
            1 => 0.95,
            2 => 0.95,
            3 => 0.5,
            4 => 0,
        ],
        'year' => [
            "0.6" => 1,
            "7.9" => 0.94,
            "10.12" => 0.91,
            "13.15" => 0.88,
            "16.18" => 0.85,
            "19.21" => 0.82,
            "22.24" => 0.79,
            "25.27" => 0.76,
            "28.30" => 0.73,
            "31.40" => 0.7,
            "41" => 0.6,
        ]
    ];

    public function index()
    {
        if (auth()->user()->hasRole('broker')){
            $announcements = Announcement::where([['verify','!=', "0"],['user_id', auth()->user()->id]])->orWhere([['broker_id',auth()->user()->id],['accepted',"1"],['verify','!=', "0"]])->orWhere([['broker_id',auth()->user()->id],['accepted',"1"]])->orderBY('created_at','desc')->paginate(10);
        }else if(auth()->user()->hasRole('super_broker')){
            $announcements = Announcement::where('user_id', Auth::id())->orWhere('broker_id', Auth::id())->orderBY('created_at','desc')->paginate(10);
        }else{
            $announcements = Announcement::where('verify',1)->orWhere('verify',4)->orderBY('created_at','desc')->paginate(10);
        }
        return view('admin.announcement.index', compact('announcements'));
    }
    /**
     * brokers announcements
    */

    public function brokersAnnouncements()
    {
        $announcements = User::where('id', Auth::id())->first()->brokerAnnouncemnets()->where('verify',1)->orWhere('verify',6)->orderBY('created_at','desc')->paginate(10);

        return view('admin.announcement.index', compact('announcements'));
    }

    /**
     * free announcements
     */

    public function freeAnnouncements()
    {
        if (auth()->user()->hasRole('broker')){
            $announcements = Announcement::where('verify', 5)->where('free', 1)->paginate(10);
            return view('admin.announcement.free', compact('announcements'));
        }elseif (auth()->user()->hasRole('super_broker')){
            $announcements = Announcement::where('verify', 5)->where('free', 2)->paginate(10);
            return view('admin.announcement.free', compact('announcements'));
        }
        return view('dashboard');
    }

    /**
     * dont verify announcements
     */

    public function verifys(){
        $announcements = Announcement::where('verify',0)->orWhere('verify',2)->paginate(10);
        return view('admin.announcement.verify_index', compact('announcements'));
    }

    /**
     * open create announcement blade
     * @param int $category
     * @param int $type_id
     */

    public function create($category,$type_id)
    {
        $users = User::get();
        $additional_infos = AdditionalInfo::get();
        $facilities = Facility::get();
        $languages = config('translatable.locales');
        $type = Type::find($type_id);
        $currencies = Currency::all();
        $states = State::query()->with('cities')->get();
        $cities = City::where('state_id',$states[0]->id)->get();
        $url = '';
        switch ($type->id) {
            case 1:
                $url = "store-house";
                break;
            case 2:
                $url = "store-apartment";
                break;
            case 3:
                $url = "store-commercial";
                break;
            case 4:
                return view('admin.announcement.create_land_announcement', compact('users', 'languages', 'additional_infos', 'facilities','category','type','currencies','states','cities'));
        }
        return view('admin.announcement.create_announcement', compact('users', 'url','languages', 'additional_infos', 'facilities','category','type','currencies','states','cities'));
    }

    /**
     * store announcement of home type
     * @param HomePost $request
     * @param int $category
     * @param int $type
     */

    public function storeHome(HomePost $request, $category, $type )
    {
        $request->validated();
        $addInfo = json_encode($request->additional_infos);
        $facilities = json_encode($request->facilities);
        $data = [
            'price' => $request->price,
            'address' => $request->address,
            'floor' => $request->floor,
            'storeys' => $request->storeys,
            'land_area' => $request->land_area,
            'area' => $request->area,
            'city_id' => $request->city_id,
            'state_id' => $request->state_id,
            'rooms' => $request->rooms,
            'sewer' => $request->sewer,
            'cover' => $request->cover,
            'year' => $request->year,
            'degree' => $request->degree,
            'furniture' => $request->furniture,
            'distance_from_metro_station' => $request->distance_from_metro_station,
            'distance_from_medical_center' => $request->distance_from_medical_center,
            'distance_from_stations' => $request->distance_from_stations,
            'bathroom' => $request->bathroom,
            'building_type' => $request->building_type,
            'ceiling_height' => $request->ceiling_height,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'balcony' => $request->balcony,
            'user_id' => $request->user_id ?? Auth::id(),
            'category_id' => $category,
            'type_id' => $type,
            'verify' => true,
            'condition' => $request->condition,
            'description' => $request->description,
            'facilities' => $facilities,
            'additional_infos' => $addInfo,
            'rent_type' => $request->rent_type,
            'currency_id' => $request->currency,
        ];
        $price = $this->propertyPrice($request->area, $request->building_type,$request->state_id, $request->cover, $request->ceiling_height, $request->degree,$request->year);
        if ($price){
            $currency = Currency::find($request->currency);
            $data['zestimate'] = $price / $currency->value;
        }else{
            $data['zestimate'] = ($request->price * 91) / 100;
        }
        if (auth()->user()->hasRole('broker') || auth()->user()->hasRole('super_broker')){
            $data['broker_id'] = Auth::id();
        }
        if ($request->hasFile('main_image')) {
            $imagePath = $request->file('main_image');
            $imageName = time() . '_' . $imagePath->getClientOriginalName();
            $img = Image::make($request->file('main_image')->path());
            $img->insert(public_path('logo.png'), 'center')->save(storage_path() . '/app/public/uploads/announcements/' . $imageName);
            $data['main_image'] = $imageName;
        }

        if ($request->hasFile('certificate')) {
            $imagePath = $request->file('certificate');
            $img = Image::make($request->file('certificate')->path());
            $certificate = uniqid() . '_' . $imagePath->getClientOriginalName();
            $img->insert(public_path('logo.png'), 'center')->save(storage_path() . '/app/public/uploads/announcements/' . $certificate);
            $data['certificate'] = $certificate;
        }
        $data['average_value'] = $this->averageValue($type, $category, $request->city_id, $request->building_type, $request->degree, $request->cover, $request->area);
        if (!$data['average_value']){
            $data['average_value'] = $data['zestimate'];
        }
        foreach (config('translatable.locales') as $locale) {
            if ($request->{'additional_text_' . $locale}) {
                $data[$locale] = ['additional_text' => $request->{'additional_text_' . $locale}];
            }
        }

        if (auth()->user()->hasRole('broker')){
            $data['broker_id'] = Auth::id();
        }
        $announcement = Announcement::create($data);
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image){
                $fileName =  time().'_'.$image->getClientOriginalName();
                $img = Image::make($image->path());
                $img->insert(public_path('logo.png'), 'center')->save(storage_path().'/app/public/uploads/announcements/'.$fileName);
                AnnouncementImage::create([
                    'announcement_id' => $announcement->id,
                    'name' => $fileName,
                ]);
            }
        }


        if ($request->broker_id) {
            $this->notification($announcement->user_id);
        }
        return redirect('/admin/announcements');
    }

    /**
     * store announcement of apartment type
     * @param ApartementPost $request
     * @param int $category
     * @param int $type
     */

    public function storeApartment(ApartementPost $request, $category, $type )
    {
        $request->validated();
        $addInfo = json_encode($request->additional_infos);
        $facilities = json_encode($request->facilities);
        $data = [
            'price' => $request->price,
            'address' => $request->address,
            'floor' => $request->floor,
            'storeys' => $request->storeys,
            'land_area' => $request->land_area,
            'area' => $request->area,
            'city_id' => $request->city_id,
            'state_id' => $request->state_id,
            'rooms' => $request->rooms,
            'sewer' => $request->sewer,
            'furniture' => $request->furniture,
            'distance_from_metro_station' => $request->distance_from_metro_station,
            'distance_from_medical_center' => $request->distance_from_medical_center,
            'distance_from_stations' => $request->distance_from_stations,
            'bathroom' => $request->bathroom,
            'building_type' => $request->building_type,
            'ceiling_height' => $request->ceiling_height,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'balcony' => $request->balcony,
            'condominium' => $request->condominium,
            'cover' => $request->cover,
            'year' => $request->year,
            'degree' => $request->degree,
            'user_id' => $request->user_id ?? Auth::id(),
            'category_id' => $category,
            'type_id' => $type,
            'verify' => true,
            'description' => $request->description,
            'condition' => $request->condition,
            'facilities' => $facilities,
            'additional_infos' => $addInfo,
            'rent_type' => $request->rent_type,
            'currency_id' => $request->currency,
        ];
        $price = $this->propertyPrice($request->area, $request->building_type, $request->state_id, $request->cover, $request->ceiling_height, $request->degree, $request->year, $request->floor);
        if ($price){
            $currency = Currency::find($request->currency);
            $data['zestimate'] = $price / $currency->value;
        }else{
            $data['zestimate'] = ($request->price * 91) / 100;
        }
        if (auth()->user()->hasRole('broker') || auth()->user()->hasRole('super_broker')){
            $data['broker_id'] = Auth::id();
        }
        if ($request->hasFile('main_image')) {
            $imagePath = $request->file('main_image');
            $imageName = time() . '_' . $imagePath->getClientOriginalName();
            $img = Image::make($request->file('main_image')->path());
            $img->insert(public_path('logo.png'), 'center')->save(storage_path() . '/app/public/uploads/announcements/' . $imageName);
            $data['main_image'] = $imageName;
        }
        if ($request->hasFile('certificate')) {
            $imagePath = $request->file('certificate');
            $img = Image::make($request->file('certificate')->path());
            $certificate = uniqid() . '_' . $imagePath->getClientOriginalName();
            $img->insert(public_path('logo.png'), 'center')->save(storage_path() . '/app/public/uploads/announcements/' . $certificate);
            $data['certificate'] = $certificate;
        }
        foreach (config('translatable.locales') as $locale) {
            if ($request->{'additional_text_' . $locale}) {
                $data[$locale] = ['additional_text' => $request->{'additional_text_' . $locale}];
            }
        }
        if (auth()->user()->hasRole('broker')){
            $data['broker_id'] = Auth::id();
        }
        $data['average_value'] = $this->averageValue($type, $category, $request->city_id, $request->building_type, $request->degree, $request->cover, $request->area);
        if (!$data['average_value']){
            $data['average_value'] = $data['zestimate'];
        }

        $announcement = Announcement::create($data);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image){
                $fileName =  time().'_'.$image->getClientOriginalName();
                $img = Image::make($image->path());
                $img->insert(public_path('logo.png'), 'center')->save(storage_path().'/app/public/uploads/announcements/'.$fileName);
                AnnouncementImage::create([
                    'announcement_id' => $announcement->id,
                    'name' => $fileName,
                ]);
            }
        }
        if ($request->broker_id) {
            $this->notification($announcement->user_id);
        }
        return redirect('/admin/announcements');
    }

    /**
     * store announcement of commercial type
     * @param CommercialPost $request
     * @param int $category
     * @param int $type
     */

    public function storeCommercial(CommercialPost $request, $category, $type )
    {
        $request->validated();
        $addInfo = json_encode($request->additional_infos);
        $facilities = json_encode($request->facilities);
        $data = [
            'price' => $request->price,
            'address' => $request->address,
            'floor' => $request->floor,
            'storeys' => $request->storeys,
            'land_area' => $request->land_area,
            'area' => $request->area,
            'cover' => $request->cover,
            'land_type' => $request->land_type,
            'year' => $request->year,
            'degree' => $request->degree,
            'condominium ' => $request->condominium,
            'city_id' => $request->city_id,
            'state_id' => $request->state_id,
            'rooms' => $request->rooms,
            'sewer' => $request->sewer,
            'furniture' => $request->furniture,
            'distance_from_metro_station' => $request->distance_from_metro_station,
            'distance_from_medical_center' => $request->distance_from_medical_center,
            'distance_from_stations' => $request->distance_from_stations,
            'bathroom' => $request->bathroom,
            'building_type' => $request->building_type,
            'ceiling_height' => $request->ceiling_height,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'balcony' => $request->balcony,
            'user_id' => $request->user_id ?? Auth::id(),
            'category_id' => $category,
            'type_id' => $type,
            'verify' => true,
            'description' => $request->description,
            'condition' => $request->condition,
            'facilities' => $facilities,
            'additional_infos' => $addInfo,
            'rent_type' => $request->rent_type,
            'currency_id' => $request->currency,
        ];
        $price = $this->propertyPrice($request->area, $request->building_type,$request->state_id, $request->cover, $request->ceiling_height, $request->degree,$request->year, $request->floor);
        if ($price){
            $currency = Currency::find($request->currency);
            $data['zestimate'] = $price / $currency->value;
        }else{
            $data['zestimate'] = ($request->price * 91) / 100;
        }
        if ($request->hasFile('main_image')) {
            $imagePath = $request->file('main_image');
            $imageName = time() . '_' . $imagePath->getClientOriginalName();
            $img = Image::make($request->file('main_image')->path());
            $img->insert(public_path('logo.png'), 'center')->save(storage_path() . '/app/public/uploads/announcements/' . $imageName);
            $data['main_image'] = $imageName;
        }
        if ($request->hasFile('certificate')) {
            $imagePath = $request->file('certificate');
            $img = Image::make($request->file('certificate')->path());
            $certificate = uniqid() . '_' . $imagePath->getClientOriginalName();
            $img->insert(public_path('logo.png'), 'center')->save(storage_path() . '/app/public/uploads/announcements/' . $certificate);
            $data['certificate'] = $certificate;
        }

        foreach (config('translatable.locales') as $locale) {
            if ($request->{'additional_text_' . $locale}) {
                $data[$locale] = ['additional_text' => $request->{'additional_text_' . $locale}];
            }
        }
        if (auth()->user()->hasRole('broker') || auth()->user()->hasRole('super_broker')){
            $data['broker_id'] = Auth::id();
        }
        $data['average_value'] = $this->averageValue($type, $category, $request->city_id, $request->building_type, $request->degree, $request->cover, $request->area);
        if (!$data['average_value']){
            $data['average_value'] = $data['zestimate'];
        }
        $announcement = Announcement::create($data);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image){
                $fileName =  time().'_'.$image->getClientOriginalName();
                $img = Image::make($image->path());
                $img->insert(public_path('logo.png'), 'center')->save(storage_path().'/app/public/uploads/announcements/'.$fileName);
                AnnouncementImage::create([
                    'announcement_id' => $announcement->id,
                    'name' => $fileName,
                ]);
            }
        }
        if ($request->broker_id) {
            $this->notification($announcement->user_id);
        }
        return redirect('/admin/announcements');
    }
    /**
     * store announcement of land type
     * @param LandPost $request
     * @param int $category
     * @param int $type
     */

    public function storeLand(LandPost $request,$category,$type){

        $request->validated();

        $data = [
            'price' => $request->price,
            'address' => $request->address,
            'city' => $request->city,
            'state' => $request->state,
            'area' => $request->area,
            'sewer' => $request->sewer,
            'land_geometric_appearance' => $request->land_geometric_appearance,
            'purpose' => $request->purpose,
            'front_position_length' => $request->front_position_length,
            'road_type' => $request->road_type,
            'latitude' => $request->latitude,
            'building' => $request->building,
            'longitude' => $request->longitude,
            'infrastructure' => $request->infrastructure,
            'fence_type' =>  $request->fence_type,
            'category_id' => $category,
            'state_id' => $request->state_id,
            'city_id' => $request->state_id,
            'type_id' => $type,
            'user_id' => $request->user_id ?? Auth::id(),
            'rent_type' => $request->rent_type,
            'verify' => true,
            'description' => $request->description,
            'floor' => $request->floor,
            'storeys' => $request->storeys,
            'land_area' => $request->land_area,
            'land_type'=>$request->land_type,
            'property_place' => $request->property_place,
            'cover' => $request->cover,
            'condominium' => $request->condominium,
            'distance_from_metro_station' => $request->distance_from_metro_station,
            'distance_from_medical_center' => $request->distance_from_medical_center,
            'distance_from_stations' => $request->distance_from_stations,
            'front_position' => $request->front_position,
            'rooms' => $request->rooms,
            'bathroom' => $request->bathroom,
            'building_type' => $request->building_type,
            'ceiling_height' => $request->ceiling_height,
            'condition' => $request->condition,
            'balcony' => $request->balcony,
            'furniture' => $request->furniture,
            'currency_id' => $request->currency,
        ];
        if(auth()->user()->hasRole('broker') || auth()->user()->hasRole('broker')){
            $data['broker_id'] = Auth::id();
        }
//        $price = $this->propertyPrice($request->area, $request->building_type,$request->state_id, $request->cover, $request->ceiling_height, $request->degree,$request->year, $request->floor);
//        if ($price){
//            $currency = Currency::find($request->currency);
//            $data['zestimate'] = $price / $currency->value;
//        }else{
            $data['zestimate'] = ($request->price * 91) / 100;
//        }
        if ($request->hasFile('main_image')) {
            $imagePath = $request->file('main_image');
            $imageName =  time().'_'.$imagePath->getClientOriginalName();
            $img = Image::make($request->file('main_image')->path());
            $img->insert(public_path('logo.png'), 'center')->save(storage_path().'/app/public/uploads/announcements/'.$imageName);
            $data['main_image']=$imageName;
        }
        $certificate =null;
        if ($request->hasFile('certificate')) {
            $imagePath = $request->file('certificate');
            $img = Image::make($request->file('certificate')->path());
            $certificate =  uniqid() .'_'.$imagePath->getClientOriginalName();
            $img->insert(public_path('logo.png'), 'center')->save(storage_path().'/app/public/uploads/announcements/'.$certificate);
            $data['certificate'] = $certificate;
        }

        $data['main_image']=$imageName;
        $data['certificate']=$certificate;

        foreach (config('translatable.locales') as $locale){
            if($request->{'additional_text_'.$locale}){
                $data[$locale] = ['additional_text' => $request->{'additional_text_'.$locale}];
            }
        }
        if (auth()->user()->hasRole('broker')){
            $data['broker_id'] = Auth::id();
        }
        $announcement = Announcement::create($data);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image){
                $fileName =  time().'_'.$image->getClientOriginalName();
                $img = Image::make($image->path());
                $img->insert(public_path('logo.png'), 'center')->save(storage_path().'/app/public/uploads/announcements/'.$fileName);
                AnnouncementImage::create([
                    'announcement_id' => $announcement->id,
                    'name' => $fileName,
                ]);
            }
        }

        toastr()->success("Successfully Created");
        return redirect('/admin/announcements');
    }

    /**
     * open edit announcement blade
     * @param int $id
     */

    public function edit($id)
    {
        $users = User::get();
        $announcement = Announcement::find($id);
        $additional_infos = AdditionalInfo::get();
        $facilities = Facility::get();
        $languages = config('translatable.locales');
        $states = State::query()->with('cities')->get();
        $state_id = $announcement->state_id;
        $cities = City::where('state_id',$state_id)->get();
        $currencies = Currency::all();
        $edit_type = "edit";
        $url = '';
        switch ($announcement->type_id) {
            case 1:
                $url = "update-house";
                break;
            case 2:
                $url = "update-apartment";
                break;
            case 3:
                $url = "update-commercial";
                break;
            case 4:
                $url = "update-land";
        }
        return view('admin.announcement.edit_announcement', compact('users','url','announcement', 'additional_infos', 'facilities', 'languages','states','cities','currencies','edit_type'));
    }

    /**
     * update announcement of house type
     * @param HomePost $request
     * @param int $id
     */

    public function updateHouse(HomePost $request, $id){
        $request->validated();
        if ($request->additional_infos){
            $addInfo = json_encode($request->additional_infos);
        }else{
            $addInfo = [];
        }
        if ($request->facilities){
            $facilities = json_encode($request->facilities);
        }else{
            $facilities = [];
        }
        $data = [
            'price' => $request->price,
            'address' => $request->address,
            'floor' => $request->floor,
            'year' => $request->year,
            'degree' => $request->degree,
            'storeys' => $request->storeys,
            'land_area' => $request->land_area,
            'area' => $request->area,
            'land_type'=>$request->land_type,
            'property_place' => $request->property_place,
            'sewer' => $request->sewer,
            'cover' => $request->cover,
            'distance_from_metro_station' => $request->distance_from_metro_station,
            'distance_from_medical_center' => $request->distance_from_medical_center,
            'distance_from_stations' => $request->distance_from_stations,
            'rooms' => $request->rooms,
            'bathroom' => $request->bathroom,
            'building_type' => $request->building_type,
            'ceiling_height' => $request->ceiling_height,
            'condition' => $request->condition,
            'purpose' => $request->purpose,
            'additional_infos' => $addInfo,
            'facilities' => $facilities,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'balcony' => $request->balcony,
            'furniture' => $request->furniture,
            'rent_type' => $request->rent_type,
            'user_id' => $request->user_id ?? Auth::id(),
            'city_id' => $request->city_id,
            'state_id' => $request->state_id,
            'building' => $request->building,
            'currency_id' => $request->currency,
            'description' => $request->description,
            'verify' => 1,
        ];
        $price = $this->propertyPrice($request->area, $request->building_type,$request->state_id, $request->cover, $request->ceiling_height, $request->degree,$request->year, $request->floor);
        if ($price){
            $currency = Currency::find($request->currency);
            $data['zestimate'] = $price / $currency->value;
        }else{
            $data['zestimate'] = ($request->price * 91) / 100;
        }
        if ($request->hasFile('main_image')) {
            $imagePath = $request->file('main_image');
            $imageName =  time().'_'.$imagePath->getClientOriginalName();
            $img = Image::make($request->file('main_image')->path());
            $img->insert(public_path('logo.png'), 'center')->save(storage_path().'/app/public/uploads/announcements/'.$imageName);
            $data['main_image']=$imageName;
        }
        if ($request->hasFile('certificate')) {
            $imagePath = $request->file('certificate');
            $img = Image::make($request->file('certificate')->path());
            $certificate =  uniqid() .'_'.$imagePath->getClientOriginalName();
            $img->insert(public_path('logo.png'), 'center')->save(storage_path().'/app/public/uploads/announcements/'.$certificate);
            $data['certificate'] = $certificate;
        }
        $announcement = Announcement::findOrFail($id);
        $data['average_value'] = $this->averageValue($announcement->type_id, $announcement->category_id, $request->city_id, $request->building_type, $request->degree, $request->cover, $request->area);
        if (!$data['average_value']){
            $data['average_value'] = $data['zestimate'];
        }
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image){
                $fileName =  time().'_'.$image->getClientOriginalName();
                $img = Image::make($image->path());
                $img->insert(public_path('logo.png'), 'center')->save(storage_path().'/app/public/uploads/announcements/'.$fileName);
                AnnouncementImage::create([
                    'announcement_id' => $announcement->id,
                    'name' => $fileName,
                ]);
            }
        }
        foreach (config('translatable.locales') as $locale){
            if($request->{'additional_text_'.$locale}) {
                $data[$locale] = ['additional_text' => $request->{'additional_text_'. $locale}];
            }
        }
        $announcement->update($data);
        toastr()->success("Announcement Updated!");

        return redirect('/admin/announcements');

    }

    /**
     * update announcement of apartment type
     * @param ApartementPost $request
     * @param int $id
     */

    public function updateApartment(ApartementPost $request, $id){
        $request->validated();
        if ($request->additional_infos){
            $addInfo = json_encode($request->additional_infos);
        }else{
            $addInfo = [];
        }
        if ($request->facilities){
            $facilities = json_encode($request->facilities);
        }else{
            $facilities = [];
        }
        $data = [
            'price' => $request->price,
            'address' => $request->address,
            'condominium' => $request->condominium,
            'degree' => $request->degree,
            'year' => $request->year,
            'floor' => $request->floor,
            'storeys' => $request->storeys,
            'land_area' => $request->land_area,
            'area' => $request->area,
            'land_type'=>$request->land_type,
            'property_place' => $request->property_place,
            'sewer' => $request->sewer,
            'cover' => $request->cover,
            'distance_from_metro_station' => $request->distance_from_metro_station,
            'distance_from_medical_center' => $request->distance_from_medical_center,
            'distance_from_stations' => $request->distance_from_stations,
            'rooms' => $request->rooms,
            'bathroom' => $request->bathroom,
            'building_type' => $request->building_type,
            'ceiling_height' => $request->ceiling_height,
            'condition' => $request->condition,
            'purpose' => $request->purpose,
            'additional_infos' => $addInfo,
            'facilities' => $facilities,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'balcony' => $request->balcony,
            'furniture' => $request->furniture,
            'rent_type' => $request->rent_type,
            'user_id' => $request->user_id ?? Auth::id(),
            'city_id' => $request->city_id,
            'state_id' => $request->state_id,
            'building' => $request->building,
            'currency_id' => $request->currency,
            'description' => $request->description,
            'verify' => 1,
        ];
        $price = $this->propertyPrice($request->area, $request->building_type,$request->state_id, $request->cover, $request->ceiling_height, $request->degree,$request->year, $request->floor);
        if ($price){
            $currency = Currency::find($request->currency);
            $data['zestimate'] = $price / $currency->value;
        }else{
            $data['zestimate'] = ($request->price * 91) / 100;
        }
        if ($request->hasFile('main_image')) {
            $imagePath = $request->file('main_image');
            $imageName =  time().'_'.$imagePath->getClientOriginalName();
            $img = Image::make($request->file('main_image')->path());
            $img->insert(public_path('logo.png'), 'center')->save(storage_path().'/app/public/uploads/announcements/'.$imageName);
            $data['main_image']=$imageName;
        }
        if ($request->hasFile('certificate')) {
            $imagePath = $request->file('certificate');
            $img = Image::make($request->file('certificate')->path());
            $certificate =  uniqid() .'_'.$imagePath->getClientOriginalName();
            $img->insert(public_path('logo.png'), 'center')->save(storage_path().'/app/public/uploads/announcements/'.$certificate);
            $data['certificate'] = $certificate;
        }
        $announcement = Announcement::findOrFail($id);
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image){
                $fileName =  time().'_'.$image->getClientOriginalName();
                $img = Image::make($image->path());
                $img->insert(public_path('logo.png'), 'center')->save(storage_path().'/app/public/uploads/announcements/'.$fileName);
                AnnouncementImage::create([
                    'announcement_id' => $announcement->id,
                    'name' => $fileName,
                ]);
            }
        }
        $data['average_value'] = $this->averageValue($announcement->type_id, $announcement->category_id, $request->city_id, $request->building_type, $request->degree, $request->cover, $request->area);
        if (!$data['average_value']){
            $data['average_value'] = $data['zestimate'];
        }

        foreach (config('translatable.locales') as $locale){
            if($request->{'additional_text_'.$locale}) {
                $data[$locale] = ['additional_text' => $request->{'additional_text_'. $locale}];
            }
        }
        $announcement->update($data);
        toastr()->success("Announcement Updated!");

        return redirect('/admin/announcements');

    }

    /**
     * update announcement of commercial type
     * @param CommercialPost $request
     * @param int $id
     */

    public function updateCommercial(CommercialPost $request, $id){

        $request->validated();

        if ($request->additional_infos){
            $addInfo = json_encode($request->additional_infos);
        }else{
            $addInfo = [];
        }

        if ($request->facilities){
            $facilities = json_encode($request->facilities);
        }else{
            $facilities = [];
        }

        $data = [
            'degree' => $request->degree,
            'year' => $request->year,
            'price' => $request->price,
            'address' => $request->address,
            'floor' => $request->floor,
            'storeys' => $request->storeys,
            'land_area' => $request->land_area,
            'area' => $request->area,
            'land_type'=>$request->land_type,
            'property_place' => $request->property_place,
            'sewer' => $request->sewer,
            'cover' => $request->cover,
            'distance_from_metro_station' => $request->distance_from_metro_station,
            'distance_from_medical_center' => $request->distance_from_medical_center,
            'distance_from_stations' => $request->distance_from_stations,
            'rooms' => $request->rooms,
            'bathroom' => $request->bathroom,
            'building_type' => $request->building_type,
            'ceiling_height' => $request->ceiling_height,
            'condition' => $request->condition,
            'purpose' => $request->purpose,
            'additional_infos' => $addInfo,
            'facilities' => $facilities,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'furniture' => $request->furniture,
            'rent_type' => $request->rent_type,
            'user_id' => $request->user_id ?? Auth::id(),
            'city_id' => $request->city_id,
            'state_id' => $request->state_id,
            'building' => $request->building,
            'currency_id' => $request->currency,
            'description' => $request->description,
            'verify' => 1,
        ];
        $price = $this->propertyPrice($request->area, $request->building_type,$request->state_id, $request->cover, $request->ceiling_height, $request->degree,$request->year, $request->floor);
        if ($price){
            $currency = Currency::find($request->currency);
            $data['zestimate'] = $price / $currency->value;
        }else{
            $data['zestimate'] = ($request->price * 91) / 100;
        }
        if ($request->hasFile('main_image')) {
            $imagePath = $request->file('main_image');
            $imageName =  time().'_'.$imagePath->getClientOriginalName();
            $img = Image::make($request->file('main_image')->path());
            $img->insert(public_path('logo.png'), 'center')->save(storage_path().'/app/public/uploads/announcements/'.$imageName);
            $data['main_image']=$imageName;
        }
        if ($request->hasFile('certificate')) {
            $imagePath = $request->file('certificate');
            $img = Image::make($request->file('certificate')->path());
            $certificate =  uniqid() .'_'.$imagePath->getClientOriginalName();
            $img->insert(public_path('logo.png'), 'center')->save(storage_path().'/app/public/uploads/announcements/'.$certificate);
            $data['certificate'] = $certificate;
        }

        $announcement = Announcement::findOrFail($id);
        $data['average_value'] = $this->averageValue($announcement->type_id, $announcement->category_id, $request->city_id, $request->building_type, $request->degree, $request->cover, $request->area);
        if (!$data['average_value']){
            $data['average_value'] = $data['zestimate'];
        }

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image){
                $fileName =  time().'_'.$image->getClientOriginalName();
                $img = Image::make($image->path());
                $img->insert(public_path('logo.png'), 'center')->save(storage_path().'/app/public/uploads/announcements/'.$fileName);
                AnnouncementImage::create([
                    'announcement_id' => $announcement->id,
                    'name' => $fileName,
                ]);
            }
        }
        foreach (config('translatable.locales') as $locale){
            if($request->{'additional_text_'.$locale}) {
                $data[$locale] = ['additional_text' => $request->{'additional_text_'. $locale}];
            }
        }
        $announcement->update($data);
        toastr()->success("Announcement Updated!");

        return redirect('/admin/announcements');

    }

    /**
     * update announcement of commercial type
     * @param LandPost $request
     * @param int $id
     */

    public function updateLand(LandPost $request, $id){
        $request->validated();
        if ($request->additional_infos){
            $addInfo = json_encode($request->additional_infos);
        }else{
            $addInfo = [];
        }
        if ($request->facilities){
            $facilities = json_encode($request->facilities);
        }else{
            $facilities = [];
        }
        $data = [
            'price' => $request->price,
            'address' => $request->address,
            'floor' => $request->floor,
            'storeys' => $request->storeys,
            'land_area' => $request->land_area,
            'area' => $request->area,
            'land_type'=>$request->land_type,
            'property_place' => $request->property_place,
            'sewer' => $request->sewer,
            'cover' => $request->cover,
            'condominium' => $request->condominium,
            'distance_from_metro_station' => $request->distance_from_metro_station,
            'distance_from_medical_center' => $request->distance_from_medical_center,
            'distance_from_stations' => $request->distance_from_stations,
            'infrastructure' => $request->infrastructure,
            'fence_type' =>  $request->fence_type,
            'road_type' => $request->road_type,
            'front_position' => $request->front_position,
            'front_position_length' => $request->front_position_length,
            'land_geometric_appearance' => $request->land_geometric_appearance,
            'rooms' => $request->rooms,
            'bathroom' => $request->bathroom,
            'building_type' => $request->building_type,
            'ceiling_height' => $request->ceiling_height,
            'condition' => $request->condition,
            'purpose' => $request->purpose,
            'additional_infos' => $addInfo,
            'facilities' => $facilities,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'balcony' => $request->balcony,
            'furniture' => $request->furniture,
            'rent_type' => $request->rent_type,
            'user_id' => $request->user_id ?? Auth::id(),
            'city' => $request->city,
            'city_id' => $request->city_id,
            'state' => $request->state,
            'state_id' => $request->state_id,
            'end_date' => $request->end_date,
            'start_date' => $request->start_date,
            'building' => $request->building,
            'currency_id' => $request->currency,
            'description' => $request->description,
            'verify' => 1,
        ];
//        $price = $this->propertyPrice($request->area, $request->building_type,$request->state_id, $request->cover, $request->ceiling_height, $request->degree,$request->year, $request->floor);
//        if ($price){
//            $currency = Currency::find($request->currency);
//            $data['zestimate'] = $price / $currency->value;
//        }else{
            $data['zestimate'] = ($request->price * 91) / 100;
//        }
        if ($request->hasFile('main_image')) {
            $imagePath = $request->file('main_image');
            $imageName =  time().'_'.$imagePath->getClientOriginalName();
            $img = Image::make($request->file('main_image')->path());
            $img->insert(public_path('logo.png'), 'center')->save(storage_path().'/app/public/uploads/announcements/'.$imageName);
            $data['main_image']=$imageName;
        }
        if ($request->hasFile('certificate')) {
            $imagePath = $request->file('certificate');
            $img = Image::make($request->file('certificate')->path());
            $certificate =  uniqid() .'_'.$imagePath->getClientOriginalName();
            $img->insert(public_path('logo.png'), 'center')->save(storage_path().'/app/public/uploads/announcements/'.$certificate);
            $data['certificate'] = $certificate;
        }

        $announcement = Announcement::findOrFail($id);
//        $data['average_value'] = $this->averageValue($announcement->type_id, $announcement->category_id, $request->city_id, $request->building_type, $request->degree, $request->cover, $request->area);
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image){
                $fileName =  time().'_'.$image->getClientOriginalName();
                $img = Image::make($image->path());
                $img->insert(public_path('logo.png'), 'center')->save(storage_path().'/app/public/uploads/announcements/'.$fileName);
                AnnouncementImage::create([
                    'announcement_id' => $announcement->id,
                    'name' => $fileName,
                ]);
            }
        }
        foreach (config('translatable.locales') as $locale){
            if($request->{'additional_text_'.$locale}) {
                $data[$locale] = ['additional_text' => $request->{'additional_text_'. $locale}];
            }
        }
        $announcement->update($data);
        toastr()->success("Announcement Updated!");

        return redirect('/admin/announcements');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function destroy($id)
    {
        $announcement = Announcement::where('id', $id)->first();
        $announcement->favorites()->delete();
        $announcement->delete();
        toastr()->success("Announcement deleted!");
        return redirect('/admin/announcements');

    }
    /**
     * Remove announcement image.
     *
     * @param Request $request
     */

    public function removeImage(Request $request){
        if ($request->type && $request->type == 'main_image'){
            if (Announcement::where('id', $request->id)->update(['main_image' => null])){
                return response()->json([
                    'alert' => 'success',
                    'message' => 'Deleted!',
                ]);
            }else{
                return response()->json([
                    'alert' => 'error',
                    'message' => 'Something went wrong please try again!',
                ]);
            }
        }else{
            if (AnnouncementImage::where('id', $request->id)->delete()){
                return response()->json([
                    'alert' => 'success',
                    'message' => 'Deleted!',
                ]);
            }else{
                return response()->json([
                    'alert' => 'error',
                    'message' => 'Something went wrong please try again!',
                ]);
            }
        }
    }

    public function  chooseCategory(){
        $categories = Category::all();
        return view('admin.announcement.choose_category',compact('categories'));

    }

    public function  chooseType($category){
        $types = Type::all();
        return view('admin.announcement.choose_type',compact('types','category'));
    }

    public function attachedAnnouncements()
    {
        if (auth()->user()->hasRole('broker')){
            $announcements = Announcement::where('verify', 6)->where('broker_id', auth()->user()->id)->where('accepted', "0")->paginate(10);
            return view('admin.announcement.attached', compact('announcements'));
        } elseif (auth()->user()->hasRole('super_broker')){
            $announcements = Announcement::where('verify', 6)->where('broker_id', auth()->user()->id)->where('accepted', "0")->paginate(10);
            return view('admin.announcement.attached', compact('announcements'));
        }
        return redirect('login');
    }

    public function acceptAnnouncements($id){
        $announcement = Announcement::findOrFail($id);
        $announcement->update(['accepted' => 1]);

        $notification = [
            'user_id' => $announcement->user_id,
            'type' => 'success',
        ];

        $notification['en'] = [
            'title' => 'Announcement Accepted!',
            'text' => 'Broker accept your request!',
        ];

        $notification['ru'] = [
            'title' => 'Объявление принято!',
            'text' => 'Брокер принимает ваш запрос!',
        ];

        $notification['ru'] = [
            'title' => 'Հայտարարությունն ընդունված է!',
            'text' => 'Բրոքերն ընդունում է ձեր առաջարկը!',
        ];

        Notification::create($notification);

        toastr()->success("Announcement Accepted!");

        return redirect('/admin/announcements/attached-announcements');
    }

    public function declineAnnouncements($id){
        $announcement = Announcement::findOrFail($id);
        $announcement->update(['broker_id' => null]);

        $notification = [
            'user_id' => $announcement->user_id,
            'type' => 'warning',
        ];

        $notification['en'] = [
            'title' => 'Announcement Declined!',
            'text' => 'Broker decline your request!',
        ];

        $notification['ru'] = [
            'title' => 'Объявление отклонено!',
            'text' => 'Брокер отклонил ваш запрос!',
        ];

        $notification['ru'] = [
            'title' => 'Հայտարարությունը մերժվեց!',
            'text' => 'Բրոքերը մերժում է ձեր առաջարկը!',
        ];

        Notification::create($notification);

        toastr()->success("Announcement Declined!");

        return redirect('/admin/attached-announcements');
    }

    public function viewAnnouncements($id){
        $announcement = Announcement::find($id);
        $additional_infos = AdditionalInfo::get();
        $facilities = Facility::get();
        $languages = config('translatable.locales');
        $states = State::query()->with('cities')->get();
        $state_id = $announcement->state_id;
        $cities = City::where('state_id',$state_id)->get();
        return view('admin.announcement.view', compact('announcement', 'additional_infos', 'facilities', 'languages','states','cities'));
    }

    public function take($id){
        $announcement = Announcement::find($id);
        $announcement->update([
            "broker_id" => Auth::id(),
            "free" => '0',
            "verify" => 6
        ]);
        $this->acceptAnnouncements($id);
        toastr()->success("Announcement take!");

        return redirect('/admin/announcements/free-announcements');
    }
    public function showAnnouncements($id){
        $announcement = Announcement::find($id);
        $type = "free";
        $additional_infos = AdditionalInfo::get();
        $facilities = Facility::get();
        $languages = config('translatable.locales');
        $states = State::query()->with('cities')->get();
        $state_id = $announcement->state_id;
        $cities = City::where('state_id',$state_id)->get();
        $currencies = Currency::all();
        return view('admin.announcement.view',compact('announcement', 'type', 'currencies', 'additional_infos', 'facilities', 'languages', 'states','cities'));
    }

    public function rejectAnnouncements(Request $request, $id){
        $announcement = Announcement::find($id);
        $announcement->update([
            "reason" => $request->reason,
            "verify" => '2'
        ]);
        toastr()->success("Announcement rejected!");

        return redirect('/admin/announcements/verify');
    }
    public function archiveAnnouncements($id){
        $announcement = Announcement::find($id);
        if($announcement->verify === 3){
            $announcement->update([
                "verify" => '1'
            ]);
        }else{
            $announcement->update([
                "verify" => '3'
            ]);
        }
        toastr()->success("Announcement archived!");

        return redirect('/admin/announcements');
    }
    public function archives(){

        $announcements = Announcement::where('verify',3)->orderBY('created_at','desc')->paginate(10);

        return view('admin.announcement.archives', compact('announcements'));
    }
    public function completedAnnouncements($id){

        Announcement::where('id',$id)->first()->update(['verify' => 4]);

        return redirect('/admin/announcements');
    }

    public function notification($id){
        $notification = [
            'user_id' => $id,
            'type' => 'primary',
        ];

        $notification['en'] = [
            'title' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry.!',
            'text' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. !',
        ];

        $notification['ru'] = [
            'title' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry.!',
            'text' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. !',
        ];

        $notification['ru'] = [
            'title' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry.!',
            'text' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. !',
        ];

        Notification::create($notification);
    }
    protected function propertyPrice($area, $buildingType, $region, $cover, $ceiling_height, $degree, $year, $floor = 1){

            return $area * $this->coefficient['price'][$buildingType] * (($this->coefficient['region'][$region])[0] + ($this->coefficient['region'][$region])[1]) / 2 * $this->coefficient['cover'][$cover]
                * $ceiling_height * $this->coefficient['floor'][$floor] * $this->coefficient['degree'][$degree]
                * $this->coefficient['year'][$year];
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
        return count($averages) ? ($value * $area)/count($averages) : 0;
    }
}
