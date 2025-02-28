<?php

namespace App\Http\Controllers;

use App\Models\Request as RequestModel;
use Illuminate\Http\Request;

class RequestController extends Controller
{
    public function index()
    {
        return response()->json(RequestModel::with('user', 'requestItems.item')->get());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'items' => 'required|array',
            'items.*.item_id' => 'required|exists:items,id',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        $req = RequestModel::create([
            'user_id' => $validated['user_id'],
            'status' => 'Pending',
        ]);

        return response()->json(['message' => 'Permintaan berhasil dibuat!', 'data' => $req], 201);
    }

    public function updateStatus(Request $request, $id)
{
    $request->validate([
        'status' => 'required|in:Pending,Fulfilled,Rejected',
    ]);

    $permintaan = RequestModel::findOrFail($id);
    $permintaan->status = $request->status;
    $permintaan->save();

    return response()->json(['message' => 'Status permintaan berhasil diperbarui']);
}
}
