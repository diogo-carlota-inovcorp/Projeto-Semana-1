<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PerfilController extends Controller
{
    public function show()
    {
        $user = Auth::user();

        return view('perfil.show', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'foto_perfil' => ['nullable','image','mimes:jpg,jpeg,png,webp','max:2048']
        ]);

        if ($request->hasFile('foto_perfil')) {

            // apagar foto antiga
            if ($user->foto_perfil) {
                Storage::disk('public')->delete($user->foto_perfil);
            }


            $path = $request->file('foto_perfil')->store('avatars','public');

            $user->foto_perfil = $path;
            $user->save();
        }

        return back()->with('success','Foto de perfil atualizada!');
    }
}
