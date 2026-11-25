<?php

namespace Tests\Feature;

use App\Models\GalleryAlbum;
use App\Models\GalleryImage;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Tests\TestCase;

class AdminGalleryTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    /** @var list<string> */
    private array $uploadDirectories = [];

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed();

        $this->admin = User::factory()->admin()->create();
    }

    protected function tearDown(): void
    {
        foreach ($this->uploadDirectories as $directory) {
            File::deleteDirectory($directory);
        }

        parent::tearDown();
    }

    public function test_gallery_admin_pages_load(): void
    {
        $this->actingAs($this->admin);

        $this->get('/admin/gallery')->assertOk()->assertSee('Gallery albums');
        $this->get('/admin/gallery/create')->assertOk()->assertSee('New album');

        $album = GalleryAlbum::factory()->create();

        $this->get('/admin/gallery/'.$album->slug.'/edit')->assertOk()->assertSee('Edit album');
        $this->get('/admin/gallery/'.$album->slug.'/images')->assertOk()->assertSee('Add photos');
    }

    public function test_an_admin_can_create_an_album_that_appears_on_the_public_gallery(): void
    {
        $response = $this->actingAs($this->admin)->post('/admin/gallery', [
            'title' => 'Admin Created Album',
            'description' => 'An album description written in the admin panel.',
            'sort_order' => 6,
            'is_published' => '1',
        ]);

        $album = GalleryAlbum::where('slug', 'admin-created-album')->firstOrFail();

        $response->assertRedirect('/admin/gallery/'.$album->slug.'/images');

        $this->assertTrue($album->is_published);

        $this->get('/gallery')
            ->assertOk()
            ->assertSee('Admin Created Album');
    }

    public function test_an_admin_can_upload_multiple_photos_and_the_first_becomes_the_cover(): void
    {
        $album = GalleryAlbum::factory()->create(['cover_image' => null]);

        $this->trackUploads($album);

        $response = $this->actingAs($this->admin)->post('/admin/gallery/'.$album->slug.'/images', [
            'images' => [
                UploadedFile::fake()->image('first-photo.jpg', 800, 600),
                UploadedFile::fake()->image('second-photo.png', 800, 600),
            ],
        ]);

        $response->assertRedirect('/admin/gallery/'.$album->slug.'/images')
            ->assertSessionHas('status', '2 photos uploaded.');

        $album->refresh();
        $images = $album->images()->get();

        $this->assertCount(2, $images);
        $this->assertSame($images->first()->image, $album->cover_image);
        $this->assertSame([1, 2], $images->pluck('sort_order')->all());

        foreach ($images as $image) {
            $this->assertFileExists(public_path($image->image));
        }
    }

    public function test_an_admin_can_update_a_photo_caption_and_order(): void
    {
        $album = GalleryAlbum::factory()->create();
        $image = GalleryImage::factory()->create([
            'gallery_album_id' => $album->id,
            'caption' => 'Old caption',
            'sort_order' => 5,
        ]);

        $this->actingAs($this->admin)
            ->put('/admin/gallery/'.$album->slug.'/images/'.$image->id, [
                'caption' => 'New caption',
                'alt_text' => 'A descriptive alt text.',
                'sort_order' => 2,
            ])
            ->assertRedirect('/admin/gallery/'.$album->slug.'/images');

        $image->refresh();

        $this->assertSame('New caption', $image->caption);
        $this->assertSame('A descriptive alt text.', $image->alt_text);
        $this->assertSame(2, $image->sort_order);
    }

    public function test_an_admin_can_reorder_photos_with_the_move_buttons(): void
    {
        $album = GalleryAlbum::factory()->create();

        [$first, $second, $third] = collect([1, 2, 3])->map(
            fn (int $order) => GalleryImage::factory()->create([
                'gallery_album_id' => $album->id,
                'sort_order' => $order,
            ]),
        )->all();

        $this->actingAs($this->admin)
            ->post('/admin/gallery/'.$album->slug.'/images/'.$third->id.'/move', ['direction' => 'up'])
            ->assertRedirect('/admin/gallery/'.$album->slug.'/images');

        $this->assertSame(
            [$first->id, $third->id, $second->id],
            $album->images()->pluck('id')->all(),
        );

        $this->assertSame([1, 2, 3], $album->images()->pluck('sort_order')->all());
    }

    public function test_an_admin_can_set_an_album_cover(): void
    {
        $album = GalleryAlbum::factory()->create(['cover_image' => null]);
        $image = GalleryImage::factory()->create(['gallery_album_id' => $album->id]);

        $this->actingAs($this->admin)
            ->post('/admin/gallery/'.$album->slug.'/images/'.$image->id.'/cover')
            ->assertRedirect('/admin/gallery/'.$album->slug.'/images')
            ->assertSessionHas('status', 'Album cover updated.');

        $this->assertSame($image->image, $album->refresh()->cover_image);
    }

    public function test_deleting_a_cover_photo_removes_the_file_and_resets_the_cover(): void
    {
        $album = GalleryAlbum::factory()->create(['cover_image' => null]);
        $image = GalleryImage::factory()->create(['gallery_album_id' => $album->id]);

        $directory = public_path('images/gallery/uploads/'.$album->id);
        File::ensureDirectoryExists($directory);
        $this->uploadDirectories[] = $directory;

        $path = 'images/gallery/uploads/'.$album->id.'/cover.jpg';
        File::put(public_path($path), 'fake image data');

        $image->update(['image' => $path, 'sort_order' => 1]);
        $album->update(['cover_image' => $path]);

        $remaining = GalleryImage::factory()->create([
            'gallery_album_id' => $album->id,
            'image' => 'images/gallery/uploads/'.$album->id.'/remaining.jpg',
            'sort_order' => 2,
        ]);

        $this->actingAs($this->admin)
            ->delete('/admin/gallery/'.$album->slug.'/images/'.$image->id)
            ->assertRedirect('/admin/gallery/'.$album->slug.'/images')
            ->assertSessionHas('status', 'Photo deleted.');

        $this->assertSoftDeleted('gallery_images', ['id' => $image->id]);
        $this->assertFileDoesNotExist(public_path($path));
        $this->assertSame($remaining->image, $album->refresh()->cover_image);
    }

    public function test_deleting_an_album_soft_deletes_its_photos(): void
    {
        $album = GalleryAlbum::factory()->create();
        $image = GalleryImage::factory()->create(['gallery_album_id' => $album->id]);

        $this->actingAs($this->admin)
            ->delete('/admin/gallery/'.$album->slug)
            ->assertRedirect('/admin/gallery');

        $this->assertSoftDeleted('gallery_albums', ['id' => $album->id]);
        $this->assertSoftDeleted('gallery_images', ['id' => $image->id]);
    }

    public function test_gallery_validation_rejects_invalid_albums_and_photos(): void
    {
        $album = GalleryAlbum::factory()->create();
        $this->trackUploads($album);

        $this->actingAs($this->admin)->from('/admin/gallery/create')
            ->post('/admin/gallery', ['title' => '', 'sort_order' => 1000])
            ->assertSessionHasErrors(['title', 'sort_order']);

        $this->actingAs($this->admin)->from('/admin/gallery/'.$album->slug.'/images')
            ->post('/admin/gallery/'.$album->slug.'/images', ['images' => []])
            ->assertSessionHasErrors('images');

        $this->actingAs($this->admin)->from('/admin/gallery/'.$album->slug.'/images')
            ->post('/admin/gallery/'.$album->slug.'/images', [
                'images' => [UploadedFile::fake()->create('notes.pdf', 100, 'application/pdf')],
            ])
            ->assertSessionHasErrors('images.0');

        $this->actingAs($this->admin)->from('/admin/gallery/'.$album->slug.'/images')
            ->post('/admin/gallery/'.$album->slug.'/images', [
                'images' => [UploadedFile::fake()->image('huge.jpg')->size(3000)],
            ])
            ->assertSessionHasErrors('images.0');

        $this->assertDatabaseMissing('gallery_albums', ['title' => '']);
        $this->assertSame(0, $album->images()->count());
    }

    public function test_non_admin_users_cannot_manage_the_gallery(): void
    {
        $user = User::factory()->create(['is_admin' => false]);
        $album = GalleryAlbum::factory()->create();

        $this->actingAs($user)->get('/admin/gallery')->assertForbidden();
        $this->actingAs($user)->get('/admin/gallery/'.$album->slug.'/images')->assertForbidden();
        $this->actingAs($user)->post('/admin/gallery', ['title' => 'Nope'])->assertForbidden();
    }

    private function trackUploads(GalleryAlbum $album): void
    {
        $this->uploadDirectories[] = public_path('images/gallery/uploads/'.$album->id);
    }
}
