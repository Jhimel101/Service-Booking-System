<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BookingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    public function index(Request $request)
    {
        // Policy check for viewing own bookings
        $this->authorize('viewAny', Booking::class);

        return response()->json(
            $request->user()->bookings()->with('service')->get()
        );
    }

    public function store(Request $request)
    {
        $this->authorize('create', Booking::class); 

        $validator = Validator::make($request->all(), [
            'service_id' => 'required|exists:services,id',
            'booking_date' => 'required|date|after:now',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $booking = $request->user()->bookings()->create([
            'service_id' => $request->service_id,
            'booking_date' => $request->booking_date,
            'status' => 'confirmed',
        ]);

        return response()->json($booking, 201);
    }
}
