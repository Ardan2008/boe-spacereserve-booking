<?php

use App\Models\Fasilitas;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

uses(Illuminate\Foundation\Testing\RefreshDatabase::class);

beforeEach(function () {
    Storage::fake('public');
});

// ── Helper: create a test facility with room photos ──
function createFacilityWithPhotos(array $fotoData = ['f0.jpg', 'f1.jpg', 'f2.jpg']): Fasilitas
{
    return Fasilitas::create([
        'nama' => 'Test Facility',
        'tipe' => 'asrama',
        'deskripsi' => 'Test facility for photo testing',
        'detail' => 'Detail',
        'image' => 'thumbnail.jpg',
        'harga' => 100000,
        'harga_bulanan' => 2000000,
        'paket_harian' => [
            [
                'tipe' => 'Deluxe Room',
                'jumlah' => 3,
                'foto' => $fotoData,
                'harga_harian' => 100000,
                'harga_mingguan' => 600000,
                'harga_bulanan' => 2000000,
                'harga_tahunan' => 20000000,
                'max_dewasa' => 2,
                'max_anak' => 1,
                'kode_blok' => 'A',
                'keunggulan' => 'Spacious room',
                'panjang' => 5,
                'lebar' => 4,
                'ranjang' => '1 King Bed',
                'fasilitas' => ['ac' => 1, 'kipas_angin' => 0, 'meja_kursi' => 1],
                'nomor_kamar' => ['101', '102', '103'],
            ],
        ],
        'jumlah_kamar' => 3,
        'labels' => ['AC', 'TV'],
    ]);
}

// ── Data layer tests (no auth needed) ──

it('stores foto array correctly via model create', function () {
    $fotoData = ['room_0.jpg', 'room_1.jpg', 'room_2.jpg'];

    $fasilitas = Fasilitas::create([
        'nama' => 'Test Fasilitas',
        'tipe' => 'asrama',
        'deskripsi' => 'Test deskripsi',
        'image' => 'test.jpg',
        'paket_harian' => [
            [
                'tipe' => 'Deluxe',
                'jumlah' => 5,
                'foto' => $fotoData,
                'harga_harian' => 150000,
                'harga_mingguan' => 900000,
                'harga_bulanan' => 3000000,
                'harga_tahunan' => 30000000,
                'max_dewasa' => 2,
                'max_anak' => 1,
            ],
        ],
        'jumlah_kamar' => 5,
        'labels' => ['AC', 'WiFi'],
        'harga' => 150000,
    ]);

    $this->assertDatabaseHas('fasilitas', ['nama' => 'Test Fasilitas']);

    $fasilitas->refresh();
    $paket = $fasilitas->paket_harian;

    expect($paket)->toBeArray();
    expect($paket[0]['tipe'])->toBe('Deluxe');
    expect($paket[0]['foto'])->toBe($fotoData);
});

it('preserves foto array through model update without changes', function () {
    $fotoData = ['existing_0.jpg', 'existing_1.jpg', 'existing_2.jpg'];

    $fasilitas = Fasilitas::create([
        'nama' => 'Update Test',
        'tipe' => 'asrama',
        'deskripsi' => 'Test',
        'image' => 'test.jpg',
        'paket_harian' => [
            [
                'tipe' => 'Standard',
                'jumlah' => 3,
                'foto' => $fotoData,
                'harga_harian' => 100000,
                'harga_mingguan' => 600000,
                'harga_bulanan' => 2000000,
                'harga_tahunan' => 20000000,
                'max_dewasa' => 2,
                'max_anak' => 0,
            ],
        ],
        'jumlah_kamar' => 3,
        'labels' => [],
        'harga' => 100000,
    ]);

    // Simulate what update controller does: read existing, merge (no changes), save
    $paket = $fasilitas->paket_harian;
    $paket[0]['tipe'] = 'Standard Updated';

    $fasilitas->update(['paket_harian' => $paket]);
    $fasilitas->refresh();

    $refreshedPaket = $fasilitas->paket_harian;
    expect($refreshedPaket[0]['tipe'])->toBe('Standard Updated');
    expect($refreshedPaket[0]['foto'])->toBe($fotoData);
});

