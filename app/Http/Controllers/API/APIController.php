<?php

namespace App\Http\Controllers\Api;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\OrderItem;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Driver;
use App\Models\DriverWallet;
use App\Models\UserAddress;
use App\Models\Category;
use App\Models\PromotedBusiness;
use App\Models\Search;
use App\Models\Business;
use Illuminate\Support\Facades\Session;
use App\Models\Product;
use Illuminate\Validation\Rule;
use App\Models\PromoCode;
use Twilio\Rest\Client;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Laravel\Socialite\Facades\Socialite;
class APIController extends Controller
{

    public function signin_with_email(Request $request)
    {
       
       $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);
         if ($validator->fails()) {
             $errors = $validator->errors();

            if ($errors->has('email')) {
                return response()->json(['success' => 'false','message' => $errors->first('email')], 422);
            }
        
            if ($errors->has('password')) {
                return response()->json(['success' => 'false','message' => $errors->first('password')], 422);
            }
        }
  
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = $user->createToken('authToken')->plainTextToken;
            // The user's credentials are correct
            return response()->json(['success' => 'true','message' => 'Login Successful','token' => $token], 200);
        } else {
            return response()->json(['success' => 'false','message' => 'Invalid Email or Password'], 401);
        }
    }
     public function get_driver_wallet()
    {
        $user = Auth::user();
        $driver = Driver::where('user_id',$user->id)->first();
        $deliveredwallets = DriverWallet::where('driver_id',$driver->id)->where('action','delivery')->get();
        $drawnwallets = DriverWallet::where('driver_id',$driver->id)->where('action','drawn')->get();
        $amount = 0;
        foreach($deliveredwallets as $delwallet){
            $amount += $delwallet->amount;
        }
        foreach($drawnwallets as $drnwallet){
            $amount -= $drnwallet->amount;
        }
        
        if($amount){
            return response()->json(['success' => 'true','message' => 'Wallet Amount Fetched Successfully','total_amount' => $amount], 200);
        } 
        elseif($amount == 0){
             return response()->json(['success' => 'true','message' => 'Wallet Amount Fetched Successfully','total_amount' => $amount], 200);
            }
        else {
            return response()->json(['success' => 'false','message' => 'Error Fetching Wallet Amount'], 401);
        }
    }
    public function get_driver_wallet_history()
    {
        $user = Auth::user();
        $driver = Driver::where('user_id',$user->id)->first();
        $wallets = DriverWallet::where('driver_id',$driver->id)->get();
        foreach($wallets as $wallet){
            $wallet->epoch_date_time = $wallet->created_at->timestamp;
        }
        if($wallets){
            return response()->json(['success' => 'true','message' => 'Wallet Amount Fetched Successfully','wallets' => $wallets], 200);
        } 
        else {
            return response()->json(['success' => 'false','message' => 'Error Fetching Wallets'], 401);
        }
    }
    public function signin_with_phone_number(Request $request)
{
            $validator = Validator::make($request->all(), [
            'phone_number' => 'required',
        ]);
    
        if ($validator->fails()) {
            $errors = $validator->errors();
            return response()->json(['success' => false, 'message' => $errors->first()], 422);
        }
    
        $verificationCode = str_pad(mt_rand(0, 9999), 4, '0', STR_PAD_LEFT);
    
        // Save the verification code to the database
        DB::table('verification_codes')->insert([
            'phone_number' => $request->phone_number,
            'code' => $verificationCode,
        ]);
        // Send the verification code as an SMS using Twilio
        $twilio = new Client(env('TWILIO_SID'), env('TWILIO_TOKEN'));
        try {
            $message = $twilio->messages->create(
                "+".$request->phone_number,
                [
                    'from' => env('TWILIO_PHONE_NUMBER'),
                    'body' => "Your verification code is: $verificationCode",
                ]
            );
            if($message){
            return response()->json(['success' => true, 'message' => 'Verification code sent successfully'], 200);
            }else{
            return response()->json(['success' => true, 'message' => 'Error Sending Code'], 422);
            }
        } catch (Twilio\Exceptions\RestException $e) {
            // Log or handle the exception
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    
            
    }
    public function driver_signin(Request $request)
    {
            $validator = Validator::make($request->all(), [
            'phone_number' => 'required',
            'passcode' => 'required',
            ]);
            
            if ($validator->fails()) {
                $errors = $validator->errors();
                return response()->json(['success' => false, 'message' => $errors->first()], 422);
            }
            
            $driver = Driver::where('phone_number', $request->phone_number)->first();
            
            if (!$driver) {
                return response()->json(['success' => false, 'message' => 'Driver not found'], 404);
            }
            
            if ($driver->is_verified == 0) {
                return response()->json(['success' => false, 'message' => 'Verification Pending, Contact Admin For Approval'], 422);
            }
            
            $user = User::find($driver->user_id);
            
            $request->merge(['email' => $user->email,'password' => $driver->password]);
            $credentials = $request->only('phone_number', 'password'); 
            if (Auth::attempt(['phone_number' => $credentials['phone_number'], 'password' => $credentials['password']])) {
                $user = Auth::user();
                $token = $user->createToken('authToken')->plainTextToken;
                return response()->json(['success' => true, 'message' => 'Login Successful', 'token' => $token], 200);
            } else {
                return response()->json(['success' => false, 'message' => 'Invalid Email or Password'], 422);
            }
            
                
            
    }
    public function logout(Request $request)
    {
        $user = auth()->user();

        if ($user) {
            // Invalidate the user's session
            Session::invalidate();
        
            // Clear the user's remember token
            $user->setRememberToken(null);
        
            // Save the user to update the remember token
            $user->save();
        
            // Optionally, you can logout from Sanctum if you're using it
            auth()->user()->tokens()->delete();
        }

        return response()->json(['success' => 'true','message' => 'Logged Out Successfully'], 200);
    }
    public function signup_with_email(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:users',
            'password' => 'required',
        ]);
         if ($validator->fails()) {
             return response()->json(['success' => 'false','message' => $validator->errors()->first()], 422);
        }
        $user = new User();
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->save();
        $token = $user->createToken('authToken')->plainTextToken;
        if($user){
        return response()->json([ 'success' => 'true','message' => 'User Saved Successfully','token' => $token]);
        }else{
        return response()->json([ 'success' => 'false','message' => 'Error Occur Creating User']);  
        }
    }
    public function signup_with_phone_number(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone_number' => 'required',
        ]);
    
        if ($validator->fails()) {
            $errors = $validator->errors();
            return response()->json(['success' => false, 'message' => $errors->first()], 422);
        }
    
        $verificationCode = str_pad(mt_rand(0, 9999), 4, '0', STR_PAD_LEFT);
    
        // Save the verification code to the database
        DB::table('verification_codes')->insert([
            'phone_number' => $request->phone_number,
            'code' => $verificationCode,
        ]);
        // Send the verification code as an SMS using Twilio
        $twilio = new Client(env('TWILIO_SID'), env('TWILIO_TOKEN'));
        try {
            $message = $twilio->messages->create(
                "+".$request->phone_number,
                [
                    'from' => env('TWILIO_PHONE_NUMBER'),
                    'body' => "Your verification code is: $verificationCode",
                ]
            );
            if($message){
            return response()->json(['success' => true, 'message' => 'Verification code sent successfully'], 200);
            }else{
            return response()->json(['success' => true, 'message' => 'Error Sending Code'], 422);
            }
        } catch (Twilio\Exceptions\RestException $e) {
            // Log or handle the exception
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
    public function continue_social(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'social_name' => 'required|in:google,facebook',
            'email' => 'required|email',
            'gid' => 'required',
        ]);
    
        if ($validator->fails()) {
            return response()->json(['success' => 'false', 'message' => $validator->errors()->first()], 422);
        }
    
        $socialName = $request->social_name;
        $email = $request->email;
        $sid = $request->sid;
        $user = User::where('email',$email)->where('social_name',$socialName)->where('sid',$sid)->first();
        if($user){
            $token = $user->createToken('authToken')->plainTextToken;
        return response()->json(['success' => 'true','token' => $token, 'message' => 'Login Successful'], 200);
        }
         else{
        return response()->json(['success' => 'false', 'message' => 'Error Occur during Login'], 422);
        }
    }
    public function create_product(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'business_id' => 'required|exists:businesses,id',
            'name' => 'required',
            'details' => 'nullable',
            'price' => 'required',
            'discount' => 'nullable',
            'image_url' => 'nullable|url',
            'availability' => 'required|boolean',
            'available_sizes' => 'nullable',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first()], 422);
        }

        $product = Product::create($request->all());
         if($product){
        return response()->json(['success' => true, 'message' => 'Product created successfully'], 201);
        }else{
         return response()->json(['success' => false, 'message' => 'Error Creating Product'], 422);
        };
        
    }
     public function create_user_address(Request $request)
    {
        $validator = Validator::make($request->all(), [
        'address' => 'required',
        'title' => ['required', Rule::in(['home', 'work', 'other'])],
        'latitude' => 'required',
        'longitude' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first()], 422);
        }
        $user = Auth::user();
        $request->merge(['user_id' => $user->id]);
        $address = UserAddress::create($request->all());
         if($address){
        return response()->json(['success' => true, 'message' => 'Address Created successfully'], 201);
        }else{
         return response()->json(['success' => false, 'message' => 'Error Creating Address'], 422);
        };
    }
    public function get_hotspot()
    {
        $user = Auth::user();
        $business = Business::where('user_id', $user->id)->first();
        if(empty($business)){
            return response()->json(['success' => false, 'message' => 'Business Not Found'], 404);
        }
        if(!empty($business)){
        $business->user_id = intval($business->user_id);
        $business->delivery = intval($business->delivery);
        $business->pickup = intval($business->pickup);
        $business->rating = floatval($business->rating);
        $days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];
        foreach ($days as $day) {
            if ($business->$day == NULL) {
                $business->$day = 'close';
            }
        }
        $category = Category::find($business->category_id); 
        $business->category = $category->name;
        $business->delivery_time = intval($business->delivery_time);
        $business->promo_images = json_decode($business->promo_images);
        unset($business->category_id);
        }
        if ($business) {
            return response()->json(['business' => $business, 'success' => true, 'message' => 'Business Fetched successfully'], 200);
        } else {
            return response()->json(['success' => false, 'message' => 'Error Fetching Business'], 422);
        }
    }
      public function get_cart()
    {
        $user = Auth::user(); 
        $orderitems = OrderItem::with('product')->where('user_id',$user->id)->where('status','created')->get();
        if(count($orderitems) < 1){
            return response()->json(['success' => false, 'message' => 'Cart Not Found'], 404);
        }else{
             foreach($orderitems as $item){
            $item->quantity = intval($item->quantity);
            $item->product_id = intval($item->product_id);
            $item->user_id = intval($item->user_id);
            $business = Business::find($item->product->business_id);
            $business->user_id = intval($business->user_id);
            $business->delivery = intval($business->delivery);
            $business->pickup = intval($business->pickup);
            $business->rating = floatval($business->rating);
            $business->promo_images = json_decode($business->promo_images);
            $days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];
            foreach ($days as $day) {
                if ($business->$day == NULL) {
                    $business->$day = 'close';
                }
            }
            $category = Category::find($business->category_id); 
            $business->category = $category->name;
            $business->delivery_time = intval($business->delivery_time);
            unset($business->category_id);
          
            $item->product->business_id = intval($item->product->business_id);
            $item->product->availability = intval($item->product->availability);
            $item->product->featured = intval($item->product->featured);
            $item->product->popularity = intval($item->product->popularity);
            }
            if ($orderitems) {
                return response()->json(['orders' => $orderitems,'business' => $business, 'success' => true, 'message' => 'Order Items Fetched successfully'], 200);
            } else {
                return response()->json(['success' => false, 'message' => 'Error Fetching Order Items'], 422);
            }
        }
    }
     public function get_product_orders()
    {
        $user = Auth::user(); 
        
        $orders = Order::where('buyer_id', $user->id)->get();
        
        $response = [];
        foreach ($orders as $order) {
            $cart = Cart::find($order->cart_id);
            $order_ids = json_decode($cart->order_ids);
            foreach($order_ids as $order_id){
            $orderitem = OrderItem::find($order_id);
            $product = Product::find($orderitem->product_id);
            $response[] = [
                'product' => $product,
                'order' => $order
            ];
            }
        }
        if($response){
        return response()->json(['products' => $response,'success' => true, 'message' => 'Orders Products Fetched successfully'], 200);
        }else{
        return response()->json(['success' => false, 'message' => 'Error Fetching Orders Products'], 422);
        }
    }
     public function get_driver_orders()
        {
            $user = Auth::user(); 
            $driver = Driver::where('user_id',$user->id)->first();
            $orders = Order::where('driver_id', $driver->id)->get();
            $response = [];
            foreach ($orders as $order) {
                $cart = Cart::find($order->cart_id);
                $order_ids = json_decode($cart->order_ids);
                foreach($order_ids as $order_id){
                $orderitem = OrderItem::find($order_id);
                $product = Product::find($orderitem->product_id);
                $response[] = $order;
                }
            }
            if($response){
            return response()->json(['orders' => $response,'success' => true, 'message' => 'Driver Orders Fetched successfully'], 200);
            }else{
            return response()->json(['success' => false, 'message' => 'Error Fetching Driver Orders'], 422);
            }
        }


      public function get_vendors(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'category_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first()], 422);
        }
        $totalvendors = Business::where('category_id', $request->category_id)
                           ->get();
        $pageSize = $request->page_size ?? 10;
        $pageIndex = $request->page_index ?? 0; // 
        if(isset($request->search_text)){
        $vendors = Business::where('name', 'like', '%'.$request->search_text.'%')
                           ->where('category_id', $request->category_id)
                           ->skip($pageIndex * $pageSize)
                           ->take($pageSize) 
                           ->get();
        }else{
           $vendors = Business::where('category_id', $request->category_id)
                           ->skip($pageIndex * $pageSize)
                           ->take($pageSize) 
                           ->get();  
        }
        foreach($vendors as $business){
                $business->promo_images = json_decode($business->promo_images);
                $business->user_id = intval($business->user_id);
                $business->delivery = intval($business->delivery);
                $business->pickup = intval($business->pickup);
                $business->rating = floatval($business->rating);
                $days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];
                foreach ($days as $day) {
                    if ($business->$day == NULL) {
                        $business->$day = 'close';
                    }
                }
                $category = Category::find($business->category_id); 
                $business->category = $category->name;
                $business->delivery_time = intval($business->delivery_time);
                unset($business->category_id);
                
            }
        if($vendors){
        return response()->json(['vendors' => $vendors,'total_vendors' => count($totalvendors),'success' => true, 'message' => 'Vendors Fetched Successfully'], 200);
        }else{
         return response()->json(['success' => false, 'message' => 'Error Fetching Vendors'], 422);
        }
    }
      public function get_vendors_latest(Request $request)
    {
        $pageSize = $request->page_size ?? 10;
        $pageIndex = $request->page_index ?? 0;
        $total_vendors = Business::all();
        $businesses = Business::with('products')
            ->orderBy('created_at', 'desc')
            ->skip($pageIndex * $pageSize)
            ->take($pageSize)
            ->get();
    
        // Sort businesses based on the latest product added
        $businesses = $businesses->sort(function ($a, $b) {
            $latestProductA = $a->products->max('created_at');
            $latestProductB = $b->products->max('created_at');
            return $latestProductB <=> $latestProductA;
        });
    
        foreach ($businesses as $business) {
            $business->user_id = intval($business->user_id);
            $business->delivery = intval($business->delivery);
            $business->pickup = intval($business->pickup);
            $business->rating = floatval($business->rating);
            $days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];
            foreach ($days as $day) {
                if ($business->$day == NULL) {
                    $business->$day = 'close';
                }
            }
            $category = Category::find($business->category_id);
            $business->category = $category->name;
            $business->delivery_time = intval($business->delivery_time);
            $business->promo_images = json_decode($business->promo_images);
            unset($business->category_id);
        }
    
        $businesses = $businesses->values()->all();
     
        if ($businesses) {
            return response()->json(['total_vendors' => count($total_vendors),'vendors' => $businesses, 'success' => true, 'message' => 'Vendors Fetched Successfully'], 200);
        } else {
            return response()->json(['success' => false, 'message' => 'Error Fetching Vendors'], 422);
        }
    }

        
          public function get_vendor_for_you(Request $request)
        {
            $pageSize = $request->page_size ?? 10;
            $pageIndex = $request->page_index ?? 0; //
            $totalvendors = Business::all();
            if (!Auth::check()) {
                return response()->json(['success' => false, 'message' => 'User not authenticated'], 401);
            }
            if($request->longitude && $request->latitude){
            $user = Auth::user();
            $user_id = $user->id;
            if (!$user) {
                return response()->json(['success' => false, 'message' => 'User not found'], 404);
            }
            $user_latitude = $request->latitude;
            $user_longitude = $request->longitude;
            $previous_searches = Search::where('user_id', $user_id)->pluck('search_text')->toArray();
           $nearest_businesses = Business::select(
                'businesses.*',
                DB::raw('IF(businesses.latitude = '.$user_latitude.' AND businesses.longitude = '.$user_longitude.', 0, 
                    ( 6371 * acos( cos( radians('.$user_latitude.') ) * cos( radians( businesses.latitude ) ) 
                    * cos( radians( businesses.longitude ) - radians('.$user_longitude.') ) + sin( radians('.$user_latitude.') ) 
                    * sin( radians( businesses.latitude ) ) ) )) AS distance'))
                ->join('users', 'businesses.user_id', '=', 'users.id')
                ->skip($pageIndex * $pageSize)
                ->take($pageSize) 
                ->where(function ($query) use ($previous_searches) {
                    foreach ($previous_searches as $search) {
                    $query->orWhere('businesses.name', 'like', '%' . $search . '%');
                    }
                })

               ->orderByRaw('IF(distance IS NULL, 1, 0), distance')
                ->get();
            }else{
                $user = Auth::user();
                $user_id = $user->id;
                if (!$user) {
                    return response()->json(['success' => false, 'message' => 'User not found'], 404);
                }
                $previous_searches = Search::where('user_id', $user_id)->pluck('search_text')->toArray();
                  if (empty($previous_searches)) {
                    $nearest_businesses = Business::select('businesses.*')
                        ->join('users', 'businesses.user_id', '=', 'users.id')
                        ->skip($pageIndex * $pageSize)
                        ->take($pageSize) 
                        ->get();
                } else {
                    $searchPattern[] = '%' . implode(' ', $previous_searches) . '%';
                    $nearest_businesses = Business::select('businesses.*')
                        ->join('users', 'businesses.user_id', '=', 'users.id')
                        ->skip($pageIndex * $pageSize)
                        ->take($pageSize) 
                        ->orderByRaw("CASE WHEN businesses.name LIKE ? THEN 0 ELSE 1 END", implode(' ', $searchPattern))
                        ->get();
                }

            }
            if ($nearest_businesses->isEmpty()) {
                return response()->json(['success' => false, 'message' => 'No vendors found'], 404);
            }
            foreach($nearest_businesses as $business){
                 $business->user_id = intval($business->user_id);
                $business->delivery = intval($business->delivery);
                $business->pickup = intval($business->pickup);
                $business->promo_images = json_decode($business->promo_images);
                $business->rating = floatval($business->rating);
                $days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];
                foreach ($days as $day) {
                    if ($business->$day == NULL) {
                        $business->$day = 'close';
                    }
                }
                $category = Category::find($business->category_id); 
                $business->category = $category->name;
                $business->delivery_time = intval($business->delivery_time);
                unset($business->category_id);
                
            }
            return response()->json(['total_vendors' => count($totalvendors),'nearest_businesses' => $nearest_businesses, 'success' => true, 'message' => 'Vendors fetched successfully'], 200);
        }
      public function get_categories()
    {
        $categories = Category::all();
        if($categories){
        return response()->json(['categories' => $categories,'success' => true, 'message' => 'Categories Fetched successfully'], 200);
        }else{
         return response()->json(['success' => false, 'message' => 'Error Fetching Categories'], 422);
        }
    }
      public function get_trending_vendors()
    {
          $pageSize = $request->page_size ?? 10; // Number of items per page
          $pageIndex = $request->page_index ?? 0; // 
          $businesses = Business::orderBy('rating','desc')
          ->skip($pageIndex * $pageSize)
          ->take($pageSize)
          ->get();
          foreach($businesses as $business){
                 $business->user_id = intval($business->user_id);
                $business->delivery = intval($business->delivery);
                $business->pickup = intval($business->pickup);
                $business->promo_images = json_decode($business->promo_images);
                $business->rating = floatval($business->rating);
                $days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];
                foreach ($days as $day) {
                    if ($business->$day == NULL) {
                        $business->$day = 'close';
                    }
                }
                $category = Category::find($business->category_id); 
                $business->category = $category->name;
                $business->delivery_time = intval($business->delivery_time);
                unset($business->category_id);
                
            }
        if($businesses){
        return response()->json(['businesses' => $businesses,'success' => true, 'message' => 'Vendors Fetched successfully'], 200);
        }else{
         return response()->json(['success' => false, 'message' => 'Error Fetching Vendors'], 422);
        }
    }
    public function get_banners()
    {
        $promotedBusinesses = PromotedBusiness::all();
        $banners = [];
        foreach ($promotedBusinesses as $promotedBusiness) {
            $business = Business::find($promotedBusiness->business_id);
            if ($business && isset($business->promo_images)) {
                $promoImages = json_decode($business->promo_images, true);
                $promoImageIndex = $promotedBusiness->promo_image_index;
                if (isset($promoImages[$promoImageIndex])) {
                    $banners[] = $promoImages[$promoImageIndex];
                }
            }
        }
        if ($banners) {
            return response()->json(['banners' => $banners, 'success' => true, 'message' => 'Banners Fetched successfully'], 200);
        } else {
            return response()->json(['success' => false, 'message' => 'Error Fetching Banners'], 422);
        }
    }

    public function add_to_cart(Request $request)
    {
         $validator = Validator::make($request->all(), [
            'product_id' => 'required',
            'quantity' => 'required',
            'instruction' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first()], 422);
        }
        $user = Auth::user();
        $existingorderitemproduct = OrderItem::where('user_id',$user->id)->where('product_id',$request->product_id)->where('status','created')->first();
        if($existingorderitemproduct){
             return response()->json(["success" => false, "message" => "Product is already in your cart"], 422);
        }
        $existingorderitem = OrderItem::where('user_id',$user->id)->where('status','created')->first();
        if($existingorderitem){
        $existingproduct = Product::find($existingorderitem->product_id);
        $product = Product::find($request->product_id);
        $business = Business::find($existingproduct->business_id);
        $business->promo_images = json_decode($business->promo_images);
        $new_product_business = Business::find($product->business_id);
        if($business->name != $new_product_business->name){
             return response()->json(["success" => false, "message" => "Please Add Products of '$business->name' only"], 422);
        }
        }
        $orderitems = new OrderItem();
        $orderitems->product_id = $request->product_id;
        $orderitems->user_id = $user->id;
        $orderitems->quantity = $request->quantity;
        $orderitems->instruction = $request->instruction;
        $orderitems->save();
        if ($orderitems) {
            return response()->json(['orders' => $orderitems,'success' => true, 'message' => 'Product Added successfully'], 201);
        } else {
            return response()->json(['success' => false, 'message' => 'Error Selecting Cart'], 422);
        }
    }
       public function delete_from_cart(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'order_item_id' => 'required',
        ]);
    
        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first()], 422);
        }
    
        $orderItem = OrderItem::find($request->order_item_id);
        if (!$orderItem) {
            return response()->json(['success' => false, 'message' => 'Order item not found'], 404);
        }
        $user = Auth::user();
        $cart = Cart::where('user_id', $user->id)->where('status', 'created')->first();
        if($cart){
        $orderItemIds = json_decode($cart->order_ids);
        $index = array_search($request->order_item_id, $orderItemIds);
        if ($index !== false) {
            unset($orderItemIds[$index]);
            $cart->order_ids = array_values($orderItemIds);
            $cart->save();
        }
        }
         if(count($orderItemIds) < 1 && !empty($cart)){
            $cart->delete();
        }
        $delete = $orderItem->delete();
        if (!$delete) {
            return response()->json(['success' => false, 'message' => 'Error deleting product from cart'], 422);
        }
        return response()->json(['success' => true, 'message' => 'Product deleted from cart successfully'], 200);
    }

        public function verify_promo_code(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required',
        ]);
      
        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first()], 422);
        }
    
        $promocode = PromoCode::where('promo_code', $request->code)->where('validity', '!=', 0)->first();
    
        if ($promocode) {
            $user = Auth::user();
            $cart = Cart::where('user_id', $user->id)->where('status', 'created')->first();
            if(empty($cart)) {
                return response()->json(['success' => false, 'message' => 'Cart Not Found'], 404);
            }
            if($cart->is_discounted == 1) {
                return response()->json(['success' => false, 'message' => 'Promo Code Already Availed'], 422);
            }
            $cart->discount = ($cart->net_price * ($promocode->discount / 100));
            $cart->net_price = $cart->net_price - ($cart->net_price * ($promocode->discount / 100));
            $cart->promo_discount = $promocode->discount;
            $cart->is_discounted = 1;
            $cart->save();
            $cart->tip = intval($cart->tip);
            $cart->user_id = intval($cart->user_id);
            $cart->service_charges = strval($cart->service_charges);
            $cart->subtotal = strval($cart->subtotal);
            $cart->delivery_charges = strval($cart->delivery_charges);
            $cart->delivery_address = intval($cart->delivery_address);
            $cart->tax = strval($cart->tax);
            $cart->delivery_distance = strval($cart->delivery_distance);
            $cart->discount = strval($cart->discount);
            $cart->net_price = strval($cart->net_price);
            $cart->delivery_address = strval($cart->delivery_address);
            $order_ids = json_decode($cart->order_ids);
            $orders = [];
            foreach ($order_ids as $index => $order_id) {
                $order_item = OrderItem::with('product')->where('id', $order_id)->first();
                $order_item->product_id = intval($order_item->product_id);
                $order_item->user_id = intval($order_item->user_id);
                $order_item->quantity = intval($order_item->quantity);
                $order_item->product->business_id = intval($order_item->product->business_id);
                $order_item->product->availability = intval($order_item->product->availability);
                $order_item->product->featured = intval($order_item->product->featured);
                $order_item->product->popularity = intval($order_item->product->popularity);
                    if ($order_item) {
                        $orders = $order_item;
                    }
                }
    
            return response()->json([
                'cart' => $cart,
                'orders' => $orders,
                'success' => true,
                'message' => 'Promo Code Verified Successfully'
            ], 200);
        } else {
            return response()->json(['success' => false, 'message' => 'Error Verifying Promo Code'], 422);
        }
    }
    public function get_last_order_status(){
        $user = Auth::user();
        $order = Order::where('buyer_id',$user->id)->latest()->first();
        if($order){
            return response()->json([
                'order_status' => $order->order_status,
                'success' => true,
                'message' => 'Last Order Status Fetched Successfully'
            ], 200);
        }else{
           return response()->json(['success' => false, 'message' => 'Error Fetching Order Status'], 422);  
        }
    }

       public function submit_cart(Request $request)
    {
         $validator = Validator::make($request->all(), [
            'order_ids' => 'required',
            'quantities' => 'required',
        ]);
         if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first()], 422);
        }
    
        $order_ids = json_decode($request->order_ids);
        $quantities = json_decode($request->quantities);
        $user = Auth::user();
        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first()], 422);
        }
        $existingcart = Cart::where('user_id',$user->id)->where('status','created')->first();
        if ($existingcart) {
            $user = User::find($user->id);
            $address = UserAddress::find($user->address_id);
            $existingcart->user_id = $user->id;
            $existingcart->order_ids = $request->order_ids;
            $subtotal = 0;
            foreach ($order_ids as $index => $order_id) {
                $order = OrderItem::find($order_id);
                $order->quantity = $quantities[$index];
                $order->save();
                $product_id = $order->product_id;
                $product = Product::find($product_id);
                $order->product_id = intval($order->product_id);
                $order->user_id = intval($order->user_id);
                $order->quantity = intval($order->quantity);
                $order->product->business_id = intval($order->product->business_id);
                $order->product->availability = intval($order->product->availability);
                $order->product->featured = intval($order->product->featured);
                $order->product->popularity = intval($order->product->popularity);
                $business = Business::find($product->business_id);
                $discount = str_replace('%', '', $product->discount);
                $discounted_price = $product->price * (1-($discount / 100));
                $subtotal += $discounted_price * $quantities[$index];
            }
            $existingcart->subtotal = $subtotal;
            $existingcart->service_charges = $subtotal * 0.02;
            if($address){
            $userLat = $address->latitude;
            $userLng = $address->longitude;
            }else{
            $userLat = 0;
            $userLng = 0; 
            }
            $businessLat = $business->latitude;
            $businessLng = $business->longitude;
            $deliveryDistance = $this->calculateDistance($userLat, $userLng, $businessLat, $businessLng);
            $existingcart->delivery_charges = $deliveryDistance * 0.05;
            $existingcart->tax = $subtotal * 0.05;
            $existingcart->tip = 0;
            $provideddiscount = 0;
            $discount = 0;
            $orders = [];
            foreach ($order_ids as $index => $order_id) {
                $order_item = OrderItem::with('product')->where('id', $order_id)->first();
                $product_id = $order_item->product_id;
                if ($order_item) {
                    $orders[] = $order_item;
                }
                $product = Product::find($product_id);
                $order_item->product_id = intval($order_item->product_id);
                $order_item->user_id = intval($order_item->user_id);
                $order_item->quantity = intval($order_item->quantity);
                $order_item->product->business_id = intval($order_item->product->business_id);
                $order_item->product->availability = intval($order_item->product->availability);
                $order_item->product->featured = intval($order_item->product->featured);
                $order_item->product->popularity = intval($order_item->product->popularity);
                $discount += $product->price * ($provideddiscount / 100) * $quantities[$index];
            }
            $existingcart->discount = $discount;
            $promo_discount = 0;
            $existingcart->status = $request->status;
            $existingcart->shipping_type = '';
            $existingcart->net_price = $subtotal + $existingcart->service_charges + $existingcart->tip + $existingcart->delivery_charges + $existingcart->tax - $existingcart->discount - $promo_discount;
            $existingcart->delivery_distance = $deliveryDistance;
            $existingcart->delivery_address = $user->address_id;
            $existingcart->delivery_pickup = 'delivery';
            $existingcart->promo_discount = $promo_discount;
            $existingcart->status = 'created';
            if($existingcart->is_discounted == 1){
            $existingcart->is_discounted = 0;
            }
            $existingcart->save();
             $existingcart->promo_discount = strval(0);
            $existingcart->net_price = strval($existingcart->net_price);
            $existingcart->promo_discount = strval($existingcart->promo_discount);
            $existingcart->tax = strval($existingcart->tax);
            $existingcart->tip = intval($existingcart->tip);
            $existingcart->delivery_distance = strval($existingcart->delivery_distance);
            $existingcart->delivery_address = strval($existingcart->delivery_address);
            $existingcart->subtotal = strval($existingcart->subtotal);
            $existingcart->discount = strval($existingcart->discount);
            $existingcart->service_charges = strval($existingcart->service_charges);
            $existingcart->delivery_charges = strval($existingcart->delivery_charges);
             if ($existingcart) {
                return response()->json(['success' => true,'cart' => $existingcart,'orders' => $orders, 'message' => 'Cart Updated successfully'], 201);
            } else {
                return response()->json(['success' => false, 'message' => 'Error Updating Cart'], 422);
            }  
        }else{
            $cart = new Cart();
            $user = User::find($user->id);
            $address = UserAddress::find($user->address_id);
            $cart->user_id = $user->id;
            $cart->order_ids = $request->order_ids;
            $subtotal = 0;
            foreach ($order_ids as $index => $order_id) {
                $order = OrderItem::find($order_id);
                $order->quantity = $quantities[$index];
                $order->save();
                $product_id = $order->product_id;
                $product = Product::find($product_id);
                $order->product_id = intval($order->product_id);
                $order->user_id = intval($order->user_id);
                $order->quantity = intval($order->quantity);
                $order->product->business_id = intval($order->product->business_id);
                $order->product->availability = intval($order->product->availability);
                $order->product->featured = intval($order->product->featured);
                $order->product->popularity = intval($order->product->popularity);
                $business = Business::find($product->business_id);
                $discount = str_replace('%', '', $product->discount);
                $discounted_price = $product->price * (1-($discount / 100));
                $subtotal += $discounted_price * $quantities[$index];
            }
            $cart->subtotal = $subtotal;
            $cart->service_charges = $subtotal * 0.02;
            if($address){
            $userLat = $address->latitude;
            $userLng = $address->longitude;
            }else{
            $userLat = 0;
            $userLng = 0; 
            }
            $businessLat = $business->latitude;
            $businessLng = $business->longitude;
            $deliveryDistance = $this->calculateDistance($userLat, $userLng, $businessLat, $businessLng);
            $cart->delivery_charges = $deliveryDistance * 0.05;
            $cart->tax = $subtotal * 0.05;
            $cart->tip = 0;
            $provideddiscount = 0;
            $discount = 0;
            $orders = [];
            foreach ($order_ids as $index => $order_id) {
                $order_item = OrderItem::with('product')->where('id', $order_id)->first();
                $product_id = $order_item->product_id;
                if ($order_item) {
                    $orders[] = $order_item;
                }
                $product = Product::find($product_id);
                $order_item->product_id = intval($order_item->product_id);
                $order_item->user_id = intval($order_item->user_id);
                $order_item->quantity = intval($order_item->quantity);
                $order_item->product->business_id = intval($order_item->product->business_id);
                $order_item->product->availability = intval($order_item->product->availability);
                $order_item->product->featured = intval($order_item->product->featured);
                $order_item->product->popularity = intval($order_item->product->popularity);
                $discount += $product->price * ($provideddiscount / 100) * $quantities[$index];
            }
            $cart->discount = $discount;
            $promo_discount = 0;
            $cart->status = $request->status;
            $cart->shipping_type = '';
            $cart->net_price = $subtotal + $cart->service_charges + $cart->tip + $cart->delivery_charges + $cart->tax - $cart->discount - $promo_discount;
            $cart->delivery_distance = $deliveryDistance;
            $cart->delivery_address = $user->address_id;
            $cart->delivery_pickup = 'delivery';
            $cart->net_price = strval($cart->net_price);
            $cart->promo_discount = $promo_discount;
            $cart->status = 'created';
            $cart->save();
            $cart->tax = strval($cart->tax);
            $cart->tip = intval($cart->tip);
            $cart->delivery_address = strval($cart->delivery_address);
            $cart->subtotal = strval($cart->subtotal);
            $cart->delivery_distance = strval($cart->delivery_distance);
            $cart->discount = strval($cart->discount);
            $cart->service_charges = strval($cart->service_charges);
            $cart->delivery_charges = strval($cart->delivery_charges);
            $cart->net_price = strval($cart->net_price);
            $cart->promo_discount = strval($cart->promo_discount);
             if ($cart) {
                return response()->json(['success' => true,'cart' => $cart,'orders' => $orders, 'message' => 'Cart created successfully'], 201);
            } else {
                return response()->json(['success' => false, 'message' => 'Error Creating Cart'], 422);
            }
        }
        
    }
      public function update_shipment_type(Request $request)
    {
             $validator = Validator::make($request->all(), [
                'delivery_pickup' => 'required',
                'address_id' => 'required',
            ]);
             if ($validator->fails()) {
                return response()->json(['success' => false, 'message' => $validator->errors()->first()], 422);
            }
            $address_id = $request->address_id;
            $delivery_pickup = $request->delivery_pickup;
            if(!empty($address_id) && $delivery_pickup == 'delivery'){
            $address = UserAddress::find($request->address_id);
            $user = Auth::user();
            if($address){
            $userLat = $address->latitude;
            $userLng = $address->longitude;
            }else{
            $userLat = 0;
            $userLng = 0; 
            }
            $cart = Cart::where('user_id', $user->id)->where('status', 'created')->first();
            if(empty($cart)){
                return response()->json(['success' => false, 'message' => 'cart not found'], 404);
            }
            $order_ids = json_decode($cart->order_ids);
            foreach ($order_ids as $index => $order_id) {
            $order = OrderItem::find($order_id);
            $product_id = $order->product_id;
            $product = Product::find($product_id);
            $business = Business::find($product->business_id);
            }
            
            if(!empty($business)){
            $businessLat = $business->latitude;
            $businessLng = $business->longitude;
            
            $deliveryDistance = $this->calculateDistance($userLat, $userLng, $businessLat, $businessLng);
            }
            else{
                $deliveryDistance = 0;
            }
            $cart = Cart::where('user_id', $user->id)->where('status', 'created')->first();
            $cart->tip = 0;
            $cart->promo_discount = 0;
            $lnglimit = 77.391600;
            if ($userLng < 0) {
            $lngabs = -$userLng;
            }else{
            $lngabs = $userLng;   
            }
            if($lngabs > $lnglimit){
            $cart->delivery_charges = 7.00; 
            }else{
            $cart->delivery_charges = 5.00;   
            }
            $cart->discount = 0;
            $cart->net_price = $cart->subtotal + $cart->service_charges + $cart->tip + $cart->delivery_charges + $cart->tax - $cart->discount - $cart->promo_discount;
            $cart->delivery_distance = $deliveryDistance;
            $cart->delivery_address = $address_id;
            $cart->delivery_pickup = $request->delivery_pickup;
            $cart->save();
            }else{
            $user = Auth::user();
            $cart = Cart::where('user_id', $user->id)->where('status', 'created')->first();
            $cart->delivery_charges = 0;
            $cart->tip = 0;
            $cart->discount = 0;
            $cart->promo_discount = 0;
            $cart->net_price = $cart->subtotal + $cart->service_charges + $cart->tip + $cart->delivery_charges + $cart->tax - $cart->discount - $cart->promo_discount;
            $cart->delivery_pickup = $request->delivery_pickup;
            $cart->save();    
            }
            $cart->user_id = intval($cart->user_id);
            $cart->service_charges = strval($cart->service_charges);
            $cart->subtotal = strval($cart->subtotal);
            $cart->delivery_charges = strval($cart->delivery_charges);
            $cart->delivery_address = intval($cart->delivery_address);
            $cart->delivery_distance = strval($cart->delivery_distance);
            $cart->tax = strval($cart->tax);
            $cart->discount = strval($cart->discount);
            $cart->net_price = strval($cart->net_price);
            $cart->delivery_distance = strval($cart->delivery_distance);
            $cart->delivery_address = strval($cart->delivery_address);
            $cart->discount = strval($cart->discount);
            $cart->tip = intval($cart->tip);
            $cart->promo_discount = strval($cart->promo_discount);
            $order_ids = json_decode($cart->order_ids);
            $orders = [];
            foreach ($order_ids as $index => $order_id) {
                $order_item = OrderItem::with('product')->where('id', $order_id)->first();
                $order_item->product_id = intval($order_item->product_id);
                $order_item->user_id = intval($order_item->user_id);
                $order_item->quantity = intval($order_item->quantity);
                $order_item->product->business_id = intval($order_item->product->business_id);
                $order_item->product->availability = intval($order_item->product->availability);
                $order_item->product->featured = intval($order_item->product->featured);
                $order_item->product->popularity = intval($order_item->product->popularity);
                    if ($order_item) {
                        $orders[] = $order_item;
                    }
                }
                $cart->delivery_charges = strval($cart->delivery_charges);
            return response()->json([
                'cart' => $cart,
                'orders' => $orders,
                'success' => true,
                'message' => 'Cart Shipment Type Updated Successfully'
            ], 200);
    }
    public function update_availablity(Request $request)
    {
             $validator = Validator::make($request->all(), [
                'online_offline' => 'required',
            ]);
             if ($validator->fails()) {
                return response()->json(['success' => false, 'message' => $validator->errors()->first()], 422);
            }
            $user = Auth::user();
            $driver = Driver::where('user_id',$user->id)->first();
            $order = Order::find($driver->offered_order);
            $driver->availability = $request->online_offline;
            $driver->save();
            if($driver){
            return response()->json([
                'success' => true,
                'message' => 'Availability Updated Successfully'
            ], 200);
            }
            else{
                return response()->json([
                'success' => false,
                'message' => 'Error Updating Status'
            ], 422);
            }
    }
    public function dropoff_order()
    {
            $user = Auth::user();
            $driver = Driver::where('user_id',$user->id)->first();
            $order = Order::find($driver->offered_order);
            $order->delivery_stage = 4;
            $order->order_status = 'delivered';
            $driver->offered_order = NULL;
            $driver->save();
            $wallet = new DriverWallet();
            $wallet->driver_id = $driver->id;
            $wallet->action = "delivery";
            $wallet->amount = $order->driver_payment;
            $wallet->save();
            if($order->save()){
            return response()->json([
                'success' => true,
                'message' => 'Order Status Updated Successfully'
            ], 200);
            }
            else{
                return response()->json([
                'success' => false,
                'message' => 'Error Updating Status'
            ], 422);
            }
    }
    public function update_driver_location(Request $request)
    {
            
            $user = Auth::user();
            $driver = Driver::where('user_id',$user->id)->first();
            $driver->latitude = $request->driver_latitude;
            $driver->longitude = $request->driver_longitude;
            if($driver->save()){
            return response()->json([
                'success' => true,
                'message' => 'Driver Address Updated Successfully'
            ], 200);
            }
            else{
                return response()->json([
                'success' => false,
                'message' => 'Error Updating Driver Address'
            ], 422);
            }
    }
      public function pickup_order()
    {
            $user = Auth::user();
            $driver = Driver::where('user_id',$user->id)->first();
            $order = Order::find($driver->offered_order);
            $order->delivery_stage = 3;
            if($order->save()){
            return response()->json([
                'success' => true,
                'message' => 'Order Status Updated Successfully'
            ], 200);
            }
            else{
                return response()->json([
                'success' => false,
                'message' => 'Error Updating Availability'
            ], 422);
            }
    }
        public function accept_reject_order(Request $request)
    {
             $validator = Validator::make($request->all(), [
                'accept_reject' => 'required',
            ]);
             if ($validator->fails()) {
                return response()->json(['success' => false, 'message' => $validator->errors()->first()], 422);
            }
            $user = Auth::user();
            if($request->accept_reject == 'accept'){
            $driver = Driver::where('user_id',$user->id)->first();
            $order = Order::find($driver->offered_order);
            $buyer = User::find($order->buyer_id);
            $orderitem = OrderItem::where('user_id',$buyer->id)->first();
            $product = Product::find($orderitem->product_id);
            $buyeraddress = UserAddress::find($buyer->address_id);
            $driverLat = $driver->latitude;
            $driverLng = $driver->longitude;
             if($buyeraddress){
            $buyerLat = $buyeraddress->latitude;
            $buyerLng = $buyeraddress->longitude;
            }else{
            $buyerLat = 0;
            $buyerLng = 0; 
            }
            $business = Business::find($product->business_id);
            $businessLat = $business->latitude;
            $businessLng = $business->longitude;
            $driverbusinessDistance = $this->calculateDistance($driverLat, $driverLng, $businessLat, $businessLng);
            $buyerbusinessDistance = $this->calculateDistance($buyerLat, $buyerLng, $businessLat, $businessLng);
            $totaldriverdistance = $driverbusinessDistance + $buyerbusinessDistance;
            $order->driver_id = $driver->id;
            $order->driver_distance = $totaldriverdistance;
            $order->driver_payment = $totaldriverdistance * 0.05;
            $order->delivery_stage = 2;
            $drivers = Driver::where('user_id','!=',$user->id)->where('offered_order',$driver->offered_order)->get();
            foreach($drivers as $driver){
                $driver->offered_order = NULL;
                $driver->save();
            }
            if($order->save()){
            return response()->json([
                'success' => true,
                'message' => 'Order Accepted Successfully'
            ], 200);
            }
            else{
                return response()->json([
                'success' => false,
                'message' => 'Error Accepting Order'
            ], 422);
            }
            }
            else{
                $driver = Driver::where('user_id',$user->id)->first();
                $driver->offered_order = NULL;
                $driver->save();
                  return response()->json([
                'success' => true,
                'message' => 'Order Rejected'
            ], 200);
            }
    }
     public function get_last_offer(Request $request)
    {
            $user = Auth::user();
            $driver = Driver::where('user_id',$user->id)->first();
            $order = Order::find($driver->offered_order);
            $buyer = User::find($order->buyer_id);
            $orderitem = OrderItem::where('user_id',$buyer->id)->first();
            $product = Product::find($orderitem->product_id);
            $buyeraddress = UserAddress::find($buyer->address_id);
            $driverLat = $driver->latitude;
            $driverLng = $driver->longitude;
             if($buyeraddress){
            $buyerLat = $buyeraddress->latitude;
            $buyerLng = $buyeraddress->longitude;
            }else{
            $buyerLat = 0;
            $buyerLng = 0; 
            }
            $business = Business::find($product->business_id);
            $businessLat = $business->latitude;
            $businessLng = $business->longitude;
            $driverbusinessDistance = $this->calculateDistance($driverLat, $driverLng, $businessLat, $businessLng);
            $buyerbusinessDistance = $this->calculateDistance($buyerLat, $buyerLng, $businessLat, $businessLng);
            $totaldriverdistance = $driverbusinessDistance + $buyerbusinessDistance;
            $order->buyer = User::find($order->buyer_id);
            $order->buyer->address = UserAddress::find($order->buyer->address_id);
            $order->driver = $driver;
            $order->vendor = Business::find($order->vendor_id);
            $order->driver_distance = strval($totaldriverdistance);
            $order->driver_payment = strval($totaldriverdistance * 0.05);
            if($order){
            return response()->json(['order' => $order,
                'success' => true,
                'message' => 'Order Details Fetched Successfully'
            ], 200);
            }
            else{
                return response()->json([
                'success' => false,
                'message' => 'Error Fetching Order Details'
            ], 422);
            }

    }
    public function get_current_order(Request $request)
    {
            $user = Auth::user();
            $order = Order::where('buyer_id',$user->id)->where('order_status','active')->first();
            if($order){
            $driver = Driver::find($order->driver_id);
            }else{
              $order = Order::where('buyer_id',$user->id)->where('order_status','delivered')->latest()->first();
              $driver = Driver::find($order->driver_id);
            }
            $order->buyer = User::find($order->buyer_id);
            $order->buyer->address = UserAddress::find($order->buyer->address_id);
            if($driver){
            $order->driver = $driver;
            }
            $order->vendor = Business::find($order->vendor_id);
            if($order){
            return response()->json(['order' => $order,
                'success' => true,
                'message' => 'Order Details Fetched Successfully'
            ], 200);
            }
            else{
                return response()->json([
                'success' => false,
                'message' => 'Error Fetching Order Details'
            ], 422);
            }
    }
       public function place_order(Request $request)
    {
             $validator = Validator::make($request->all(), [
                'cart_id' => 'required',
                'payment_response' => 'required',
            ]);
             if ($validator->fails()) {
                return response()->json(['success' => false, 'message' => $validator->errors()->first()], 422);
            }
            
            $user = Auth::user();
            $order = new Order();
            $existingcart = Cart::where('id',$request->cart_id)->where('status','ordered')->first();
            $cart1 = Cart::find($request->cart_id);
            $order_ids = json_decode($cart1->order_ids);
            foreach ($order_ids as $index => $order_id) {
                $order_item = OrderItem::where('id', $order_id)->update(['status' => 'ordered']);
            }
            if($existingcart){
            return response()->json(['success' => false, 'message' => 'Order Already Placed'], 422);
            }
            $cart = Cart::where('id',$request->cart_id)->update(['status' => 'ordered']);
            
            $order->cart_id = $request->cart_id;
            $order->order_no = '';
            $order->order_date = time();
            $orderitem = OrderItem::where('user_id',$user->id)->first();
            $product = Product::find($orderitem->product_id);
            $order->vendor_id = $product->business_id;
            $order->buyer_id = $user->id;
            $driver = User::where('user_type','Driver')->first();
            // $order->driver_id = $driver->id;
            $order->payment_response = $request->payment_response;
            $order->save();
            $order->order_no = $order->id;
            $order->save();
            $order->vendor_id = intval($order->vendor_id);
            return response()->json([
                'order' => $order,
                'success' => true,
                'message' => 'Order Placed Successfully'
            ], 200);
            
    }
    public function add_tip_to_cart(Request $request)
    {
             $validator = Validator::make($request->all(), [
                'tip' => 'required',
            ]);
             if ($validator->fails()) {
                return response()->json(['success' => false, 'message' => $validator->errors()->first()], 422);
            }
            $user = Auth::user();
            $cart = Cart::where('user_id', $user->id)->where('status', 'created')->first();
            $cart->tip = $request->tip;
            $cart->net_price = $cart->net_price + $cart->tip;
            $cart->save();
            $cart->user_id = intval($cart->user_id);
            $cart->service_charges = strval($cart->service_charges);
            $cart->subtotal = strval($cart->subtotal);
            $cart->delivery_charges = strval($cart->delivery_charges);
            $cart->delivery_address = strval($cart->delivery_address);
            $cart->delivery_distance = strval($cart->tax);
            $cart->tax = strval($cart->tax);
            $cart->discount = strval($cart->discount);
            $cart->tip = intval($cart->tip);
            $cart->promo_discount = strval($cart->promo_discount);
            $cart->net_price = strval($cart->net_price);
            $order_ids = json_decode($cart->order_ids);
            $orders = [];
            foreach ($order_ids as $index => $order_id) {
                $order_item = OrderItem::with('product')->where('id', $order_id)->first();
                $order_item->product_id = intval($order_item->product_id);
                $order_item->user_id = intval($order_item->user_id);
                $order_item->quantity = intval($order_item->quantity);
                $order_item->product->business_id = intval($order_item->product->business_id);
                $order_item->product->availability = intval($order_item->product->availability);
                $order_item->product->featured = intval($order_item->product->featured);
                $order_item->product->popularity = intval($order_item->product->popularity);
                    if ($order_item) {
                        $orders[] = $order_item;
                    }
                }
            return response()->json([
                'cart' => $cart,
                'orders' => $orders,
                'success' => true,
                'message' => 'Tip Added To Cart Successfully'
            ], 200);
    }
   public function calculateDistance($lat1, $lon1, $lat2, $lon2)
    {
        $earthRadius = 6371; // Earth's radius in kilometers
        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);
        $a = sin($dLat / 2) * sin($dLat / 2) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * sin($dLon / 2) * sin($dLon / 2);
        $c = 2 * asin(sqrt($a));
        $distance = $earthRadius * $c; // Distance in kilometers
        return $distance;
    }
     public function get_business_products()
    {
        $user = Auth::User();
        $business = Business::where('user_id',$user->id)->first();
        $business->promo_images = json_decode($business->promo_images);
        $products = Product::where('business_id',$business->id)->get();
        if($products){
        foreach($products as $product){
        $product->business_id = intval($product->business_id);
        $product->availability = intval($product->availability);
        $product->featured = intval($product->featured);
        $product->popularity = intval($product->popularity);
        }
        return response()->json(['business_products' => $products,'success' => true, 'message' => 'Business Products Fetched successfully'], 200);
        }else{
         return response()->json(['success' => false, 'message' => 'Error Fetching Business Products'], 422);
        }
    }
    
    public function get_business_products_by_id(Request $request)
    {
        $id = $request->vendor_id;
        $business = Business::find($id);
        $business->promo_images = json_decode($business->promo_images);
        if($request->product_type == 'featured'){
        $products = Product::where('business_id',$business->id)->where('featured',1)->orderBy('popularity', 'desc')->get(); 
        }else{
        $products = Product::where('business_id',$business->id)->orderBy('popularity', 'desc')->get();
        }
        if($products){
     foreach($products as $product){
        $product->business_id = intval($product->business_id);
        $product->availability = intval($product->availability);
        $product->featured = intval($product->featured);
        $product->popularity = intval($product->popularity);
        }
        return response()->json(['business_products' => $products,'success' => true, 'message' => 'Business Products Fetched successfully'], 200);
        }else{
         return response()->json(['success' => false, 'message' => 'Error Fetching Business Products'], 422);
        }
    }
    public function update_product(Request $request, $id)
    {
        $product = Product::find($id);
        if (!$product) {
            return response()->json(['success' => false, 'message' => 'Product not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'business_id' => 'required|exists:businesses,id',
            'name' => 'required',
            'details' => 'nullable',
            'price' => 'required',
            'discount' => 'nullable',
            'image_url' => 'nullable|url',
            'availability' => 'required|boolean',
            'available_sizes' => 'nullable',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first()], 422);
        }

        $update = $product->update($request->all());
        if($update){
        return response()->json(['success' => true, 'message' => 'Product updated successfully'], 200);
        }else{
         return response()->json(['success' => false, 'message' => 'Error Updating Products'], 422);
        }
    }
    public function update_hotspot(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'location' => 'required',
            'delivery' => 'required',
            'pickup' => 'required',
            'monday' => 'nullable|string',
            'tuesday' => 'nullable|string',
            'wednesday' => 'nullable|string',
            'thursday' => 'nullable|string',
            'friday' => 'nullable|string',
            'saturday' => 'nullable|string',
            'sunday' => 'nullable|string',
            'business_status' => 'required|in:requested,rejected,open,close',
            'business_image' => 'nullable|string',
            'logo_image' => 'nullable|string',
            'promo_image_index' => 'nullable|string',
            'promo_images' => 'nullable|string',
            'category' => 'required|string',
            // 'rating' => 'required|numeric',
            'delivery_time' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first()], 422);
        }

        $business = Business::where('email',$request->email)->first();
        if (!$business) {
            return response()->json(['success' => false, 'message' => 'Business not found'], 404);
        }
        $business->user_id = Auth::id();
        
        $category = Category::where('name', $request->category)->first();
        if (!$category) {
            $category = new Category();
            $category->name = $request->category;
            $category->save();
        }
        $business->category_id = $category->id;
        $business->promo_images = json_decode($business->promo_images);
        $update = $business->update($request->all());
        $promotedbusiness = new PromotedBusiness;
        $promotedbusiness->business_id = $business->id;
        $promotedbusiness->promo_image_index = $request->promo_image_index;
        $promotedbusiness->save();
         if($update){
        return response()->json(['business' => $business,'success' => true, 'message' => 'Business updated successfully'], 200);
        }else{
         return response()->json(['success' => false, 'message' => 'Error Updating Hotspot'], 422);
        };
    }

   public function create_hotspot(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:businesses,email',
            'phone' => 'required',
            'location' => 'required',
            'delivery' => 'required',
            'pickup' => 'required',
            'monday' => 'nullable|string',
            'tuesday' => 'nullable|string',
            'wednesday' => 'nullable|string',
            'thursday' => 'nullable|string',
            'friday' => 'nullable|string',
            'saturday' => 'nullable|string',
            'sunday' => 'nullable|string',
            'business_status' => 'required|in:requested,rejected,open,close',
            'business_image' => 'nullable|string',
            'logo_image' => 'nullable|string',
            'category' => 'required|string',
            // 'rating' => 'required|numeric',
            'delivery_time' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first()], 422);
        }
    
        $user = Auth::user();
        $oldBusiness = Business::where('user_id', $user->id)->first();
        if ($oldBusiness) {
            return response()->json(['success' => false, 'message' => 'Business Already Exists for this user'], 422);
        }
    
        $category = Category::where('name', $request->category)->first();
        if (!$category) {
            $category = new Category();
            $category->name = $request->category;
            $category->save();
        }

        $business = new Business($request->all());
        $business->user_id = Auth::id();
        $business->category_id = $category->id;
        $business->save();
       $business->promo_images = json_decode($business->promo_images);
        if ($business) {
            return response()->json(['business' => $business,'success' => true, 'message' => 'Business created successfully'], 201);
        } else {
            return response()->json(['success' => false, 'message' => 'Error Creating Business'], 422);
        }
    }
    public function get_user_addresses()
    {
        $user = Auth::user();
        $addresses = UserAddress::where('user_id',$user->id)->get();
        return response()->json([ 'user_addresses' => $addresses,'success' => 'true','message' => 'User Addresses Fetched Successfully']);
    }
    public function get_profile()
    {
        $user = Auth::user();
        $address = UserAddress::find($user->address_id);
        return response()->json([ 'user_current_address' => $address,'user' => $user,'success' => 'true','message' => 'Profile Details Fetched Successfully']);
    }
    public function update_profile(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'phone_number' => 'required',
            'address_id' => 'required',
        ]);
         if ($validator->fails()) {
             return response()->json(['success' => 'false','message' => $validator->errors()->first()], 422);
        }
        $user = Auth::user();
        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'user_role' => $request->user_role,
            'phone_number' => $request->phone_number,
            'image' => $request->image,
            'address_id' => $request->address_id,
        ];
        $user->update($data);
        $address = UserAddress::where('user_id',$user->id)->where('id',$user->address_id)->first();
        return response()->json([ 'user_current_address' => $address,'user' => $user,'success' => 'true','message' => 'User Updated Successfully']);
    }
    public function upload_image(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'image_file' => 'required',
            'image_type' => 'required',
        ]);
         if ($validator->fails()) {
            if ($errors->has('image_file')) {
                return response()->json(['success' => 'false','message' => $errors->first('image_file')], 422);
            }
            if ($errors->has('image_type')) {
                return response()->json(['success' => 'false','message' => $errors->first('image_type')], 422);
            }
        }
        if($request->image_type == 'business_image'){
        $imageName = time().'.'.$request->image_file->extension();
        $request->image_file->move(public_path('business/business_image'), $imageName);
        $imagePath = 'business/business_image/'.$imageName; 
        return response()->json([ 'success' => 'true','image_url'=> $imagePath,'message' => 'Business Image Uploaded Successfully']);
        }
         else if($request->image_type == 'logo_image'){
        $imageName = time().'.'.$request->image_file->extension();
        $request->image_file->move(public_path('business/logo_image'), $imageName);
        $imagePath1 = 'business/logo_image/'.$imageName; 
        return response()->json([ 'success' => 'true','image_url'=> $imagePath1,'message' => 'Logo Image Uploaded Successfully']);
        }
         else if($request->image_type == 'promo_image'){
        $imageName = time().'.'.$request->image_file->extension();
        $request->image_file->move(public_path('business/promo_image'), $imageName);
        $imagePath2 = 'business/promo_image/'.$imageName; 
        return response()->json([ 'success' => 'true','image_url'=> $imagePath2,'message' => 'Promo Image Uploaded Successfully']);
        }
        else if($request->image_type == 'product_image'){
        $imageName = time().'.'.$request->image_file->extension();
        $request->image_file->move(public_path('product_image'), $imageName);
        $imagePath2 = 'product_image/'.$imageName; 
        return response()->json([ 'success' => 'true','image_url'=> $imagePath2,'message' => 'Product Image Uploaded Successfully']);
        }
        else{
        $imageName = time().'.'.$request->image_file->extension();
        $request->image_file->move(public_path('user/profile_images'), $imageName);
        $imagePath3 = 'user/profile_images/'.$imageName; 
        return response()->json([ 'success' => 'true','image_url'=> $imagePath3,'message' => 'Profile Image Uploaded Successfully']);
        }
        
        }
   
}
