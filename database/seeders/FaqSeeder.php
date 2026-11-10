<?php

namespace Database\Seeders;

use App\Models\Faq;
use Illuminate\Database\Seeder;

class FaqSeeder extends Seeder
{
    public function run(): void
    {
        $faqs = [
            [
                'question' => 'What is child sponsorship?',
                'answer' => 'Child sponsorship is a regular commitment that helps HGCI provide a child in Uganda with food, quality education, healthcare and basic necessities. [ADD: sponsorship amount and payment details]',
                'category' => 'sponsorship',
                'sort_order' => 1,
            ],
            [
                'question' => 'How does child sponsorship work?',
                'answer' => 'You complete the sponsorship enquiry form and our team contacts you. We then match you with a child and share the next steps. [ADD: matching and onboarding process]',
                'category' => 'sponsorship',
                'sort_order' => 2,
            ],
            [
                'question' => 'How is my donation used?',
                'answer' => 'Donations support the general welfare and wellbeing of children, including food, education, health and livelihood projects. HGCI values transparency and accountability. [ADD: reporting and feedback details]',
                'category' => 'donations',
                'sort_order' => 3,
            ],
            [
                'question' => 'Can I communicate with the child I sponsor?',
                'answer' => '[ADD: policy on letters, photos and communication with sponsored children]',
                'category' => 'sponsorship',
                'sort_order' => 4,
            ],
            [
                'question' => 'Can I visit HGCI in Uganda?',
                'answer' => '[ADD: visit policy and arrangements]',
                'category' => 'general',
                'sort_order' => 5,
            ],
            [
                'question' => 'How can I volunteer or partner with HGCI?',
                'answer' => 'Use our volunteer form or contact us to discuss partnership. We welcome skills, time and in-kind support. [ADD: volunteer and partnership process]',
                'category' => 'volunteering',
                'sort_order' => 6,
            ],
        ];

        foreach ($faqs as $faq) {
            Faq::updateOrCreate(
                ['question' => $faq['question']],
                [
                    'answer' => $faq['answer'],
                    'category' => $faq['category'],
                    'sort_order' => $faq['sort_order'],
                    'is_published' => true,
                ],
            );
        }
    }
}
