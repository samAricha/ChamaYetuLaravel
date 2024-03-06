<?php

namespace App\Http\Controllers;

use App\Models\Waitlist;
use App\Traits\HttpResponses;
use Exception;
use Illuminate\Http\Request;

class WaitlistController extends Controller
{
    use HttpResponses;

    public function index()
    {
        try {
            $waitlist = Waitlist::all();

            // Return a success response with the waitlist data
            return $this->success($waitlist, 'Waitlist retrieved successfully', 200);
        } catch (Exception $e) {
            // Return an error response if an exception occurs
            return $this->error(null, 'An error occurred while retrieving the waitlist', 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:waitlists,email',
                'phone' => 'required|string|max:20',
            ]);

            $waitlist = Waitlist::create([
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'phone' => $validatedData['phone'],
            ]);

            // Return a success response using the success method from the HttpResponses trait
            return $this->success($waitlist, 'Form submitted successfully', 201);
        } catch (Exception $e) {
            // Return an error response if an exception occurs
            return $this->error(null, 'An error occurred while processing the request', 500);
        }
    }
}
