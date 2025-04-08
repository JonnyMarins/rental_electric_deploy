<?php

namespace App\Repositories;

use Illuminate\Http\Request;
use App\Models\Vehicle;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class VehicleRepository
{

    public function save(Request $request)
    {
        $vehicle = $request->user()->vehicles()->create($request->except('image', 'tags'));

        // assegno i tags al veicolo creando un record nella pivot table tag_vehicle
        $vehicle->tags()->attach($request->tags, [
            'created_at' => now(),
            'updated_at' => now()
        ]);

        return $vehicle;
    }

    public function update(Request $request, Vehicle $vehicle)
    {
        $vehicle->update($request->except('image', 'tags'));
        $vehicle->tags()->sync($request->tags, [
            'updated_at' => now()
        ]);
        return $vehicle;
    }

    public function delete(Vehicle $vehicle)
    {
        $vehicle->delete();
        return response()->noContent();
    }

    /**
     * Aggiorna l'immagine del veicolo
     */
    public function updateImage(Vehicle $vehicle, string $imagePath)
    {
        // Aggiorno il record del veicolo con il nuovo file_path
        $vehicle->update([
            'image_path' => $imagePath
        ]);
        return $vehicle;
    }
}
