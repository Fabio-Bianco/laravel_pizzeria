<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function edit(Request $request)
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    public function update(Request $request)
    {
        $user = $request->user();

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
        ]);

        // Se l'email cambia, azzera la verifica
        if ($data['email'] !== $user->email) {
            $user->forceFill([
                'name' => $data['name'],
                'email' => $data['email'],
                'email_verified_at' => null,
            ])->save();
        } else {
            $user->update($data);
        }

        return redirect('/profile')->with('success', 'Profilo aggiornato.');
    }

    public function destroy(Request $request)
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'string'],
        ]);

        $user = $request->user();

        if (! Hash::check($request->input('password'), $user->password)) {
            return back()->withErrors([
                'password' => __('auth.password')
            ], 'userDeletion')->withInput();
        }

        Auth::logout();
        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Account eliminato.');
    }
}
