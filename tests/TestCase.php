<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    /**
     *  Ref: https://github.com/spatie/laravel-medialibrary/issues/623
     */
    public function storageFakeUploadMediaLibrary($disk = 'images')
    {
        \Illuminate\Support\Facades\Storage::fake($disk);

        config()->set('filesystems.disks.' . $disk, [
            'driver' => 'local',
            'root' => \Illuminate\Support\Facades\Storage::disk($disk)->getAdapter()->getPathPrefix(),
        ]);

        config()->set('medialibrary.disk_name', $disk);
    }
}