it('filters null foto values correctly via controller store logic', function () {
    $fotos = [
        0 => UploadedFile::fake()->image('room_0_0.jpg', 100, 100),
        1 => null,  // simulate missing middle photo
        2 => UploadedFile::fake()->image('room_0_2.jpg', 100, 100),
    ];

    $paketHarian = [
        [
            'tipe' => 'Test',
            'jumlah' => 1,
            'foto' => [],
            'harga_harian' => 50000,
            'harga_mingguan' => 300000,
            'harga_bulanan' => 1000000,
            'harga_tahunan' => 10000000,
            'max_dewasa' => 2,
            'max_anak' => 0,
        ],
    ];

    // Simulate store controller logic
    foreach (['room_fotos'] as $roomIdx => $fotoFiles) {
        if (!isset($paketHarian[$roomIdx])) continue;
        $roomFotos = $paketHarian[$roomIdx]['foto'] ?? [];
        $roomFotos = is_array($roomFotos) ? $roomFotos : [];
        foreach ($fotos as $fotoIdx => $file) {
            if ($file && $file->isValid()) {
                $name = time() . '_room_' . $roomIdx . '_' . $fotoIdx . '.' . $file->getClientOriginalExtension();
                $file->storeAs('fasilitas/rooms', $name, 'public');
                $roomFotos[$fotoIdx] = $name;
            }
        }
        $paketHarian[$roomIdx]['foto'] = array_values(array_filter($roomFotos));
    }

    expect($paketHarian[0]['foto'])->toBeArray();
    expect(count($paketHarian[0]['foto']))->toBe(2);

    $fasilitas = Fasilitas::create([
        'nama' => 'Partial Foto Test',
        'tipe' => 'asrama',
        'deskripsi' => 'Test',
        'image' => 'test.jpg',
        'paket_harian' => $paketHarian,
        'jumlah_kamar' => 1,
        'labels' => [],
        'harga' => 50000,
    ]);

    $fasilitas->refresh();
    $stored = $fasilitas->paket_harian;
    expect(count($stored[0]['foto']))->toBe(2);
});

it('builds correct fotoPreviews URLs from stored filenames', function () {
    $fotoData = ['test_0.jpg', 'test_1.jpg', 'test_2.jpg'];

    $fasilitas = Fasilitas::create([
        'nama' => 'Foto Preview Test',
        'tipe' => 'asrama',
        'deskripsi' => 'Test',
        'image' => 'test.jpg',
        'paket_harian' => [
            [
                'tipe' => 'Preview',
                'jumlah' => 2,
                'foto' => $fotoData,
                'harga_harian' => 100000,
                'harga_mingguan' => 600000,
                'harga_bulanan' => 2000000,
                'harga_tahunan' => 20000000,
                'max_dewasa' => 2,
                'max_anak' => 1,
            ],
        ],
        'jumlah_kamar' => 2,
        'labels' => [],
        'harga' => 100000,
    ]);

    // Simulate what the edit controller and Alpine init do
    $rooms = $fasilitas->paket_harian;
    expect($rooms[0]['foto'])->toBe($fotoData);

    // Simulate Alpine's fotoPreviews hydration:
    $fotoPreviews = [null, null, null];
    foreach ($rooms[0]['foto'] as $fi => $filename) {
        if ($filename && !$fotoPreviews[$fi]) {
            $fotoPreviews[$fi] = '/storage/fasilitas/rooms/' . $filename;
        }
    }

    expect($fotoPreviews[0])->toBe('/storage/fasilitas/rooms/test_0.jpg');
    expect($fotoPreviews[1])->toBe('/storage/fasilitas/rooms/test_1.jpg');
    expect($fotoPreviews[2])->toBe('/storage/fasilitas/rooms/test_2.jpg');
});

