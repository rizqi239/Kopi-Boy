<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use App\Models\Menu;

class ImportMenuImages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'menus:import-images {--force : Overwrite existing menu images}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Copy images from resources/image to storage and update menus.image by matching filenames to menu names.';

    public function handle()
    {
        $resourceDir = base_path('resources/image');

        if (!File::exists($resourceDir)) {
            $this->error("Directory not found: {$resourceDir}");
            return 1;
        }

        $files = File::files($resourceDir);
        if (empty($files)) {
            $this->info('No files found in resources/image');
            return 0;
        }

        Storage::disk('public')->makeDirectory('menus');

        $force = $this->option('force');

        foreach ($files as $f) {
            $basename = $f->getFilename();
            $nameOnly = pathinfo($basename, PATHINFO_FILENAME);

            // Normalize filename to try to match menu name
            $candidate = Str::of($nameOnly)->replace(['-', '_'], ' ')->trim();
            $candidateLower = strtolower((string) $candidate);

            // Try exact match (case-insensitive), then slug match
            $menu = Menu::whereRaw('LOWER(name) = ?', [$candidateLower])->first();
            if (!$menu) {
                // try slug-based match
                $menu = Menu::all()->first(function ($m) use ($candidate) {
                    return Str::slug($m->name) === Str::slug((string) $candidate);
                });
            }

            if (!$menu) {
                $this->warn("No matching menu for file: {$basename}");
                continue;
            }

            if ($menu->image && !$force) {
                $this->line("Skipping {$menu->name}: already has image (use --force to overwrite)");
                continue;
            }

            $destPath = 'menus/' . $basename;

            // Copy file into storage/app/public/menus
            $source = $f->getPathname();
            $targetFull = storage_path('app/public/' . $destPath);
            if (!File::exists(dirname($targetFull))) {
                File::makeDirectory(dirname($targetFull), 0755, true);
            }

            File::copy($source, $targetFull);

            // Update menu record
            $menu->image = $destPath;
            $menu->save();

            $this->info("Imported image for {$menu->name} -> {$destPath}");
        }

        $this->info('Done. Remember to run php artisan storage:link if not already created.');
        return 0;
    }
}
