<?php

namespace Database\Seeders;

use App\Models\GalleryAlbum;
use Illuminate\Database\Seeder;

class GallerySeeder extends Seeder
{
    public function run(): void
    {
        $albums = [
            [
                'slug' => 'education-school-support',
                'title' => 'Education & school support',
                'description' => 'School visits, learning essentials and practical support that help children stay in class.',
                'cover' => 'images/gallery/education-school-support/school-hygiene-distribution.jpeg',
                'sort_order' => 1,
                'images' => [
                    [
                        'image' => 'images/gallery/education-school-support/clothing-support-at-school.jpeg',
                        'caption' => 'Clothing support during a school visit.',
                        'alt_text' => 'An HGCI team member handing out clothing to students in a school compound.',
                    ],
                    [
                        'image' => 'images/gallery/education-school-support/students-with-hygiene-supplies.jpeg',
                        'caption' => 'Students holding hygiene supplies after a school distribution.',
                        'alt_text' => 'A group of smiling students holding packets of soap in front of a school building.',
                    ],
                    [
                        'image' => 'images/gallery/education-school-support/school-hygiene-distribution.jpeg',
                        'caption' => 'Hygiene supplies shared with students and staff.',
                        'alt_text' => 'Students raising soap packets during a distribution at a school.',
                    ],
                    [
                        'image' => 'images/gallery/education-school-support/school-support-gathering.jpeg',
                        'caption' => 'A school community gathered for a support visit.',
                        'alt_text' => 'Students gathered outdoors with HGCI staff during a school support visit.',
                    ],
                ],
            ],
            [
                'slug' => 'health-hygiene',
                'title' => 'Health & hygiene',
                'description' => 'Health, nutrition and hygiene support that helps children grow up healthy and stay in school.',
                'cover' => 'images/gallery/health-hygiene/sanitary-pads-in-classroom.jpeg',
                'sort_order' => 2,
                'images' => [
                    [
                        'image' => 'images/gallery/health-hygiene/sanitary-pads-in-classroom.jpeg',
                        'caption' => 'Sanitary supplies prepared for students.',
                        'alt_text' => 'Packets of sanitary pads stacked on a classroom desk with students seated behind.',
                    ],
                    [
                        'image' => 'images/gallery/health-hygiene/unloading-hygiene-supplies.jpeg',
                        'caption' => 'Unloading hygiene supplies for a school distribution.',
                        'alt_text' => 'HGCI staff unloading boxes of sanitary pads from a vehicle outside a school.',
                    ],
                    [
                        'image' => 'images/gallery/health-hygiene/students-with-sanitary-supplies.jpeg',
                        'caption' => 'Students with sanitary supplies in class.',
                        'alt_text' => 'Students sitting at a classroom desk with packets of sanitary pads in front of them.',
                    ],
                    [
                        'image' => 'images/gallery/health-hygiene/children-at-water-point.jpeg',
                        'caption' => 'Children beside a local water point.',
                        'alt_text' => 'Three children standing beside a stream with jerrycans nearby.',
                    ],
                ],
            ],
            [
                'slug' => 'food-relief',
                'title' => 'Food relief',
                'description' => 'Food parcels and household visits that help families meet their immediate needs.',
                'cover' => 'images/gallery/food-relief/sharing-bread-with-children.jpeg',
                'sort_order' => 3,
                'images' => [
                    [
                        'image' => 'images/gallery/food-relief/family-receiving-food-parcel.jpeg',
                        'caption' => 'A household receives a food parcel.',
                        'alt_text' => 'HGCI staff handing a food parcel to a grandmother and children seated on a mat.',
                    ],
                    [
                        'image' => 'images/gallery/food-relief/food-parcel-for-household.jpeg',
                        'caption' => 'Food support delivered during a home visit.',
                        'alt_text' => 'A family sitting with HGCI staff beside bags of maize flour and other food items.',
                    ],
                    [
                        'image' => 'images/gallery/food-relief/relief-items-ready-for-distribution.jpeg',
                        'caption' => 'Relief items prepared for distribution.',
                        'alt_text' => 'Clothing, food and household items laid out on a mat ready for distribution.',
                    ],
                    [
                        'image' => 'images/gallery/food-relief/sharing-bread-with-children.jpeg',
                        'caption' => 'Bread shared with children during a home visit.',
                        'alt_text' => 'An HGCI staff member giving bread to children outside a brick home.',
                    ],
                    [
                        'image' => 'images/gallery/food-relief/food-relief-home-visit.jpeg',
                        'caption' => 'A family receives food support at home.',
                        'alt_text' => 'HGCI staff sitting with a mother and her children beside a bag of maize flour.',
                    ],
                ],
            ],
            [
                'slug' => 'clothing-essentials',
                'title' => 'Clothing & essentials',
                'description' => 'Clothing, shoes and everyday essentials given with dignity to children and families.',
                'cover' => 'images/gallery/clothing-essentials/clothing-distribution.jpeg',
                'sort_order' => 4,
                'images' => [
                    [
                        'image' => 'images/gallery/clothing-essentials/clothing-distribution.jpeg',
                        'caption' => 'Clothing distribution at a school.',
                        'alt_text' => 'An HGCI team member holding up a dress while students gather around donated clothes.',
                    ],
                    [
                        'image' => 'images/gallery/clothing-essentials/children-choosing-clothes.jpeg',
                        'caption' => 'Children choosing clothes during a distribution.',
                        'alt_text' => 'Students sorting through piles of donated clothing with HGCI staff.',
                    ],
                    [
                        'image' => 'images/gallery/clothing-essentials/sorting-donated-clothes.jpeg',
                        'caption' => 'Sorting donated clothes with students.',
                        'alt_text' => 'Students and HGCI staff sorting clothes on the ground outside a school.',
                    ],
                    [
                        'image' => 'images/gallery/clothing-essentials/handing-out-clothes.jpeg',
                        'caption' => 'Clothes shared with children at home.',
                        'alt_text' => 'An HGCI staff member handing a red garment to two children beside bags of food.',
                    ],
                    [
                        'image' => 'images/gallery/clothing-essentials/boys-with-new-clothes.jpeg',
                        'caption' => 'Three boys with clothing received during a home visit.',
                        'alt_text' => 'Three smiling boys standing against a brick wall with new clothes in their arms.',
                    ],
                    [
                        'image' => 'images/gallery/clothing-essentials/school-clothing-distribution.jpeg',
                        'caption' => 'School clothing and essentials distribution.',
                        'alt_text' => 'Students holding clothing and supplies during a distribution outside their classrooms.',
                    ],
                ],
            ],
            [
                'slug' => 'community-care',
                'title' => 'Community care',
                'description' => 'Home visits and time spent with children, families and community members.',
                'cover' => 'images/gallery/community-care/staff-with-family.jpeg',
                'sort_order' => 5,
                'images' => [
                    [
                        'image' => 'images/gallery/community-care/staff-with-family.jpeg',
                        'caption' => 'Sitting with a family during a home visit.',
                        'alt_text' => 'HGCI staff sitting with a grandmother, mother and young children outside a brick home.',
                    ],
                    [
                        'image' => 'images/gallery/community-care/community-home-visit.jpeg',
                        'caption' => 'A community home visit.',
                        'alt_text' => 'HGCI staff and community members sitting together during a home visit.',
                    ],
                    [
                        'image' => 'images/gallery/community-care/encouraging-a-child.jpeg',
                        'caption' => 'Spending time with a child during a community visit.',
                        'alt_text' => 'An HGCI staff member standing beside a smiling young girl outdoors.',
                    ],
                    [
                        'image' => 'images/gallery/community-care/staff-visiting-children.jpeg',
                        'caption' => 'Checking in with children and their family.',
                        'alt_text' => 'HGCI staff kneeling and sitting with children outside a home.',
                    ],
                    [
                        'image' => 'images/gallery/community-care/hgci-team-in-community.jpeg',
                        'caption' => 'The HGCI team in the community.',
                        'alt_text' => 'HGCI team members standing with a community member outdoors.',
                    ],
                    [
                        'image' => 'images/gallery/community-care/sitting-with-family.jpeg',
                        'caption' => 'Time with a mother and her child.',
                        'alt_text' => 'HGCI staff sitting on a mat with a mother and child outdoors.',
                    ],
                ],
            ],
        ];

        // Remove the original placeholder albums so the gallery shows real content.
        GalleryAlbum::query()
            ->whereIn('slug', ['life-at-hgci', 'add-album-title'])
            ->forceDelete();

        foreach ($albums as $data) {
            $album = GalleryAlbum::updateOrCreate(
                ['slug' => $data['slug']],
                [
                    'title' => $data['title'],
                    'description' => $data['description'],
                    'cover_image' => $data['cover'],
                    'is_published' => true,
                    'sort_order' => $data['sort_order'],
                ],
            );

            foreach ($data['images'] as $index => $image) {
                $album->images()->updateOrCreate(
                    ['sort_order' => $index + 1],
                    [
                        'image' => $image['image'],
                        'caption' => $image['caption'],
                        'alt_text' => $image['alt_text'],
                    ],
                );
            }

            $album->images()
                ->where('sort_order', '>', count($data['images']))
                ->forceDelete();
        }
    }
}