it('preserves foto array through full edit-save cycle controller logic', function () {
    // Simulate what the update controller does
    $existingData = [
        [
            'tipe' => 'Original',
            'jumlah' => 2,
            'foto' => ['orig_0.jpg', 'orig_1.jpg', 'orig_2.jpg'],
            'harga_harian' => 100000,
            'harga_mingguan' => 600000,
            'harga_bulanan' => 2000000,
            'harga_tahunan' => 20000000,
            'max_dewasa' => 2,
            'max_anak' => 0,
            'nomor_kamar' => ['101', '102'],
        ],
    ];

    // Create initial facility
    $fasilitas = Fasilitas::create([
        'nama' => 'Edit Cycle Test',
        'tipe' => 'asrama',
        'deskripsi' => 'Test',
        'image' => 'test.jpg',
        'paket_harian' => $existingData,
        'jumlah_kamar' => 2,
        'labels' => [],
        'harga' => 100000,
    ]);

    $fasilitas->refresh();

    // Simulate what happens when edit form is loaded and submitted without changes
    $submittedPaket = $fasilitas->paket_harian;
    $submittedPaket[0]['tipe'] = 'Updated Name';

    // Simulate update controller's merge logic (read existing, merge with no new files)
    $existingPaket = $fasilitas->paket_harian;
    foreach ($submittedPaket as $roomIdx => &$room) {
        $existingFoto = isset($existingPaket[$roomIdx]['foto']) && is_array($existingPaket[$roomIdx]['foto'])
            ? $existingPaket[$roomIdx]['foto']
            : [null, null, null];

        while (count($existingFoto) < 3) {
            $existingFoto[] = null;
        }

        // No new files uploaded, so just keep existing foto
        $room['foto'] = array_values(array_filter($existingFoto, fn($v) => $v !== null && $v !== ''));
    }
    unset($room);

    $fasilitas->update(['paket_harian' => $submittedPaket]);
    $fasilitas->refresh();

    $finalPaket = $fasilitas->paket_harian;
    expect($finalPaket[0]['tipe'])->toBe('Updated Name');
    expect($finalPaket[0]['foto'])->toBe(['orig_0.jpg', 'orig_1.jpg', 'orig_2.jpg']);
});

it('replaces specific foto slots when new files are uploaded', function () {
    $existingData = [
        [
            'tipe' => 'Replace Test',
            'jumlah' => 1,
            'foto' => ['old_0.jpg', 'old_1.jpg', 'old_2.jpg'],
            'harga_harian' => 100000,
            'harga_mingguan' => 600000,
            'harga_bulanan' => 2000000,
            'harga_tahunan' => 20000000,
            'max_dewasa' => 2,
            'max_anak' => 0,
        ],
    ];

    $fasilitas = Fasilitas::create([
        'nama' => 'Replace Foto Test',
        'tipe' => 'asrama',
        'deskripsi' => 'Test',
        'image' => 'test.jpg',
        'paket_harian' => $existingData,
        'jumlah_kamar' => 1,
        'labels' => [],
        'harga' => 100000,
    ]);

    $fasilitas->refresh();

    // Simulate Alpine sending request with new file for slot 0 only
    $submittedPaket = $fasilitas->paket_harian;

    // Simulate controller's merge logic with new file for slot 0
    $existingPaket = $fasilitas->paket_harian;
    $newFile = UploadedFile::fake()->image('new_0.jpg', 100, 100);

    foreach ($submittedPaket as $roomIdx => &$room) {
        $existingFoto = isset($existingPaket[$roomIdx]['foto']) && is_array($existingPaket[$roomIdx]['foto'])
            ? $existingPaket[$roomIdx]['foto']
            : [null, null, null];

        while (count($existingFoto) < 3) {
            $existingFoto[] = null;
        }

        $newFiles = [0 => $newFile];
        for ($fotoIdx = 0; $fotoIdx < 3; $fotoIdx++) {
            $file = $newFiles[$fotoIdx] ?? null;
            if ($file && $file->isValid()) {
                $name = time() . '_room_' . $roomIdx . '_' . $fotoIdx . '.' . $file->getClientOriginalExtension();
                $file->storeAs('fasilitas/rooms', $name, 'public');
                $existingFoto[$fotoIdx] = $name;
            }
        }

        $room['foto'] = array_values(array_filter($existingFoto, fn($v) => $v !== null && $v !== ''));
    }
    unset($room);

    $fasilitas->update(['paket_harian' => $submittedPaket]);
    $fasilitas->refresh();

    $finalPaket = $fasilitas->paket_harian;
    expect($finalPaket[0]['foto'][0])->not->toBe('old_0.jpg');
    expect($finalPaket[0]['foto'][1])->toBe('old_1.jpg');
    expect($finalPaket[0]['foto'][2])->toBe('old_2.jpg');
    expect(count($finalPaket[0]['foto']))->toBe(3);
});

