<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pet;
use App\Models\User;
use App\Http\Controllers\AuthController;
use App\Models\Messages;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Validator;
use Illuminate\Support\Facades\Auth;
use \stdClass;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class MessagesController extends Controller
{
    //Funcion para mostrar el formulario de contacto al cliente
    public function contactForm()
    {
        return view('client.contact');
    }
    //Funcion para enviar nuevo mensaje
    public function sendMessage(Request $request)
    {
        $request->validate([
            'title' => 'required|max:500',
            'subject' => 'required',
        ]);

        Messages::create([
            'id_client' => Auth::id(),
            'title' => $request->title,
            'subject' => $request->subject,
            'date' => now()->toDateString(),
            'time' => now()->toTimeString(),
            'status' => 'No leido',
        ]);

        return redirect()->back()->with('success', 'Mensaje enviado correctamente.');
    }
    //Mostrar mensajes desde el panel de admin
    public function showMessages()
    {
        $messages = Messages::with('client')->get(); 

        return view('veterinary.contact', compact('messages'));
    }

    // Ver detalle de un mensaje y cambiar estado a 'Leido'
    public function showMessage($id)
    {
        $message = Messages::with('client')->findOrFail($id); 
        $message->status = 'Leído';
        $message->save();

        return view('veterinary.showMessage', compact('message'));
    }
}
