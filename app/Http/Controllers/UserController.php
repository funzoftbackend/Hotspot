<?php
namespace App\Http\Controllers;
use App\Models\DomainSteps;
use App\Models\User;
use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use App\Mail\UserEmail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
class UserController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $users = User::where('id','!=',$user->id)->get();
        return view('user.index', compact('users','user'));
    }

    public function create()
    {
        $user = Auth::user();
        return view('user.create',compact('user'));
    }

    public function store(Request $request)
    {
       
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'image' => 'required',
            'address_id' => 'required'
        ]);
        
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->image = $request->image;
        $user->address_id = $request->address_id;
        $user->password = bcrypt($request->password);
        $user->save();
        // Mail::to($user->email)->send(new UserEmail($user->email, $password, url('login')));
        return redirect()->route('user.index')->with('success', 'User created successfully.');
    }
    

    public function show(User $user)
    {
        $user = Auth::user();
        return view('user.show', compact('user'),'user');
    }

    public function edit()
    {
        $user_id = $_GET['user_id'];
        $user = User::find($user_id);
        return view('user.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'image' => 'required',
            'address_id' => 'required'
        ]);
    
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
    
        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'address_id' => $request->address_id
        ];
        if ($request->hasFile('image')) {
            $imageName = time().'.'.$request->image->extension();
            $request->image->move(public_path('img'), $imageName);
            $data['image'] = 'img/'.$imageName;
        }
        $user->update($data);
    
        return redirect()->route('user.index')->with('success', 'User updated successfully.');
    }
    

    public function destroy(User $user)
    {
       
        $user->delete();
        return redirect()->route('user.index')->with('success', 'User deleted successfully.');
    }
}
