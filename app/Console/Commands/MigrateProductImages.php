<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class MigrateProductImages extends Command
{
    protected $signature = 'migrate:product-images';

    protected $description = 'Migrate all product images to storage/app/public/images folder';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        // Get all products with their image_url
        $products = Product::whereNotNull('image_url')->get();

        foreach ($products as $product) {
            // Get the image URL (assuming the image is saved with a relative URL)
            $imageUrl = $product->image_url;

            // If image_url is not empty, process it
            if ($imageUrl) {
                // Determine the full path of the image file (i.e., storage path or public URL)
                $oldImagePath = public_path('storage/images/' . basename($imageUrl));

                // Check if the image exists in the current folder
                if (File::exists($oldImagePath)) {
                    // Store the image in 'storage/app/public/images'
                    $imageName = basename($imageUrl);
                    $newImagePath = storage_path('app/public/images/' . $imageName);

                    // Copy the image to the correct location
                    File::copy($oldImagePath, $newImagePath);

                    // Now update the product's image_url to be relative to 'storage/images/'
                    $product->image_url = 'storage/images/' . $imageName;
                    $product->save();

                    $this->info("Image for product ID {$product->id} migrated successfully.");
                } else {
                    $this->error("Image for product ID {$product->id} does not exist at {$oldImagePath}");
                }
            }
        }

        $this->info('All product images have been migrated.');
    }
}
