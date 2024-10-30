<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class TicketController extends Controller
{

    protected $ticket;

    public function __construct()
    {
        $this->ticket = new Ticket();
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $ticketsQuery = $this->ticket->with('user')->latest()->get();

            if ($request->user()->role === 'client') {
                $ticketsQuery = $this->ticket->where('client_id', $request->user()->id)->latest()->get();
            }

            return response()->json([
                'success' => true,
                'message' => 'Tickets retrieved successfully',
                'data' =>  $ticketsQuery
            ]);
        } catch (\Throwable $th) {
            error_log($th);

            return response()->json([
                'success' => false,
                'message' => 'Internal Server Error'
            ], 500);
        }
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validate = $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'required|string'
            ]);

            if (!$validate) {
                return response()->json([
                    'success' => false,
                    'message' => 'Internal Server Error',
                ], 500);
            }

            $ticket = Ticket::create([
                'title' => $request->title,
                'description' => $request->description,
                'status' => 'open',
                'client_id' => $request->user()->id
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Ticket created successfully',
                'data' =>  $ticket
            ], 200);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'data' => $e->errors()
            ], 400);
        } catch (\Throwable $th) {
            error_log($th);

            return response()->json([
                'success' => false,
                'message' => 'Internal Server Error'
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Ticket $ticket, Request $request)
    {
        try {

            if (!$ticket) {
                return response()->json([
                    'success' => true,
                    'message' => 'Ticket not found',
                ], 404);
            }


            if ($request->user()->role === 'client' && $ticket->client_id !== $request->user()->id) {
                return response()->json([
                    'success' => true,
                    'message' => 'Access not permitted',
                    'data' =>  []
                ], 403);
            }

            return response()->json([
                'success' => true,
                'message' => 'Ticket retrieved successfully',
                'data' =>  $ticket
            ], 200);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'data' => $e->errors()
            ], 400);
        } catch (\Throwable $th) {

            return response()->json([
                'success' => false,
                'message' => 'Internal Server Error'
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Ticket $ticket)
    {
        try {
            if (!$ticket) {
                return response()->json([
                    'success' => true,
                    'message' => 'Ticket not found',
                ], 404);
            }

            if ($request->user()->role === 'client' && $ticket->client_id !== $request->user()->id) {
                return response()->json([
                    'success' => true,
                    'message' => 'Access not permitted',
                    'data' =>  []
                ], 403);
            }

            $updatedTicket = $ticket->update($request->validate([
                'title' => 'required|string|max:255',
                'description' => 'required|string'
            ]));

            return response()->json([
                'success' => true,
                'message' => 'Ticket updated successfully',
                'data' =>  $ticket
            ], 200);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'data' => $e->errors()
            ], 400);
        } catch (\Throwable $th) {

            return response()->json([
                'success' => false,
                'message' => 'Internal Server Error'
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ticket $ticket, Request $request)
    {
        try {
            if (!$ticket) {
                return response()->json([
                    'success' => true,
                    'message' => 'Ticket not found',
                ], 404);
            }

            if ($request->user()->role === 'client' && $ticket->client_id !== $request->user()->id) {
                return response()->json([
                    'success' => true,
                    'message' => 'Access not permitted',
                    'data' =>  []
                ], 403);
            }

            $ticket->delete();

            return $this->index($request);
        } catch (\Throwable $th) {

            return response()->json([
                'success' => false,
                'message' => 'Internal Server Error'
            ], 500);
        }
    }

    public function respond(Request $request, Ticket $ticket)
    {
        try {
            if (!$ticket) {
                return response()->json([
                    'success' => true,
                    'message' => 'Ticket not found',
                ], 404);
            }

            if ($request->user()->role === 'client') {
                return response()->json([
                    'success' => true,
                    'message' => 'Access not permitted',
                    'data' =>  []
                ], 403);
            }

            $ticket->update($request->validate([
                'status' => 'required|string',
                'admin_response' => 'string'
            ]));

            return response()->json([
                'success' => true,
                'message' => 'Ticket updated successfully',
                'data' =>  $ticket
            ], 200);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'data' => $e->errors()
            ], 400);
        } catch (\Throwable $th) {
            echo $th;
            return response()->json([
                'success' => false,
                'message' => 'Internal Server Error'
            ], 500);
        }
    }
}
