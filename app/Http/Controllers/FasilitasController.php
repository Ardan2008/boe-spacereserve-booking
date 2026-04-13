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
            'tipe' => 'required|in:asrama,aula',
            'deskripsi' => 'required',
            'detail' => 'nullable',
            'harga' => 'required|numeric',
            'harga_bulanan' => 'nullable|numeric',
            'max_dewasa' => 'nullable|integer',
            'max_anak' => 'nullable|integer',
            'max_durasi_harian' => 'nullable|integer',
            'jam_operasional' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'gallery.*' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'paket_harian' => 'nullable|string',
            'labels' => 'nullable|array',
        ]);

        $oldHarga = $fasilitas->harga;
        $newHarga = $request->harga;

        if ($oldHarga != $newHarga) {
            $diff = $newHarga - $oldHarga;
            $percent = ($oldHarga != 0) ? ($diff / $oldHarga) * 100 : 100;
            $percentFormatted = ($percent > 0 ? '+' : '') . round($percent) . '%';

            \App\Models\HargaSewaHistory::create([
                'fasilitas_id' => $fasilitas->id,
                'harga_lama' => $oldHarga,
                'harga_baru' => $newHarga,
                'persen_perubahan' => $percentFormatted,
            ]);
        }

        $paket_harian = []; // UI removed, default to empty
        
        // Calculate thumbnail price range
        $prices = [$newHarga];
        if ($request->harga_bulanan) $prices[] = $request->harga_bulanan;
        
        $minPrice = min($prices);
        $maxPrice = max($prices);

        $formatPrice = function($price) {
            if ($price >= 1000000) return round($price / 1000000, 1) . 'JT';
            if ($price >= 1000) return round($price / 1000) . 'K';
            return $price;
        };

        $harga_thumbnail = (count($prices) > 1) 
            ? "Mulai " . $formatPrice($minPrice) . " - " . $formatPrice($maxPrice)
            : "Rp " . number_format($newHarga, 0, ',', '.');

        $data = [
            'nama' => $request->nama,
            'tipe' => $request->tipe,
            'deskripsi' => $request->deskripsi,
            'detail' => $request->detail,
            'harga' => $request->harga,
            'harga_bulanan' => $request->harga_bulanan,
            'max_dewasa' => $request->max_dewasa,
            'max_anak' => $request->max_anak,
            'max_durasi_harian' => $request->max_durasi_harian,
            'jam_operasional' => $request->jam_operasional,
            'paket_harian' => $paket_harian,
            'labels' => $request->labels ?? [],
            'harga_thumbnail' => $harga_thumbnail,
        ];

        if ($request->hasFile('image')) {
            $oldPath = public_path('storage/fasilitas/' . $fasilitas->image);
            if (File::exists($oldPath)) File::delete($oldPath);

            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('storage/fasilitas'), $imageName);
            $data['image'] = $imageName;
        }

        // Handle Gallery
        $gallery = $fasilitas->gallery ?? [];
        if ($request->hasFile('gallery')) {
            // Delete old gallery if new ones are uploaded (or just replace, but user said UX 3 boxes)
            // For simplicity, we replace if index matches or just append
            // User requested 3 boxes, so we'll expect array of files
            foreach ($request->file('gallery') as $index => $file) {
                if ($file) {
                    $name = time() . '_gallery_' . $index . '.' . $file->getClientOriginalExtension();
                    $file->move(public_path('storage/fasilitas/gallery'), $name);
                    
                    // Replace if exists at index
                    $gallery[$index] = $name;
                }
            }
        }
        $data['gallery'] = array_values(array_filter($gallery));

        $fasilitas->update($data);

        return redirect()->route('fasilitas.index')->with('success', 'Data berhasil diperbarui!');
    }

    public function edit($id) {
        $fasilitas = Fasilitas::findOrFail($id);
        return view('admin.dashboard.edit.editFasilitas', compact('fasilitas'));
    }

    public function destroy($id) {
        $fasilitas = Fasilitas::findOrFail($id);
        if ($fasilitas->image) {
            Storage::delete('public/fasilitas/' . $fasilitas->image);
        }
        // Also delete gallery
        if ($fasilitas->gallery) {
            foreach ($fasilitas->gallery as $img) {
                Storage::delete('public/fasilitas/gallery/' . $img);
            }
        }
        $fasilitas->delete();
        return redirect()->back()->with('success', 'Fasilitas berhasil dihapus');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'tipe' => 'required|in:asrama,aula',
            'deskripsi' => 'required',
            'detail' => 'nullable',
            'harga' => 'required|numeric',
            'harga_bulanan' => 'nullable|numeric',
            'max_dewasa' => 'nullable|integer',
            'max_anak' => 'nullable|integer',
            'max_durasi_harian' => 'nullable|integer',
            'jam_operasional' => 'nullable|string',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'gallery.*' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'paket_harian' => 'nullable|string',
            'labels' => 'nullable|array',
        ]);

        $imageName = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $path = $image->store('fasilitas', 'public'); 
            $imageName = basename($path);
        }

        $gallery = [];
        if ($request->hasFile('gallery')) {
            foreach ($request->file('gallery') as $index => $file) {
                if ($file) {
                    $path = $file->store('fasilitas/gallery', 'public');
                    $gallery[$index] = basename($path);
                }
            }
        }
        $gallery = array_values(array_filter($gallery));

        $paket_harian = [];
        
        // Calculate thumbnail price range
        $h_harian = (float) $request->harga;
        $h_bulanan = $request->harga_bulanan ? (float) $request->harga_bulanan : null;

        $prices = [$h_harian];
        if ($h_bulanan) $prices[] = $h_bulanan;
        
        $minPrice = min($prices);
        $maxPrice = max($prices);

        $formatPrice = function($price) {
            if ($price >= 1000000) return round($price / 1000000, 1) . 'JT';
            if ($price >= 1000) return round($price / 1000) . 'K';
            return $price;
        };

        $harga_thumbnail = (count($prices) > 1) 
            ? "Mulai " . $formatPrice($minPrice) . " - " . $formatPrice($maxPrice)
            : "Rp " . number_format($h_harian, 0, ',', '.');

        Fasilitas::create([
            'nama' => $request->nama,
            'tipe' => $request->tipe,
            'deskripsi' => $request->deskripsi,
            'detail' => $request->detail,
            'harga' => $h_harian,
            'harga_bulanan' => $h_bulanan,
            'max_dewasa' => $request->max_dewasa,
            'max_anak' => $request->max_anak,
            'max_durasi_harian' => $request->max_durasi_harian,
            'jam_operasional' => $request->jam_operasional,
            'image' => $imageName, 
            'gallery' => $gallery,
            'paket_harian' => $paket_harian,
            'labels' => $request->labels ?? [],
            'harga_thumbnail' => $harga_thumbnail,
        ]);

        return response()->json(['success' => 'Data fasilitas berhasil disimpan!']);
    }
    public function updatePaketHarian(Request $request, $id)
    {
        $fasilitas = Fasilitas::findOrFail($id);

        $request->validate([
            'paket_harian' => 'nullable|string',
        ]);

        $fasilitas->update([
            'paket_harian' => $request->paket_harian ? json_decode($request->paket_harian, true) : [],
        ]);

        return redirect()->back()->with('success', 'Paket harian berhasil diperbarui!');
    }
}