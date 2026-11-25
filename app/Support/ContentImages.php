<?php

namespace App\Support;

use App\Models\Event;
use App\Models\Post;
use App\Models\Program;
use App\Models\Project;
use App\Models\TeamMember;

/**
 * Resolves the photo for a program, project, story or event.
 *
 * Precedence:
 *   1. An image uploaded through the admin panel always wins.
 *   2. Otherwise a bundled photo under public/images is used.
 *   3. If that file is missing, or no photo is bundled at all, the caller
 *      renders the flat placeholder instead of a broken frame.
 *
 * Alt text always describes what is actually on screen: the real photo when
 * one exists, and a "photo to be added" note while the slot is empty.
 */
final class ContentImages
{
    /**
     * Bundled programme photos, resolved with asset() from public/images.
     */
    private const PROGRAMS = [
        'education' => [
            'src' => 'images/programs/education.jpg',
            'alt' => 'Students raising soap packets during a distribution at a school.',
            'width' => 800,
            'height' => 500,
            'asset' => true,
        ],
        'health-nutrition' => [
            'src' => 'images/programs/health-nutrition.jpg',
            'alt' => 'HGCI staff unloading boxes of sanitary pads from a vehicle outside a school.',
            'width' => 800,
            'height' => 500,
            'asset' => true,
        ],
        'livelihood' => [
            'src' => 'images/programs/livelihood.jpg',
            'alt' => 'HGCI staff sitting with a family outside their home during a community visit.',
            'width' => 1080,
            'height' => 810,
            'asset' => true,
        ],
        'food-relief' => [
            'src' => 'images/programs/food-relief.jpg',
            'alt' => 'An HGCI staff member giving bread to children outside a brick home.',
            'width' => 800,
            'height' => 500,
            'focus' => 'upper',
            'asset' => true,
        ],
        'child-sponsorship' => [
            'src' => 'images/programs/child-sponsorship.jpg',
            'alt' => 'An HGCI staff member standing beside a smiling young girl outdoors.',
            'width' => 800,
            'height' => 500,
            'focus' => 'upper',
            'asset' => true,
        ],
    ];

    /**
     * Bundled livelihood and relief project photos.
     *
     * The livestock slots have no photograph yet: their files are listed so the
     * expected path is documented, and the placeholder stays until a photo is
     * dropped in at that path (or uploaded through the admin panel).
     */
    private const PROJECTS = [
        'piggery' => [
            'src' => 'images/projects/piggery.jpg',
            'alt' => 'Pigs kept by a family taking part in the HGCI piggery project.',
            'width' => 800,
            'height' => 600,
            'asset' => true,
        ],
        'cow-rearing' => [
            'src' => 'images/projects/cow-rearing.jpg',
            'alt' => 'Cattle kept by a family taking part in the HGCI cow rearing project.',
            'width' => 800,
            'height' => 600,
            'asset' => true,
        ],
        'goat-rearing' => [
            'src' => 'images/projects/goat-rearing.jpg',
            'alt' => 'Goats kept by a family taking part in the HGCI goat rearing project.',
            'width' => 800,
            'height' => 600,
            'asset' => true,
        ],
        'food-relief-project' => [
            'src' => 'images/projects/food-relief.jpg',
            'alt' => 'An HGCI staff member sitting with a mother and child beside a food parcel at their home.',
            'width' => 800,
            'height' => 600,
            'focus' => 'upper',
            'asset' => true,
        ],
    ];

    /**
     * Bundled story photos, chosen by post category.
     *
     * Only categories with a genuinely matching photo are listed: a story in
     * any other category shows the placeholder rather than an unrelated image.
     */
    private const POSTS = [
        'education' => [
            'src' => 'images/posts/featured-story.jpg',
            'alt' => 'An HGCI staff member handing clothing to students in a school compound.',
            'width' => 1200,
            'height' => 900,
            'asset' => true,
        ],
        'health' => [
            'src' => 'images/gallery/health-hygiene/students-with-sanitary-supplies.jpeg',
            'alt' => 'Students in class with sanitary supplies stacked on the desk in front of them.',
            'width' => 1600,
            'height' => 1066,
            'asset' => true,
        ],
        'livelihood' => [
            'src' => 'images/programs/livelihood.jpg',
            'alt' => 'HGCI staff sitting with a family outside their home during a community visit.',
            'width' => 1080,
            'height' => 810,
            'asset' => true,
        ],
    ];

    /**
     * Optional banner photo for a story page, chosen by post slug.
     *
     * The story's own photograph already appears in the article body, so the
     * hero uses a second, related photo from the same work instead of showing
     * the same file twice. Stories without an entry keep the plain band.
     */
    private const POST_HEROES = [
        'add-story-livelihood-update' => [
            'src' => 'images/projects/food-relief.jpg',
            'alt' => 'HGCI staff sitting with a mother, her children and a food parcel outside their home.',
            'asset' => true,
        ],
        'add-story-health-nutrition-update' => [
            'src' => 'images/programs/health-nutrition.jpg',
            'alt' => 'HGCI staff unloading cartons of sanitary pads from a car outside a school.',
            'asset' => true,
        ],
    ];