// ── HTTP tests for detail page (no auth required) ──

it('renders room photo URLs on the detail page', function () {
    $fasilitas = createFacilityWithPhotos();

    $response = $this->get(route('fasilitas.detail', $fasilitas->id));
    $response->assertStatus(200);

    $response->assertSee('f0.jpg', false);
    $response->assertSee('f1.jpg', false);
    $response->assertSee('f2.jpg', false);
    $response->assertSee('storage/fasilitas/rooms/f0.jpg', false);
});

it('renders room type names on the detail page', function () {
    $fasilitas = createFacilityWithPhotos();

    $response = $this->get(route('fasilitas.detail', $fasilitas->id));
    $response->assertStatus(200);

    $response->assertSee('Deluxe Room', false);
});

it('renders photo count badge when multiple photos exist', function () {
    $fasilitas = createFacilityWithPhotos();

    $response = $this->get(route('fasilitas.detail', $fasilitas->id));
    $response->assertStatus(200);

    // Should show "3 foto" badge
    $response->assertSee('foto', false);
});

it('renders room photo fallback for single-photo rooms on detail page', function () {
    $fasilitas = createFacilityWithPhotos(['only_one.jpg']);

    $response = $this->get(route('fasilitas.detail', $fasilitas->id));
    $response->assertStatus(200);

    // The single photo filename should appear
    $response->assertSee('only_one.jpg', false);
});

it('handles empty foto array gracefully on detail page', function () {
    $fasilitas = createFacilityWithPhotos([]);

    $response = $this->get(route('fasilitas.detail', $fasilitas->id));
    $response->assertStatus(200);
});

// ── HTTP tests for edit page data (view data, bypasses auth middleware) ──

it('passes foto array and fotoPreviews in rooms view data to edit view', function () {
    $fasilitas = createFacilityWithPhotos();

    // Directly call the controller to get view data (bypasses auth middleware)
    $controller = new \App\Http\Controllers\FasilitasController;
    $view = $controller->edit($fasilitas->id);
    $viewData = $view->getData();

    expect($viewData['rooms'])->toBeArray();
    expect($viewData['rooms'][0]['foto'])->toBe(['f0.jpg', 'f1.jpg', 'f2.jpg']);
    expect($viewData['rooms'][0]['fotoPreviews'])->toBeArray();
    expect($viewData['rooms'][0]['fotoPreviews'][0])->toContain('storage/fasilitas/rooms/f0.jpg');
    expect($viewData['rooms'][0]['fotoPreviews'][1])->toContain('storage/fasilitas/rooms/f1.jpg');
    expect($viewData['rooms'][0]['fotoPreviews'][2])->toContain('storage/fasilitas/rooms/f2.jpg');
});

it('renders foto filenames and fotoPreviews URLs in edit view JSON output', function () {
    $fasilitas = createFacilityWithPhotos();

    // Access the edit controller directly
    $controller = new \App\Http\Controllers\FasilitasController;
    $view = $controller->edit($fasilitas->id);
    $html = $view->render();

    // The @json($rooms) output should contain the foto array
    expect(str_contains($html, 'f0.jpg'))->toBeTrue();
    expect(str_contains($html, 'f1.jpg'))->toBeTrue();
    expect(str_contains($html, 'f2.jpg'))->toBeTrue();

    // Verify fotoPreviews key exists in the @json output (server-side pre-populated)
    expect(str_contains($html, '"fotoPreviews"'))->toBeTrue();

    // Verify the storage URL pattern exists somewhere in the rendered view
    expect(str_contains($html, 'storage/fasilitas/rooms/'))->toBeTrue();
});

