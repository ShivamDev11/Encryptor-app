<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class CryptoController extends Controller
{
    // Home page
    public function index()
    {
        return view('crypto');
    }

    // Encrypt message
    public function encryptMessage(Request $request)
    {
        $request->validate([
            'message' => 'required'
        ]);

        $encrypted = Crypt::encryptString($request->message);

        return back()->with('encrypted', $encrypted);
    }

    // Decrypt message
    public function decryptMessage(Request $request)
    {
        $request->validate([
            'encrypted_message' => 'required'
        ]);

        try {
            $decrypted = Crypt::decryptString($request->encrypted_message);
        } catch (\Exception $e) {
            return back()->with('error', 'Invalid encrypted text!');
        }

        return back()->with('decrypted', $decrypted);
    }
}
