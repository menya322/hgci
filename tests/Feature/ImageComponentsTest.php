<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ImageComponentsTest extends TestCase
{
    public function test_responsive_image_reserves_space_and_lazy_loads(): void
    {
        Storage::fake('public');
        Storage::disk('public')->put('posts/example.jpg', 'fake-image');

        $html = Blade::render(
            '<x-responsive-image src="posts/example.jpg" alt="Children learning" :width="1200" :height="750" ratio="16/10" />'
        );

        $this->assertStringContainsString('alt="Children learning"', $html);
        $this->assertStringContainsString('width="1200"', $html);
        $this->assertStringContainsString('height="750"', $html);
        $this->assertStringContainsString('loading="lazy"', $html);
        $this->assertStringContainsString('decoding="async"', $html);
        $this->assertStringContainsString('object-cover', $html);
        $this->assertStringContainsString('aspect-[16/10]', $html);
        $this->assertStringContainsString('storage/posts/example.jpg', $html);
        $this->assertStringNotContainsString('gradient', $html);
    }

    public function test_responsive_image_accepts_a_colon_separated_ratio(): void
    {
        Storage::fake('public');
        Storage::disk('public')->put('posts/example.jpg', 'fake-image');

        $html = Blade::render(
            '<x-responsive-image src="posts/example.jpg" alt="Team member" :width="800" :height="600" ratio="4:3" />'
        );

        $this->assertStringContainsString('aspect-[4/3]', $html);
    }

    public function test_responsive_image_passes_through_srcset_and_sizes(): void
    {
        Storage::fake('public');
        Storage::disk('public')->put('posts/example.jpg', 'fake-image');

        $html = Blade::render(
            '<x-responsive-image src="posts/example.jpg" alt="Children learning" :width="1200" :height="750" srcset="/storage/posts/example-600.jpg 600w, /storage/posts/example.jpg 1200w" sizes="(min-width: 1024px) 33vw, 100vw" />'
        );

        $this->assertStringContainsString('srcset="/storage/posts/example-600.jpg 600w, /storage/posts/example.jpg 1200w"', $html);
        $this->assertStringContainsString('sizes="(min-width: 1024px) 33vw, 100vw"', $html);
    }

    public function test_responsive_image_falls_back_to_a_flat_placeholder_when_the_file_is_missing(): void
    {
        Storage::fake('public');

        $html = Blade::render(
            '<x-responsive-image src="posts/missing.jpg" alt="Missing photo" :width="1200" :height="750" />'
        );

        $this->assertStringNotContainsString('<img', $html);
        $this->assertStringContainsString('bg-surface-warm', $html);
        $this->assertStringContainsString('[ADD: photo]', $html);
        $this->assertStringContainsString('role="img"', $html);
        $this->assertStringContainsString('aria-label="Missing photo"', $html);
    }

    public function test_responsive_image_uses_public_assets_when_requested(): void
    {
        $html = Blade::render(
            '<x-responsive-image src="images/about/hgci-profile.jpeg" alt="HGCI profile" :width="1080" :height="764" asset />'
        );

        $this->assertStringContainsString('src="'.asset('images/about/hgci-profile.jpeg').'"', $html);
        $this->assertStringContainsString('loading="lazy"', $html);
    }

    public function test_responsive_image_falls_back_when_a_public_asset_is_missing(): void
    {
        $html = Blade::render(
            '<x-responsive-image src="images/does-not-exist.jpg" alt="Missing asset" :width="1200" :height="750" asset />'
        );

        $this->assertStringNotContainsString('<img', $html);
        $this->assertStringContainsString('[ADD: photo]', $html);
    }

    public function test_hero_image_loads_eagerly_on_a_solid_overlay(): void
    {
        Storage::fake('public');
        Storage::disk('public')->put('hero/example.jpg', 'fake-image');

        $html = Blade::render(
            '<x-hero-image src="hero/example.jpg" alt="Children at a community day" :width="1600" :height="900" eyebrow="Our vision" title="Every child deserves hope." description="Walking with children and families in Uganda."><a href="/sponsor">Sponsor a child</a></x-hero-image>'
        );

        $this->assertStringContainsString('loading="eager"', $html);
        $this->assertStringNotContainsString('loading="lazy"', $html);
        $this->assertStringContainsString('fetchpriority="high"', $html);
        $this->assertStringContainsString('decoding="async"', $html);
        $this->assertStringContainsString('alt="Children at a community day"', $html);
        $this->assertStringContainsString('width="1600"', $html);
        $this->assertStringContainsString('height="900"', $html);
        $this->assertStringContainsString('aspect-[16/9]', $html);
        $this->assertStringContainsString('object-cover', $html);
        $this->assertStringContainsString('bg-black/50', $html);
        $this->assertStringContainsString('Every child deserves hope.', $html);
        $this->assertStringContainsString('Walking with children and families in Uganda.', $html);
        $this->assertStringContainsString('Sponsor a child', $html);
        $this->assertStringNotContainsString('gradient', $html);
    }

    public function test_hero_image_can_render_a_secondary_heading(): void
    {
        Storage::fake('public');
        Storage::disk('public')->put('hero/example.jpg', 'fake-image');

        $html = Blade::render(
            '<x-hero-image src="hero/example.jpg" alt="Children at a community day" :width="1600" :height="900" title="Our impact" as="h2" />'
        );

        $this->assertStringContainsString('<h2', $html);
        $this->assertStringNotContainsString('<h1', $html);
    }

    public function test_hero_image_falls_back_to_a_flat_panel_when_the_file_is_missing(): void
    {
        Storage::fake('public');

        $html = Blade::render(
            '<x-hero-image src="hero/missing.jpg" alt="Missing hero" :width="1600" :height="900" />'
        );

        $this->assertStringNotContainsString('<img', $html);
        $this->assertStringContainsString('bg-ink', $html);
        $this->assertStringContainsString('[ADD: hero photo]', $html);
        $this->assertStringContainsString('role="img"', $html);
        $this->assertStringContainsString('aria-label="Missing hero"', $html);
        $this->assertStringNotContainsString('gradient', $html);
    }

    public function test_hero_image_overlay_can_be_overridden(): void
    {
        Storage::fake('public');
        Storage::disk('public')->put('hero/example.jpg', 'fake-image');

        $html = Blade::render(
            '<x-hero-image src="hero/example.jpg" alt="Children at a community day" :width="1600" :height="900" overlay-class="bg-black/60" />'
        );

        $this->assertStringContainsString('bg-black/60', $html);
        $this->assertStringNotContainsString('bg-black/50', $html);
    }
}
