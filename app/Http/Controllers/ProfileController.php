<?php

namespace App\Http\Controllers;

use App\Models\AlamatUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    // Tampilkan daftar alamat user
    public function index()
    {
        $alamats = AlamatUser::where('user_id', Auth::id())->get();
        return view('profile.index', compact('alamats'));
    }

    // Form tambah alamat
    public function create()
    {
        return view('profile.create');
    }

    // Simpan alamat baru
    public function store(Request $request)
    {
        $request->validate([
            'namapenerima' => 'required|string|max:255',
            'no_telepon'   => 'required|string|max:20',
            'alamat'       => 'required|string',
            'is_default'   => 'nullable|boolean',
        ]);

        // Jika alamat ini dijadikan default, reset semua alamat lama
        if ($request->boolean('is_default')) {
            AlamatUser::where('user_id', Auth::id())->update(['is_default' => false]);
        }

        AlamatUser::create([
            'user_id'      => Auth::id(),
            'namapenerima' => $request->namapenerima,
            'no_telepon'   => $request->no_telepon,
            'alamat'       => $request->alamat,
            'is_default'   => $request->boolean('is_default'),
        ]);

        return redirect()->route('profile.index')->with('success', 'Alamat berhasil ditambahkan.');
    }

    // Form edit alamat
    public function edit($id)
    {
        $alamat = AlamatUser::where('user_id', Auth::id())->findOrFail($id);
        return view('profile.edit', compact('alamat'));
    }

    // Update alamat
    public function update(Request $request, $id)
    {
        $request->validate([
            'namapenerima' => 'required|string|max:255',
            'no_telepon'   => 'required|string|max:20',
            'alamat'       => 'required|string',
            'is_default'   => 'nullable|boolean',
        ]);

        $alamat = AlamatUser::where('user_id', Auth::id())->findOrFail($id);

        if ($request->boolean('is_default')) {
            AlamatUser::where('user_id', Auth::id())->update(['is_default' => false]);
        }

        $alamat->update([
            'namapenerima' => $request->namapenerima,
            'no_telepon'   => $request->no_telepon,
            'alamat'       => $request->alamat,
            'is_default'   => $request->boolean('is_default'),
        ]);

        return redirect()->route('profile.index')->with('success', 'Alamat berhasil diperbarui.');
    }

    // Hapus alamat
    public function destroy($id)
    {
        $alamat = AlamatUser::where('user_id', Auth::id())->findOrFail($id);
        $alamat->delete();

        return redirect()->route('profile.index')->with('success', 'Alamat berhasil dihapus.');
    }

    // Set alamat default (tambahan untuk tombol "Set Default")
    public function setDefault($id)
    {
        $userId = Auth::id();

        // Reset semua alamat user jadi tidak default
        AlamatUser::where('user_id', $userId)->update(['is_default' => false]);

        // Set alamat ini jadi default
        $alamat = AlamatUser::where('user_id', $userId)->findOrFail($id);
        $alamat->update(['is_default' => true]);

        return redirect()->route('profile.index')->with('success', 'Alamat default berhasil diubah.');
    }
}