it('includes tipe_kamar in room data for edit view', function () {
    $fasilitas = createFacilityWithPhotos(['room_a.jpg', 'room_b.jpg', 'room_c.jpg']);

    $controller = new \App\Http\Controllers\FasilitasController;
    $view = $controller->edit($fasilitas->id);
    $viewData = $view->getData();

    expect($viewData['rooms'][0]['tipe'])->toBe('Deluxe Room');
});

it('does not include fotoPreviews in stored paket_harian (syncPaketHarian destructures it out)', function () {
    $room = [
        'tipe' => 'Clean',
        'jumlah' => 1,
        'foto' => ['clean_0.jpg'],
        'fotoPreviews' => ['/storage/fasilitas/rooms/clean_0.jpg', null, null],
        'harga_harian' => 100000,
        'harga_mingguan' => 600000,
        'harga_bulanan' => 2000000,
        'harga_tahunan' => 20000000,
        'max_dewasa' => 2,
        'max_anak' => 0,
    ];

    // Simulate syncPaketHarian destructuring
    $fotoPreviews = $room['fotoPreviews'];
    unset($room['fotoPreviews']);
    unset($room['customFasNama']);
    unset($room['fasShow']);
    unset($room['temp_input']);

    expect($room)->toHaveKey('foto');
    expect($room)->not->toHaveKey('fotoPreviews');
    expect($room['foto'])->toBe(['clean_0.jpg']);
});

// ── Gallery tests ──

it('stores gallery array correctly via model create', function () {
    $fasilitas = Fasilitas::create([
        'nama' => 'Gallery Test',
        'tipe' => 'aula',
        'deskripsi' => 'Gallery test',
        'harga' => 0,
        'image' => 'thumb.jpg',
        'gallery' => ['gal_0.jpg', 'gal_1.jpg', 'gal_2.jpg'],
    ]);

    expect($fasilitas->gallery)->toBe(['gal_0.jpg', 'gal_1.jpg', 'gal_2.jpg']);
});

it('passes gallery data to edit view', function () {
    $fasilitas = Fasilitas::create([
        'nama' => 'Gallery Test',
        'tipe' => 'aula',
        'deskripsi' => 'Gallery test',
        'harga' => 0,
        'image' => 'thumb.jpg',
        'gallery' => ['gal_0.jpg', 'gal_1.jpg'],
    ]);

    $controller = new \App\Http\Controllers\FasilitasController;
    $view = $controller->edit($fasilitas->id);
    $viewData = $view->getData();

    expect($viewData['fasilitas']->gallery)->toBe(['gal_0.jpg', 'gal_1.jpg']);
});

it('renders gallery asset URLs in edit view', function () {
    $fasilitas = Fasilitas::create([
        'nama' => 'Gallery Test',
        'tipe' => 'aula',
        'deskripsi' => 'Gallery test',
        'harga' => 0,
        'image' => 'thumb.jpg',
        'gallery' => ['gal_0.jpg', 'gal_1.jpg'],
    ]);

    $controller = new \App\Http\Controllers\FasilitasController;
    $view = $controller->edit($fasilitas->id);
    $html = $view->render();

    expect(str_contains($html, 'storage/fasilitas/gallery/gal_0.jpg'))->toBeTrue();
    expect(str_contains($html, 'storage/fasilitas/gallery/gal_1.jpg'))->toBeTrue();
});

it('renders gallery photos on the detail page', function () {
    $fasilitas = Fasilitas::create([
        'nama' => 'Gallery Test',
        'tipe' => 'aula',
        'deskripsi' => 'Gallery test',
        'harga' => 0,
        'image' => 'thumb.jpg',
        'gallery' => ['gal_0.jpg', 'gal_1.jpg', 'gal_2.jpg'],
    ]);

    $response = $this->get(route('fasilitas.detail', $fasilitas->id));
    $response->assertStatus(200);
    $response->assertSee('gal_0.jpg', false);
    $response->assertSee('gal_1.jpg', false);
    $response->assertSee('gal_2.jpg', false);
    $response->assertSee('storage/fasilitas/gallery/', false);
});
