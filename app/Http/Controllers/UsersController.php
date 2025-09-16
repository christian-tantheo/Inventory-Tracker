<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\ProfileUpdateRequest;


/**
 *
 */
class UsersController extends Controller
{
    /**
     * Display all users
     *
     * @return \Illuminate\Http\Response
     */
   public function index(Request $request)
{
    $users = User::query()
        ->when($request->role, function($query) use ($request) {
            $query->whereHas('roles', function($q) use ($request) {
                $q->where('name', $request->role);
            });
        })
        ->with('roles')
        ->latest()
        ->paginate(10);

    return view('users.index', [
        'users' => $users,
        'selectedRole' => $request->role
    ]);
}

    /**
     * Show form for creating user
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::latest()->get();
    return view('users.create', compact('roles'));
    }

    /**
     * Store a newly created user
     *
     * @param User $user
     * @param StoreUserRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(User $user, StoreUserRequest $request)
    {
        //For demo purposes only. When creating user or inviting a user
        // you should create a generated random password and email it to the user
        $user->create(array_merge($request->validated(), [
            'password' => 'test'
        ]));

        // Assign roles (pastikan input role dikirim dari form sebagai array atau string)
    $user->assignRole($request->input('roles'));

        return redirect()->route('users.index')
            ->withSuccess(__('User created successfully.'));
    }

    /**
     * Show user data
     *
     * @param User $user
     *
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return view('users.show', [
            'user' => $user
        ]);
    }

    /**
     * Edit user data
     *
     * @param User $user
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {

        $roles = Role::all();
$userRole = $user->roles->pluck('name')->toArray();
        return view('users.edit', [
            'user' => $user,
            'userRole' => $user->roles->pluck('name')->toArray(),
            'roles' => Role::latest()->get()
        ]);
    }

    /**
     * Update user data
     *
     * @param User $user
     * @param ProfileUpdateRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function update(User $user, ProfileUpdateRequest $request)
    {
        $user->update($request->validated());

        $user->syncRoles($request->input('roles'));

        $user->syncRoles($request->get('role'));

        return redirect()->route('users.index')
            ->withSuccess(__('User updated successfully.'));
    }

    /**
     * Delete user data
     *
     * @param User $user
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('users.index')
            ->withSuccess(__('User deleted successfully.'));
    }

    public function updateRoles(Request $request, User $user)
{
    $roles = $request->input('roles', []);
    $user->roles()->sync($roles);

    return redirect()->back()->with('success', 'Roles updated for user: ' . $user->name);
}

}
