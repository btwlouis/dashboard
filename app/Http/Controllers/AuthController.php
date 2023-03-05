<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class AuthController extends Controller
{
    // default crud methods
    public function show()
    {
        return view('auth.login');
    }

    public function create()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        // validate the request
        $this->validate($request, [
            'name' => 'required|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
            'password2' => 'required|same:password'
        ]);

        // create the user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);

        // redirect to the dashboard
        return redirect()->route('dashboard')->with('success', 'Erfolgreich registriert');
    }

    public function login()
    {
        // validate the request
        $this->validate(request(), [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // attempt to sign the user in
        if (!auth()->attempt(request(['email', 'password']))) {
            return back()->withErrors([
                'message' => 'E-Mail oder Passwort falsch'
            ]);
        }

        if (!auth()->user()->is_admin) {
            return back()->withErrors([
                'message' => 'Dein Account ist kein Admin-Account. Bitte kontaktiere einen Administator.'
            ]);
        }

        // redirect to the dashboard route and send a success message
        return redirect()->route('dashboard')->with('success', 'Erfolgreich eingeloggt');
    }

    public function logout()
    {
        auth()->logout();

        return redirect()->route('login');
    }
}