    /**
     * Bundled event photos, chosen by event slug.
     */
    private const EVENTS = [
        'add-event-community-outreach' => [
            'src' => 'images/gallery/community-care/sitting-with-family.jpeg',
            'alt' => 'HGCI staff sitting on a mat with a mother and child during a community visit.',
            'width' => 1080,
            'height' => 810,
            'asset' => true,
        ],
        'add-event-sponsor-family-visit' => [
            'src' => 'images/programs/child-sponsorship.jpg',
            'alt' => 'An HGCI staff member standing beside a smiling young girl outdoors.',
            'width' => 800,
            'height' => 500,
            'asset' => true,
        ],
    ];

    /**
     * Image data for a program card or detail view.
     */
    public static function program(Program $program, string $ratio = '16/10'): array
    {
        return self::resolve(
            $program->image,
            $program->image_alt,
            $program->slug,
            $program->title,
            self::PROGRAMS,
            $ratio,
        );
    }

    /**
     * Image data for a project card or feature.
     */
    public static function project(Project $project, string $ratio = '16/10'): array
    {
        return self::resolve(
            $project->image,
            $project->image_alt,
            $project->slug,
            $project->title,
            self::PROJECTS,
            $ratio,
        );
    }

    /**
     * Image data for a story card or article.
     *
     * Stories are chosen by category, so a new story immediately inherits the
     * right photograph for its subject without touching any template.
     */
    public static function post(Post $post, string $ratio = '16/10'): array
    {
        return self::resolve(
            $post->featured_image,
            $post->image_alt,
            (string) $post->category,
            $post->title,
            self::POSTS,
            $ratio,
            'story photo',
        );
    }

    /**
     * Banner photo for a story page, or null to keep the plain hero band.
     *
     * Returns null while the mapped file is missing, so a page never points at
     * a photograph that is not on disk.
     *
     * @return array{src: string, alt: string}|null
     */
    public static function postHero(Post $post): ?array
    {
        $hero = self::POST_HEROES[$post->slug] ?? null;

        if ($hero === null || ImageSource::url($hero['src'], $hero['asset'] ?? true) === null) {
            return null;
        }

        return [
            'src' => $hero['src'],
            'alt' => $hero['alt'],
        ];
    }

    /**
     * Image data for an event card or detail page.
     */
    public static function event(Event $event, string $ratio = '16/9'): array
    {
        return self::resolve(
            $event->image,
            $event->image_alt,
            $event->slug,
            $event->title,
            self::EVENTS,
            $ratio,
            'event photo',
        );
    }

    /**
     * Image data for a team member card.
     */
    public static function teamMember(TeamMember $member, string $ratio = '4/3'): array
    {
        return self::resolve(
            $member->photo,
            'Photo of '.$member->name,
            $member->slug,
            $member->name,
            [],
            $ratio,
            'team photo',
        );
    }

    /**
     * Turn resolved image data into the absolute URL a social card can use.
     *
     * Returns null while the slot is still a placeholder, so a page never
     * advertises an image that is not on disk. Sizes are read from the file
     * itself rather than guessed, because og:image dimensions must match.
     *
     * @param  array<string, mixed>  $image  Data returned by program(), project(), post(), event() or teamMember().
     * @return array{url: string, alt: string, width: ?int, height: ?int}|null
     */
    public static function shareImage(array $image): ?array
    {
        $asset = (bool) ($image['asset'] ?? false);
        $disk = (string) ($image['disk'] ?? 'public');

        $url = ImageSource::url($image['src'] ?? null, $asset, $disk);

        if ($url === null) {
            return null;
        }

        $dimensions = ImageSource::dimensions($image['src'] ?? null, $asset, $disk);

        return [
            'url' => $url,
            'alt' => (string) ($image['alt'] ?? ''),
            'width' => $dimensions[0] ?? null,
            'height' => $dimensions[1] ?? null,
        ];
    }

    /**
     * @param  array<string, array<string, mixed>>  $fallbacks
     * @return array{src: ?string, alt: string, width: int, height: int, ratio: string, asset: bool, focus: string, label: string}
     */
    private static function resolve(
        ?string $image,
        ?string $alt,
        string $slug,
        string $title,
        array $fallbacks,
        string $ratio,
        ?string $slot = null,
    ): array {
        $slot ??= strtolower($title).' photo';

        $empty = [
            'src' => null,
            'alt' => 'Photo of '.$title.' to be added.',
            'width' => 1500,
            'height' => 1000,
            'ratio' => $ratio,
            'asset' => false,
            'focus' => 'center',
            'label' => '[ADD: '.$slot.']',
        ];

        if (filled($image)) {
            return [
                'src' => $image,
                'alt' => $alt ?: $title,
                'width' => 1500,
                'height' => 1000,
                'ratio' => $ratio,
                'asset' => false,
                'focus' => 'center',
                'label' => '[ADD: photo]',
            ];
        }

        $fallback = $fallbacks[$slug] ?? null;

        if ($fallback === null) {
            return $empty;
        }

        $resolved = array_merge($empty, $fallback);

        // A listed path whose file is not on disk yet must describe the empty
        // frame, not the photo that is still missing.
        if (ImageSource::url($resolved['src'], $resolved['asset'] ?? true, $resolved['disk'] ?? 'public') === null) {
            return $empty;
        }

        // A real photo resolved, so the hidden fallback layer keeps the plain
        // default label instead of the slot-specific placeholder text.
        $resolved['label'] = '[ADD: photo]';

        return $resolved;
    }
}
