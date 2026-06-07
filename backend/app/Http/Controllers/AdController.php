<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ad;

class AdController extends Controller
{
    public function index()
    {
        return Ad::with('user')->latest()->paginate(15);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
            'meta' => 'nullable|array',
            'price' => 'nullable|numeric'
        ]);

        $data['user_id'] = $request->user()->id;

        $ad = Ad::create($data);

        return response()->json($ad, 201);
    }

    public function show(Ad $ad)
    {
        return $ad;
    }

    public function update(Request $request, Ad $ad)
    {
        $this->authorize('update', $ad);

        $data = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'content' => 'nullable|string',
            'meta' => 'nullable|array',
            'price' => 'nullable|numeric'
        ]);

        $ad->update($data);

        return response()->json($ad);
    }

    public function destroy(Ad $ad)
    {
        $this->authorize('delete', $ad);
        $ad->delete();
        return response()->json(null, 204);
    }
}
