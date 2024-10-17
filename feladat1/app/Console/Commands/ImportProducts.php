<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Product;
use App\Models\Category;

class ImportProducts extends Command
{
    protected $signature = 'import:products {file}';
    protected $description = 'Termékek és kategóriák importálása CSV-fájlból';

    public function handle()
{
    $file = $this->argument('file');

    $csv = array_map('str_getcsv', file($file));

    foreach ($csv as $row) {
        $name = $row[0] ?? null;
        $price = $row[1] ?? null;
        $cat1 = $row[2] ?? null;
        $cat2 = $row[3] ?? null;
        $cat3 = $row[4] ?? null;

        if (!$name || !$price) {
            $this->error('Hiba a CSV fájlban: Név vagy ár hiányzik');
            continue;
        }

        $product = Product::updateOrCreate(
            ['name' => $name],
            ['price' => $price]
        );

        $categories = array_filter([$cat1, $cat2, $cat3]);
        foreach ($categories as $categoryName) {
            $category = Category::firstOrCreate(['name' => $categoryName]);
            $product->categories()->syncWithoutDetaching($category->id);
        }
    }

    $this->info('CSV importálása sikeresen megtörtént!');
}


}
