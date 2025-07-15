<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Address;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Exception;

class LocationController extends Controller
{
    /**
     * Get all provinces
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getProvinces(Request $request)
    {
        try {
            $country = $request->query('country', 'Vietnam');
            $provinces = DB::table('provinces')
                ->where('country', $country)
                ->orderBy('name', 'asc')
                ->get();

            return response()->json([
                'status' => 'success',
                'data' => $provinces
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to retrieve provinces',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Search provinces by name
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function searchProvinces(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|min:2',
                'country' => 'nullable|string'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }

            $name = $request->name;
            $country = $request->country ?? 'Vietnam';

            $provinces = DB::table('provinces')
                ->where('country', $country)
                ->where('name', 'like', '%' . $name . '%')
                ->orderBy('name', 'asc')
                ->get();

            if ($provinces->isEmpty()) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'No provinces found matching the search criteria',
                    'data' => []
                ]);
            }

            return response()->json([
                'status' => 'success',
                'data' => $provinces
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to search provinces',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get districts by province
     *
     * @param int $provinceId
     * @return \Illuminate\Http\JsonResponse
     */
    public function getDistricts($provinceId)
    {
        try {
            $districts = DB::table('districts')
                ->where('province_id', $provinceId)
                ->orderBy('name', 'asc')
                ->get();

            if ($districts->isEmpty()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'No districts found for this province'
                ], 404);
            }

            return response()->json([
                'status' => 'success',
                'data' => $districts
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to retrieve districts',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Search districts by name
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function searchDistricts(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|min:2',
                'province_id' => 'nullable|exists:provinces,id'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }

            $name = $request->name;
            $query = DB::table('districts')
                ->where('name', 'like', '%' . $name . '%');
            
            if ($request->has('province_id')) {
                $query->where('province_id', $request->province_id);
            }
            
            $districts = $query->orderBy('name', 'asc')->get();

            if ($districts->isEmpty()) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'No districts found matching the search criteria',
                    'data' => []
                ]);
            }

            return response()->json([
                'status' => 'success',
                'data' => $districts
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to search districts',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get wards by district
     *
     * @param int $districtId
     * @return \Illuminate\Http\JsonResponse
     */
    public function getWards($districtId)
    {
        try {
            $wards = DB::table('wards')
                ->where('district_id', $districtId)
                ->orderBy('name', 'asc')
                ->get();

            if ($wards->isEmpty()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'No wards found for this district'
                ], 404);
            }

            return response()->json([
                'status' => 'success',
                'data' => $wards
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to retrieve wards',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Search wards by name
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function searchWards(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|min:2',
                'district_id' => 'nullable|exists:districts,id'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }

            $name = $request->name;
            $query = DB::table('wards')
                ->where('name', 'like', '%' . $name . '%');
            
            if ($request->has('district_id')) {
                $query->where('district_id', $request->district_id);
            }
            
            $wards = $query->orderBy('name', 'asc')->get();

            if ($wards->isEmpty()) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'No wards found matching the search criteria',
                    'data' => []
                ]);
            }

            return response()->json([
                'status' => 'success',
                'data' => $wards
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to search wards',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Create a new address
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function createAddress(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'street' => 'required|string',
                'ward_id' => 'required|exists:wards,id',
                'latitude' => 'nullable|numeric',
                'longitude' => 'nullable|numeric',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }

            $address = new Address();
            $address->street = $request->street;
            $address->ward_id = $request->ward_id;
            
            if ($request->has('latitude')) {
                $address->latitude = $request->latitude;
            }
            
            if ($request->has('longitude')) {
                $address->longitude = $request->longitude;
            }
            
            $address->save();

            // Get full address details with province, district, ward
            $fullAddress = $this->getFullAddressDetails($address->id);

            return response()->json([
                'status' => 'success',
                'message' => 'Address created successfully',
                'data' => $fullAddress
            ], 201);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to create address',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get address details
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAddress($id)
    {
        try {
            $address = $this->getFullAddressDetails($id);
            
            if (!$address) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Address not found'
                ], 404);
            }

            return response()->json([
                'status' => 'success',
                'data' => $address
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to retrieve address',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get full address details with province, district, ward
     *
     * @param int $addressId
     * @return mixed
     */
    private function getFullAddressDetails($addressId)
    {
        return DB::table('addresses')
            ->select(
                'addresses.id',
                'addresses.street',
                'addresses.latitude',
                'addresses.longitude',
                'wards.id as ward_id',
                'wards.name as ward_name',
                'districts.id as district_id',
                'districts.name as district_name',
                'provinces.id as province_id',
                'provinces.name as province_name',
                'provinces.country'
            )
            ->join('wards', 'addresses.ward_id', '=', 'wards.id')
            ->join('districts', 'wards.district_id', '=', 'districts.id')
            ->join('provinces', 'districts.province_id', '=', 'provinces.id')
            ->where('addresses.id', $addressId)
            ->first();
    }
} 