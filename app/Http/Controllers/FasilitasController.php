<?php

namespace App\Http\Controllers;

use App\Models\Fasilitas; 
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class FasilitasController extends Controller
{

    public function index()
    {
        // Mengambil semua data dari model Facility
        $facilities = Fasilitas::all(); 

        // Pastikan nama variabel di compact('facilities') sesuai dengan @foreach($facilities as $item)
        return view('admin.dashboard.dataFasilitas', compact('facilities'));
    }

    public function update(Request $request, $id)
    {
        $fasilitas = Fasilitas::findOrFail($id);

        $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'required',
            'harga' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = [
            'nama' => $request->nama,
            'deskripsi' => $request->deskripsi,
            'harga' => $request->harga,
        ];

        if ($request->hasFile('image')) {
            // Hapus foto lama jika ada
            $oldPath = public_path('storage/fasilitas/' . $fasilitas->image);
            if (File::exists($oldPath)) {
                File::delete($oldPath);
            }

            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('storage/fasilitas'), $imageName);
            $data['image'] = $imageName;
        }

        $fasilitas->update($data);

        // Redirect kembali ke halaman daftar fasilitas
        return redirect()->route('fasilitas.index')->with('success', 'Data berhasil diperbarui!');
    }

    public function edit($id) {
        $fasilitas = Fasilitas::findOrFail($id); // Mencari data, jika tidak ada kirim 404
        return view('admin.dashboard.edit.editFasilitas', compact('fasilitas'));
    }

    public function destroy($id) {
        $fasilitas = Fasilitas::findOrFail($id);
        // Hapus file gambar jika ada
        if ($fasilitas->image) {
            Storage::delete('public/fasilitas/' . $fasilitas->image);
        }
        $fasilitas->delete();
        return redirect()->back()->with('success', 'Fasilitas berhasil dihapus');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'required',
            'harga' => 'required|numeric',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            // Simpan ke: storage/app/public/fasilitas
            $path = $image->store('fasilitas', 'public'); 
            $imageName = basename($path); // Ambil nama filenya saja
        }

        // Simpan ke Database
        Fasilitas::create([
            'nama' => $request->nama,
            'deskripsi' => $request->deskripsi,
            'harga' => $request->harga,
            'image' => $imageName, // Simpan nama file: 12345.jpg
        ]);

        return response()->json(['success' => 'Data fasilitas berhasil disimpan!']);
    }
}