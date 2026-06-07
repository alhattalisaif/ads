<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Wallet;
use App\Models\Transaction;

class WalletController extends Controller
{
    public function show(Request $request)
    {
        $wallet = $request->user()->wallet;
        return response()->json($wallet);
    }

    public function deposit(Request $request)
    {
        $data = $request->validate([
            'amount' => 'required|numeric|min:0.01'
        ]);

        $user = $request->user();

        $wallet = $user->wallet;
        if (! $wallet) {
            $wallet = Wallet::create(['user_id' => $user->id]);
        }

        $wallet->cash_balance += $data['amount'];
        $wallet->save();

        Transaction::create([
            'user_id' => $user->id,
            'type' => 'deposit',
            'amount' => $data['amount'],
            'entry_type' => 'credit',
            'reference' => null
        ]);

        return response()->json($wallet);
    }
}
