<?php

namespace Tests\Feature\Examples;

use App\Models\Media;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class MediaControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake();

        $this->actingAs(
            User::factory()
                ->admin()
                ->create()
        );
    }

    public function testItRendersTheShowMediaPageSuccessfully()
    {
        $this->get('media-example')->assertOk();
    }

    public function testItReturnsAlistOfSavedMediaFiles()
    {
        Media::factory()
            ->count(2)
            ->create();

        $this->get('media')
            ->assertOk()
            ->assertJsonCount(2, 'data');
    }

    public function testItUploadsAMediaFile()
    {
        $file = UploadedFile::fake()->image('test-file.jpg');

        $this->post('media', ['file' => $file])->assertOk();

        Storage::disk('local')->assertExists('media/test-file.jpg');
    }
}
