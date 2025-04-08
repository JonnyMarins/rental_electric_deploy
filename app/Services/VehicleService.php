<?php

namespace App\Services;

use App\Models\Vehicle;
use App\Repositories\VehicleRepository;
use Illuminate\Http\UploadedFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class VehicleService
{
    /**
     * Create a new class instance.
     */
    public function __construct(protected VehicleRepository $vehicleRepository) {}

    public function create(Request $request)
    {
        // estraggo l'immagine dalla request
        $imageFile = $request->file('image');

        // salvo i dati ricevuti dalla request nel db
        $vehicle = $this->vehicleRepository->save($request);

        // controllo se la request contiene un file
        if ($imageFile) {
            $vehicle = $this->updateImage($vehicle, $imageFile);
        }
        return $vehicle;
    }

    public function update(Request $request, Vehicle $vehicle)
    {
        $imageFile = $request->file('image');
        $vehicle = $this->vehicleRepository->update($request, $vehicle);
        if ($imageFile) {
            $vehicle = $this->updateImage($vehicle, $imageFile);
        }
        return $vehicle;
    }

    public function delete(Vehicle $vehicle)
    {
        $res = $this->vehicleRepository->delete($vehicle);
        if ($res) {
            $this->deleteImage($vehicle->image_path);
        }
        return $res;
    }

    /** IMAGES METHODS */

    public function updateImage(Vehicle $vehicle, UploadedFile $image)
    {
        // se esiste carico l'immagine nello storage (locale)
        $imagePath = $this->uploadImage($vehicle, $image);

        // aggiorno il record del veicolo con l'image path relativo all'immagine caricata
        return $this->vehicleRepository->updateImage($vehicle, $imagePath);
    }

    public function uploadImage(Vehicle $vehicle, UploadedFile $image)
    {
        // Elimino l'immagine corrente nel caso esiste già per quel veicolo
        if ($vehicle->image_path) {
            $this->deleteImage($vehicle->image_path);
        }

        // Salvo l'immagine caricata all'interno della cartella vehicles nel disk public
        $imagePath = $image->storePublicly('vehicles', 'public');

        return $imagePath;
    }

    /**
     * Eliminare un file immagine dallo storage
     */
    public function deleteImage(string $imagePath)
    {
        if (Storage::disk('public')->exists($imagePath)) {
            Storage::disk('public')->delete($imagePath);
        }
    }
}
