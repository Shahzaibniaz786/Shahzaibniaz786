<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function usersList()
    {
        $users = User::all();
        return view('adminPanel.userManagement.userList', ['users' => $users,]);
    }

    public function registerUser(Request $request)
    {
        // dd($request);
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $role = Role::where(['name' => 'User'])->first();
        $user->assignRole($role);

        foreach ($request->userRight as $rigth) {
            $user->givePermissionTo($rigth);
        }

        return redirect()->back()->with(['success' => 'User Created Successfully']);
    }

    public function updateUser(Request $request ){

      
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'userRight' => 'array', // Ensure it's an array if rights are provided
            'userRight.*' => 'string', // Ensure each right is a string
        ]);  
        // dd($request);

        try {
            // Find the user by ID
            $user = User::findOrFail($request->user_id);
            // Update the user's basic information
            $user->name = $validatedData['name'];
            $user->email = $validatedData['email'];

             // Assign the role to the user
   

            foreach ($request->userRight as $rigth) {
                $user->givePermissionTo($rigth);
            }

            // Save the user
            $user->save();

            // Redirect back with a success message
            return redirect()->back()->with('success', 'User updated successfully.');
        } catch (\Exception $e) {
            // Handle exceptions
            return redirect()->back()->with('error', 'An error occurred while updating the user.');
        }
    }
}
