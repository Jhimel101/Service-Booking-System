<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Booking;
use Illuminate\Http\Request;
use App\Http\Requests\StoreServiceRequest;
use App\Http\Requests\UpdateServiceRequest;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:sanctum', 'admin']);
    }

    /**
     * Create a new service
     */
    public function createService(StoreServiceRequest $request)
    {
        // Authorization handled by middleware
        $service = Service::create($request->validated());

        return response()->json([
            'message' => 'Service created successfully',
            'data' => $service
        ], 201);
    }

    /**
     * Update an existing service
     */
    public function updateService(UpdateServiceRequest $request, Service $service)
    {
        $service->update($request->validated());

        return response()->json([
            'message' => 'Service updated successfully',
            'data' => $service
        ]);
    }

    /**
     * Delete a service
     */
    public function deleteService(Service $service)
    {
        $service->delete();

        return response()->json([
            'message' => 'Service deleted successfully'
        ], 204);
    }

    /**
     * Get all bookings with user and service info
     */
    public function getAllBookings(Request $request)
    {
        $bookings = Booking::with(['user', 'service'])
            ->latest()
            ->when($request->status, fn($query) => $query->where('status', $request->status))
            ->paginate(10);

        return response()->json([
            'data' => $bookings
        ]);
    }

    /**
     * Update booking status
     */
    public function updateBookingStatus(Request $request, Booking $booking)
    {
        $validated = $request->validate([
            'status' => 'required|in:confirmed,cancelled,completed'
        ]);

        $booking->update(['status' => $validated['status']]);

        return response()->json([
            'message' => 'Booking status updated',
            'data' => $booking
        ]);
    }
}
