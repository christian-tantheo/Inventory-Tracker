<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class RegisterController extends Controller
{
    use RegistersUsers;

    protected $redirectTo = '/login';

    public function __construct()
    {
        $this->middleware('guest');
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'first_name' => ['required', 'string', 'max:191'],
            'last_name' => ['required', 'string', 'max:191'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

protected function create(array $data)
{
    $user = User::create([
        'first_name' => $data['first_name'],
        'last_name' => $data['last_name'],
        'name' => $data['first_name'].' '.$data['last_name'],
        'email' => $data['email'],
        'password' => Hash::make($data['password']),
    ]);

    $user->assignRole('User'); // Assign User role by default

    return $user;
}

    public function register(Request $request)
{
    $this->validator($request->all())->validate();

    $user = $this->create($request->all());

    Log::info('User registered:', ['email' => $user->email]);

    // Log the user out after registration
    $this->guard()->logout();

    Log::info('User logged out after registration.');

    return redirect('/login')->with('success', 'Registration successful! Please log in.');
}

protected function registered(Request $request, $user)
{
    $this->guard()->logout();
    return redirect('/login')->with('success', 'Registration successful! Please log in.');
}

}