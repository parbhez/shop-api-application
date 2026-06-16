<?php

namespace App\Http\Controllers;

use App\Models\Medicine;
use App\Services\MedicineService;
use App\Http\Resources\MedicineResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class MedicineController extends Controller
{
    protected $medicineService;

    public function __construct(MedicineService $medicineService)
    {
        $this->medicineService = $medicineService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Validate that limit is an integer if provided
        $request->validate([
            'limit' => 'nullable|integer|min:1'
        ]);

        // Get limit from request and cast to integer
        $limit = $request->query('limit') ? (int) $request->query('limit') : null;

        $medicines = $this->medicineService->getAllMedicines($limit);

        if ($limit) {
            // Keep query parameters (like limit) in the pagination links
            $medicines->appends($request->all());

            // Wrap the collection in 'products' and include pagination metadata and links
            return response()->json([
                'status' => true,
                'message' => 'Medicines retrieved successfully',
                'products' => MedicineResource::collection($medicines),
                'total' => $medicines->total(),
                'skip' => ($medicines->currentPage() - 1) * $medicines->perPage(),
                'limit' => $medicines->perPage(),
                'current_page' => $medicines->currentPage(),
                'last_page' => $medicines->lastPage(),
                'links' => [
                    'first' => $medicines->url(1),
                    'last' => $medicines->url($medicines->lastPage()),
                    'prev' => $medicines->previousPageUrl(),
                    'next' => $medicines->nextPageUrl(),
                ]
            ]);
        }

        // Return all without pagination metadata
        return response()->json([
            'status' => true,
            'message' => 'Medicines retrieved successfully',
            'total' => $medicines->count(),
            'products' => MedicineResource::collection($medicines),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'generic_name' => 'nullable|string|max:255',
            'strength' => 'nullable|string|max:255',
            'category' => 'nullable|string|max:255',
            'brand' => 'nullable|string|max:255',
            'price' => 'required|numeric|min:0',
            'strip_price' => 'nullable|numeric|min:0',
            'availability_status' => 'nullable|string|max:255',
            'thumbnail' => 'nullable|string',
            'alternatives' => 'nullable|array',
        ]);

        DB::beginTransaction();
        try {
            $medicine = $this->medicineService->createMedicine($data);
            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Medicine created successfully',
                'product' => new MedicineResource($medicine)
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error creating medicine: ' . $e->getMessage());
            throw $e; // Forward to global exception handler
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($slug)
    {
        $medicine = $this->medicineService->getMedicineBySlug($slug);

        return response()->json([
            'status' => true,
            'message' => 'Medicine details retrieved successfully',
            'product' => new MedicineResource($medicine)
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $slug)
    {
        $medicine = $this->medicineService->getMedicineBySlug($slug);

        $data = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'generic_name' => 'nullable|string|max:255',
            'strength' => 'nullable|string|max:255',
            'category' => 'nullable|string|max:255',
            'brand' => 'nullable|string|max:255',
            'price' => 'sometimes|required|numeric|min:0',
            'strip_price' => 'nullable|numeric|min:0',
            'availability_status' => 'nullable|string|max:255',
            'thumbnail' => 'nullable|string',
            'alternatives' => 'nullable|array',
        ]);

        DB::beginTransaction();
        try {
            $updatedMedicine = $this->medicineService->updateMedicine($medicine, $data);
            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Medicine updated successfully',
                'product' => new MedicineResource($updatedMedicine)
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error updating medicine: ' . $e->getMessage());
            throw $e; // Forward to global exception handler
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($slug)
    {
        $medicine = $this->medicineService->getMedicineBySlug($slug);

        DB::beginTransaction();
        try {
            $this->medicineService->deleteMedicine($medicine);
            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Medicine deleted successfully'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error deleting medicine: ' . $e->getMessage());
            throw $e; // Forward to global exception handler
        }
    }
}
