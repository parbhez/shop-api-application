<?php

namespace App\Services;

use App\Models\Medicine;
use Illuminate\Support\Str;

class MedicineService
{
    /**
     * Get all medicines with alternatives.
     */
    public function getAllMedicines($limit = null)
    {
        $query = Medicine::with('alternatives');

        if ($limit) {
            return $query->paginate($limit);
        }

        return $query->get();
    }

    /**
     * Get a single medicine by slug with alternatives.
     */
    public function getMedicineBySlug($slug)
    {
        return Medicine::with('alternatives')->where('slug', $slug)->firstOrFail();
    }

    /**
     * Create a new medicine.
     */
    public function createMedicine(array $data)
    {
        $data['slug'] = $this->generateUniqueSlug($data['title']);
        $medicine = Medicine::create($data);

        if (isset($data['alternatives']) && is_array($data['alternatives'])) {
            $medicine->alternatives()->createMany($data['alternatives']);
        }

        return $medicine->load('alternatives');
    }

    /**
     * Update an existing medicine.
     */
    public function updateMedicine(Medicine $medicine, array $data)
    {
        if (isset($data['title']) && $data['title'] !== $medicine->title) {
            $data['slug'] = $this->generateUniqueSlug($data['title'], $medicine->id);
        }

        $medicine->update($data);

        if (isset($data['alternatives']) && is_array($data['alternatives'])) {
            // Simplistic approach: delete old and recreate. For a real app, you might sync by ID.
            $medicine->alternatives()->delete();
            $medicine->alternatives()->createMany($data['alternatives']);
        }

        return $medicine->load('alternatives');
    }

    /**
     * Delete a medicine.
     */
    public function deleteMedicine(Medicine $medicine)
    {
        return $medicine->delete();
    }

    /**
     * Generate a unique slug for the medicine.
     */
    private function generateUniqueSlug($title, $ignoreId = null)
    {
        $slug = Str::slug($title);
        $originalSlug = $slug;
        $count = 1;

        $query = Medicine::where('slug', $slug);
        if ($ignoreId) {
            $query->where('id', '!=', $ignoreId);
        }

        while ($query->exists()) {
            $slug = "{$originalSlug}-{$count}";
            $query = Medicine::where('slug', $slug);
            if ($ignoreId) {
                $query->where('id', '!=', $ignoreId);
            }
            $count++;
        }

        return $slug;
    }
}
