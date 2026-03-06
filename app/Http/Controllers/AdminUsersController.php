<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminUsersController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->query('q');

        $users = User::query()
            ->when($q, function ($query) use ($q) {
                $query->where('name', 'like', "%{$q}%")
                    ->orWhere('email', 'like', "%{$q}%");
            })
            ->orderBy('name')
            ->paginate(15)
            ->withQueryString();

        return view('admin.utilizadores', compact('users', 'q'));
    }
    public function promote(User $user)
    {
        $user->role = 'admin';
        $user->save();

        return back()->with('success', "{$user->name} agora é Admin.");
    }

    public function demote(User $user)
    {
        if (auth()->id() === $user->id) {
            return back()->with('error', "Não podes remover o teu próprio acesso de Admin.");
        }

        $user->role = 'cidadao';
        $user->save();

        return back()->with('success', "{$user->name} agora é Cidadão.");
    }
}
