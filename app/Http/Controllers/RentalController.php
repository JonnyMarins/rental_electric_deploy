<?php

namespace App\Http\Controllers;

use App\Models\Rental;
use App\Models\Vehicle;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RentalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pages.rentals.index', ['rentals' => Rental::all()]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.rentals.create', [
            'vehicles' => Vehicle::all(),
            'customers' => Customer::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $validated = $request->validate([
            'vehicle_id' => 'required',
            'customer_id' => 'required',
            'start_time' => 'required',
            'status' => 'required',
        ]);

        $customer = Customer::find($request->customer_id);
        $customer->vehicles()->attach($request->vehicle_id, [
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'total_cost' => $request->total_cost,
            'status' => $request->status,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // DB::table('rentals')->insert([
        //     'vehicle_id' => $request->vehicle_id,
        //     'customer_id' => $request->customer_id,
        //     'start_time' => $request->start_time,
        //     'total_cost' => $request->total_cost,
        //     'status' => $request->status,
        //     'created_at' => now(),
        //     'updated_at' => now(),
        // ]);

        return redirect()->route('rentals.index');
    }

    public function complete(Rental $rental)
    {
        $rental->update([
            'end_time' => now(),
            'status' => 'completed'
        ]);

        return redirect()->route('rentals.index')->with('success', 'Il noleggio n° ' . $rental->id . ' è stato completato con successo!');
    }
}
