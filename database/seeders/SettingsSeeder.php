<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            // Brand and hero copy.
            ['site.tagline', 'Child sponsorship & Christian humanitarian aid in Uganda', 'text', 'site'],
            ['hero.eyebrow', 'Child sponsorship in Uganda', 'text', 'home'],
            ['hero.title', 'Every child deserves hope.', 'text', 'home'],
            ['hero.description', 'Hope In God Child Initiatives is a child sponsorship and Christian humanitarian aid organization transforming the lives of orphans and vulnerable children in Uganda.', 'text', 'home'],

            // Organisation content from the HGCI brochure.
            ['about.who_we_are', 'Hope In God Child Initiatives (HGCI) is a child sponsorship and Christian Humanitarian Aid Organization that works to transform the lives of orphans and vulnerable groups of people in Uganda. It was founded with an aim to ensure the general welfare and wellbeing of children, including provision of food and other basic necessities. HGCI ensures that all children get quality education and develop into responsible adult citizens of Uganda.', 'text', 'about'],
            ['about.vision', 'Reach to the Poor of the Poorest.', 'text', 'about'],
            ['about.mission', "Transform children's lives living in poverty in Uganda communities.", 'text', 'about'],
            ['about.core_values', ['Love', 'Team work', 'Compassion', 'Transparency', 'Excellence'], 'json', 'about'],
            ['about.niche', ['Health', 'Education', 'Livelihood'], 'json', 'about'],
            ['about.approach', 'HGCI employs a community-based approach in achieving its objectives by promoting active participation of community members in fighting poverty.', 'text', 'about'],
            ['about.strategic_goal', 'To ensure that all children get quality education and develop into responsible adult citizens of the country.', 'text', 'about'],

            // Contact details are placeholders until HGCI supplies them.
            ['contact.address_line1', '[ADD: physical address]', 'text', 'contact'],
            ['contact.address_line2', '[ADD: city and district]', 'text', 'contact'],
            ['contact.country', 'Uganda', 'text', 'contact'],
            ['contact.phone', '[ADD: phone number]', 'text', 'contact'],
            ['contact.email', '[ADD: email address]', 'text', 'contact'],
            ['contact.notification_email', '[ADD: notification email address]', 'text', 'contact'],
            ['contact.office_hours', '[ADD: office hours]', 'text', 'contact'],

            // Social profiles are placeholders until HGCI supplies the links.
            ['social.facebook', '[ADD: Facebook URL]', 'text', 'social'],
            ['social.instagram', '[ADD: Instagram URL]', 'text', 'social'],
            ['social.x', '[ADD: X URL]', 'text', 'social'],
            ['social.youtube', '[ADD: YouTube URL]', 'text', 'social'],

            // Giving details are placeholders until HGCI supplies them.
            ['giving.mobile_money_provider', '[ADD: mobile money provider]', 'text', 'giving'],
            ['giving.mobile_money_account_name', '[ADD: mobile money account name]', 'text', 'giving'],
            ['giving.mobile_money_number', '[ADD: mobile money number]', 'text', 'giving'],
            ['giving.bank_name', '[ADD: bank name]', 'text', 'giving'],
            ['giving.bank_account_name', '[ADD: bank account name]', 'text', 'giving'],
            ['giving.bank_account_number', '[ADD: bank account number]', 'text', 'giving'],
            ['giving.bank_branch', '[ADD: bank branch]', 'text', 'giving'],
            ['giving.bank_swift', '[ADD: SWIFT code]', 'text', 'giving'],
            ['giving.instructions', '[ADD: giving instructions]', 'text', 'giving'],

            // Impact counters are placeholders; no figures have been supplied.
            ['impact.children_reached', '[ADD: number of children reached]', 'text', 'impact'],
            ['impact.projects_supported', '[ADD: number of projects supported]', 'text', 'impact'],
            ['impact.communities_served', '[ADD: number of communities served]', 'text', 'impact'],

            // SEO.
            ['seo.default_description', 'Hope In God Child Initiatives (HGCI) is a child sponsorship and Christian humanitarian aid organization transforming the lives of orphans and vulnerable children in Uganda.', 'text', 'seo'],
        ];

        foreach ($settings as [$key, $value, $type, $group]) {
            Setting::put($key, $value, $type, $group);
        }
    }
}
