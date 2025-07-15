<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Loainhadat;
use Exception;

class LoainhadatController extends Controller
{
    /**
     * Get all property types
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        try {
            $loainhadats = Loainhadat::all();
            
            return response()->json([
                'status' => 'success',
                'data' => $loainhadats
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to retrieve property types',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get a specific property type
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        try {
            $loainhadat = Loainhadat::find($id);
            
            if (!$loainhadat) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Property type not found'
                ], 404);
            }
            
            return response()->json([
                'status' => 'success',
                'data' => $loainhadat
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to retrieve property type',
                'error' => $e->getMessage()
            ], 500);
        }
    }
} 