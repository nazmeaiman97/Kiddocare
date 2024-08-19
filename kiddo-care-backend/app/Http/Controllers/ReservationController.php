<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreReservationRequest;
use App\Models\Customer;
use App\Models\Reservation;
use App\Models\Child;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\JsonResponse;
use Illuminate\Database\QueryException;

class ReservationController extends Controller
{
    public function store(StoreReservationRequest $request): JsonResponse
    {
        try {
            return DB::transaction(function () use ($request) {
                $customer = Customer::create([
                    'name' => $request->customer_name,
                    'address' => $request->customer_address
                ]);

                $reservation = Reservation::create([
                    'customer_id' => $customer->id,
                    'start_time' => $request->start_time,
                    'duration_minutes' => $request->duration_minutes,
                ]);

                $children = collect($request->children)->map(function ($childData) use ($customer) {
                    return Child::create([
                        'customer_id' => $customer->id,
                        'name' => $childData['name'],
                        'birthdate' => $childData['birthdate'],
                    ]);
                });

                $reservation->children()->attach($children->pluck('id'));

                return responseAPI('success', 'Reservation successfully submitted', $reservation->load('children', 'customer'), 201); // Just to show the result, should just return reservation id.
            });
        } catch (QueryException $e) {
            return responseAPI('error', 'Database error occurred', null, 500);
        } catch (\Exception $e) {
            return responseAPI('error', 'An unexpected error occurred', null, 500);
        }
    }
}
