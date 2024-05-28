<?php
namespace App\Http\Controllers;
use App\Models\DomainSteps;
use App\Models\Order;
use App\Models\Driver;
use App\Models\Country;
use App\Models\orderAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use App\Mail\orderEmail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
class orderController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $driver = Driver::where('user_id',$user->id)->first();
        $orders = Order::where('driver_id',$driver->id)->get();
        return view('order.index', compact('orders','user'));
    }

    public function create()
    {
        $user = Auth::user();
        return view('order.create',compact('user'));
    }

    public function store(Request $request)
    {
       
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:orders',
            'password' => 'required',
            'phone_number' => 'required',
            'address' => 'required'
        ]);
        
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        $address = new orderAddress();
        $address->address = $request->address;
        $address->save();
        $order = new order();
        $order->name = $request->name;
        $order->email = $request->email;
        $order->image = $request->image;
        $order->address_id = $address->id;
        $order->password = bcrypt($request->password);
        $order->save();
        // Mail::to($order->email)->send(new orderEmail($order->email, $password, url('login')));
        return redirect()->route('order.index')->with('success', 'Order created successfully.');
    }
    

    public function show()
    {
        $order_id = $_GET['order_id'];
        $order = Order::find($order_id);
        $user = Auth::user();
        return view('order.show', compact('order','user'));
    }

    public function edit()
    {
        $order_id = $_GET['order_id'];
        $order = Order::find($order_id);
        $order->address = orderAddress::find($order->address_id);
       
        return view('order.edit', compact('order'));
    }

    public function update(Request $request, order $order)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'phone_number' => 'required',
            'address' => 'required'
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        $address = orderAddress::where('order_id',$order->id)->first();
        if($address){
        $address->address = $request->address;
        $address->save();
        }else{
        $address = new orderAddress();
        $address->address = $request->address;
        $address->order_id = $order->id;
        $address->save(); 
        }
        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'phone_number' => $request->phone_number,
            'address_id' => $address->id
        ];
        // if ($request->hasFile('image')) {
        //     $imageName = time().'.'.$request->image->extension();
        //     $request->image->move(public_path('img'), $imageName);
        //     $data['image'] = 'img/'.$imageName;
        // }
        $order->update($data);
    
        return redirect()->route('order.index')->with('success', 'Order updated successfully.');
    }
    

    public function destroy(order $order)
    {
       
        $order->delete();
        return redirect()->route('order.index')->with('success', 'Order deleted successfully.');
    }
}
