<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

use Illuminate\Support\Facades\DB;
use App\Models\Medicine;
use App\Models\MedicineAlternative;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class MigrateHerbalDataJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Log::info('Starting herbal data migration...');

        DB::table('Herbal_Brand')->orderBy('id')->chunk(100, function ($herbals) {
            foreach ($herbals as $herbal) {
                // Generate unique slug
                $slug = Str::slug($herbal->tablet_name);
                $originalSlug = $slug;
                $count = 1;
                while (Medicine::where('slug', $slug)->exists()) {
                    $slug = "{$originalSlug}-{$count}";
                    $count++;
                }

                $medicine = Medicine::create([
                    'title' => $herbal->tablet_name,
                    'slug' => $slug,
                    'generic_name' => $herbal->generic_name,
                    'strength' => $herbal->strength,
                    'brand' => $herbal->manufacturer_company,
                    'category' => 'Herbal',
                    'price' => $this->cleanPrice($herbal->unit_price),
                    'strip_price' => $this->cleanPrice($herbal->strip_price),
                    'availability_status' => 'In Stock',
                ]);

                // Find alternatives for this herbal
                $alternatives = DB::table('Alternate_Brand_Herbal')
                                  ->where('herbal_id', $herbal->id)
                                  ->get();

                foreach ($alternatives as $alt) {
                    MedicineAlternative::create([
                        'medicine_id' => $medicine->id,
                        'title' => $alt->tablet_name,
                        'generic_name' => $alt->generic_name,
                        'strength' => $alt->strength,
                        'brand' => $alt->manufacturer_company,
                        'price' => $this->cleanPrice($alt->unit_price),
                        'strip_price' => $this->cleanPrice($alt->strip_price),
                    ]);
                }
            }
        });

        Log::info('Herbal data migration completed successfully.');
    }

    /**
     * Clean price string to decimal.
     * "৳ 15.00" -> 15.00
     * "N/A" -> 0
     * null -> 0
     */
    private function cleanPrice($priceString)
    {
        if (empty($priceString) || $priceString === 'N/A' || $priceString === 'n/a') {
            return 0;
        }

        // Remove the currency symbol and any spaces
        $cleaned = str_replace(['৳', ',', ' '], '', $priceString);
        return (float) $cleaned;
    }
}
