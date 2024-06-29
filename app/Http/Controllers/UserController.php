<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Illuminate\Database\QueryException;

class UserController extends Controller
{
    public function index(Request $request)
    {
        try {
            $search = $request->input('search');
            $usersQuery = User::query();

            if (!empty($search)) {
                $usersQuery->where('name', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%');
            }

            $users = $usersQuery->paginate(10);
            $usersCount = $usersQuery->count();

            $roles = Role::all();

            $breadcrumbItems = [
                ['name' => 'Dashboard', 'url' => route('admin')],
                ['name' => 'Daftar Pengguna', 'url' => route('users.index')],
            ];

            if (!empty($search)) {
                $breadcrumbItems[] = ['name' => 'Hasil Pencarian (' . $usersCount . ')'];
            }

            return view('dashboard.admin.users.index', compact('users', 'breadcrumbItems', 'roles', 'search'));
        } catch (\Exception $e) {
            // Handle any unexpected exceptions here
            flash()->error('Error: ' . $e->getMessage());
            return redirect()->back();
        }
    }


    public function create()
    {
        try {
            $roles = Role::all();
            return view('users.create', compact('roles'));
        } catch (\Exception $e) {
            flash()->error('Error: ' . $e->getMessage());
            return redirect()->back();
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:8|confirmed',
                'roles' => 'required|array'
            ]);

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            $user->syncRoles($request->roles);

            flash()->success('User created successfully.');

            return redirect()->route('dashboard.admin.users.index');
        } catch (\Exception $e) {
            // Handle any unexpected exceptions here
            flash()->error('Error: ' . $e->getMessage());
            return redirect()->back();
        }
    }

    public function edit(User $user)
    {
        try {
            $roles = Role::all();
            return view('users.edit', compact('user', 'roles'));
        } catch (\Exception $e) {
            flash()->error('Error: ' . $e->getMessage());
            return redirect()->back();
        }
    }

    public function update(Request $request, User $user)
    {
        try {
            $request->validate([
                'roles' => 'required|array'
            ]);


            $user->syncRoles($request->roles);
            flash()->success('User updated successfully.');
            return redirect()->route('users.index');
        } catch (\Exception $e) {
            // Handle any unexpected exceptions here
            flash()->error('Error: ' . $e->getMessage());
            return redirect()->back();
        }
    }

    public function destroy(User $user)
    {
        try {
            $user->delete();
            flash()->success('User deleted successfully.');
            return redirect()->route('users.index');
        } catch (\Exception $e) {
            // Handle any unexpected exceptions here
            flash()->error('Error: ' . $e->getMessage());
            return redirect()->route('users.index');
        }
    }
}
