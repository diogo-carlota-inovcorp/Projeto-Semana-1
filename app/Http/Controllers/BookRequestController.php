<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Notifications\BookRequestNotification;
use App\Notifications\BookRequestConfirmation;
use Illuminate\Support\Facades\Notification;
use App\Models\User;

class BookRequestController extends Controller
{
    public function create()
    {
        return view('google-books.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'book_name' => 'required|string|max:255',
            'reason' => 'required|string|max:1000',
        ]);

        $data = $request->only('email','book_name','reason');

        $admins = User::where('role','admin')->get();

        Notification::send($admins, new BookRequestNotification($data));

// confirmation to user
        Notification::route('mail', $data['email'])
            ->notify(new BookRequestConfirmation($data));

        return redirect()->back()->with('success','Pedido enviado com sucesso!');
    }
}
