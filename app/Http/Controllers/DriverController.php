<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\UserAddress;
use App\Models\Driver;
use Illuminate\Http\Request;

class DriverController extends Controller
{
    public function index()
    {
        $drivers = Driver::all();
        return view('drivers.index', compact('drivers'));
    }

    public function create()
    {
        return view('drivers.create');
    }
 public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone_number' => 'nullable|string|max:255',
            'latitude' => 'required|string|max:255',
            'longitude' => 'required|string|max:255',
            'passcode' => 'nullable|string|max:255',
            'vehicle_make' => 'nullable|string|max:255',
            'vehicle_color' => 'nullable|string|max:255',
            'vehicle_model' => 'nullable|string|max:255',
            'vehicle_model_year' => 'nullable|string|max:255',
            'select_island' => 'required',
            'vehicle_license_plate' => 'nullable|string|max:255',
            'license_front' => 'nullable|image|max:2048',
            'license_back' => 'nullable|image|max:2048',
            'image' => 'nullable|image|max:2048',
            'license_back' => 'nullable|image|max:2048',
        ]);
         if ($validated['phone_number'] && strpos($validated['phone_number'], '+1') !== 0) {
                $validated['phone_number'] = '+1' . $validated['phone_number'];
            }
        if ($request->hasFile('license_front')) {
            $imageName = 'license_front'.time().'.'.$validated['license_front']->extension();
            $validated['license_front']->move(public_path(), $imageName);
    
             $imagePath1 = '/'.$imageName;   
             $validated['license_front'] = $imagePath1;
        }
        
        if ($request->hasFile('image')) {
            $imageName3 = 'ProfileImage'.time().'.'.$validated['image']->extension();
            $validated['image']->move(public_path('user/profile_images'), $imageName3);
            $imagePath3 = 'user/profile_images/'.$imageName3; 
            $validated['image'] = $imagePath3;
        }
        if ($request->hasFile('license_back')) {
            $imageName2 = 'license_back'.time().'.'.$validated['license_back']->extension();
            $validated['license_back']->move(public_path(), $imageName2);
    
             $imagePath2 = '/'.$imageName2;   
             $validated['license_back'] = $imagePath2;
        }
        $validated['password'] =  $validated['passcode'].'_'.$validated['first_name'];
        Driver::create($validated);
        return redirect()->route('drivers.index')->with('success', 'Driver created successfully.');
    }

    public function show(Driver $driver)
    {
        return view('drivers.show', compact('driver'));
    }
    public function verify(Driver $driver)
    {
        $driver = Driver::find($driver->id);
        $driver->is_verified = 1;
        $user = new User();
        $user->email = $driver->email;
        $user->password = $driver->password;
        $user->phone_number = $driver->phone_number;
        $user->image = $driver->image;
        $user->user_type = 'Driver';
        $user->name = $driver->first_name.' '.$driver->last_name;
        $user->save();
        $address = new UserAddress();
        $address->title = 'work';
        $address->address = $driver->select_island;
        $address->user_id = $user->id;
        $address->save();
        $user->address_id = $address->id;
        $user->save();
        $driver->user_id = $user->id;
        $driver->save();
        if($driver){
        return redirect()->route('drivers.index')->with('success', 'Driver created successfully.');
        }
    }
    public function edit(Driver $driver)
    {
        return view('drivers.edit', compact('driver'));
    }

    public function update(Request $request, Driver $driver)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone_number' => 'nullable|string|max:255',
            'latitude' => 'required|string|max:255',
            'longitude' => 'required|string|max:255',
            'passcode' => 'nullable|string|max:255',
            'vehicle_color' => 'nullable|string|max:255',
            'vehicle_make' => 'nullable|string|max:255',
            'vehicle_model' => 'nullable|string|max:255',
            'vehicle_model_year' => 'nullable|string|max:255',
            'vehicle_licence_plate' => 'nullable|string|max:255',
            'license_front' => 'nullable|image|max:2048',
            'license_back' => 'nullable|image|max:2048',
             'select_island' => 'required',
        ]);
         if ($validated['phone_number'] && strpos($validated['phone_number'], '+1') !== 0) {
                $validated['phone_number'] = '+1' . $validated['phone_number'];
            }
              $request->hasFile('license_front');
        if ($validated['license_front']) {
            $imageName = time().'.'.$validated['license_front']->extension();
          
            $validated['license_front']->move(public_path(), $imageName);
    
             $imagePath1 = '/'.$imageName;   
             $validated['license_front'] = $imagePath1;
        }

        if ($validated['license_back']) {
            $imageName = time().'.'.$validated['license_back']->extension();
          
            $validated['license_back']->move(public_path(), $imageName);
             $imagePath1 = '/'.$imageName;   
             $validated['license_back'] = $imagePath1;
        }
        $driver->update($validated);
        
        return redirect()->route('drivers.index')->with('success', 'Driver updated successfully.');
    }

    public function destroy(Driver $driver)
    {
        $user = User::find($driver->user_id);
        dd($driver);
        $user->delete();
        $driver->delete();
        return redirect()->route('drivers.index')->with('success', 'Driver deleted successfully.');
    }
}
