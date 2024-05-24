<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Business;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
class BusinessController extends Controller
{
    public function index()
    { 
        $user = Auth::user();
        $businesses = Business::all();
        return view('business.index', compact('businesses','user'));
    }

    public function create()
    {
        $user = Auth::user();
        return view('business.create',compact('user'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'user_id' => 'required|string',
            'email' => 'required|string',
            'phone' => 'required|string',
            'location' => 'required|string',
            'delivery' => 'required|string',
            'pickup' => 'required|string',
            'monday' => 'required|string',
            'tuesday' => 'required|string',
            'wednesday' => 'required|string',
            'thursday' => 'required|string',
            'friday' => 'required|string',
            'saturday' => 'required|string',
            'sunday' => 'required|string',
            'business_status' => 'required|string',
            'business_image' => 'required|string',
            'logo_image' => 'required|string',
            'promo_images' => 'required|string',
            'category_id' => 'required|string',
            'rating' => 'required|string',
            'delivery_time' => 'required|string',
            'latitude' => 'required|string',
            'longitude' => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        Business::create($request->all());

        return redirect()->route('business.index')->with('success', 'Business created successfully.');
    }

    // public function edit()
    // {
    //     $user = Auth::user();
    //     $id = $_GET['business_id'];
    //     $business = Business::findOrFail($id);
    //     return view('business.edit', compact('business','user'));
    // }
  public function show()
    {
        $business_id = $_GET['business_id'];
        $business = Business::find($business_id);
        $user = Auth::user();
        return view('business.show', compact('business','user'));
    }
    // public function update(Request $request)
    // {
    //     $id = $_GET['business_id'];
    //     $validator = Validator::make($request->all(), [
    //         'name' => 'required|string|max:255',
    //         'user_id' => 'required|string',
    //         'email' => 'required|string',
    //         'phone' => 'required|string',
    //         'location' => 'required|string',
    //         'delivery' => 'required|string',
    //         'pickup' => 'required|string',
    //         'monday' => 'required|string',
    //         'tuesday' => 'required|string',
    //         'wednesday' => 'required|string',
    //         'thursday' => 'required|string',
    //         'friday' => 'required|string',
    //         'saturday' => 'required|string',
    //         'sunday' => 'required|string',
    //         'business_status' => 'required|string',
    //         'business_image' => 'required|string',
    //         'logo_image' => 'required|string',
    //         'promo_images' => 'required|string',
    //         'category_id' => 'required|string',
    //         'rating' => 'required|string',
    //         'delivery_time' => 'required|string',
    //         'latitude' => 'required|string',
    //         'longitude' => 'required|string',
    //     ]);

    //     if ($validator->fails()) {
    //         return redirect()->back()->withErrors($validator)->withInput();
    //     }

    //     $business = Business::findOrFail($id);
    //     $business->update($request->all());

    //     return redirect()->route('business.index')->with('success', 'Business updated successfully.');
    // }

    public function destroy($id)
    {
        $business = Business::findOrFail($id);
        $business->delete();

        return redirect()->route('business.index')->with('success', 'Business deleted successfully.');
    }
}
