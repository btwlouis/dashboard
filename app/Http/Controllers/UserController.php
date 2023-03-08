<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Activitylog\Models\Activity;
use Junges\ACL\Models\Permission;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();

        return view('user.index', compact('users'));
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $permissions = Permission::all();

        return view('user.edit', compact('user', 'permissions'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $data = [];

        if($request->email != $user->email) {
            $request->validate([
                'email' => 'required|email|unique:users',
            ]);

            $data['email'] = $request->email;
        }

        if ($request->name != $user->name) {
            $request->validate([
                'name' => 'required|unique:users',
            ]);

            $data['name'] = $request->name;
        }

        // hash password
        if ($request->password != null) {
            $request->validate([
                'password' => 'required|min:8',
                'password_confirmation' => 'required|same:password'
            ]);

            $data['password'] = bcrypt($request->password);
        }
        
        $user->syncPermissions($request['permissions']);

        User::whereId($id)->update($data);

        activity()->log('Benutzer ' . $user->name . ' wurde aktualisiert.');

        return redirect()->route('user.index')->with('success', 'Benuzter wurde erfolgreich aktualisiert');
    }

    public function destroy()
    {
        return view('user.destroy');
    }
}
