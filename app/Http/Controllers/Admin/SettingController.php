<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SettingRequest;
use App\Models\Setting;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class SettingController extends Controller
{
    /**
     * Setting key => form field metadata, grouped for the settings page.
     */
    private const GROUPS = [
        'hero' => [
            'title' => 'Hero text',
            'description' => 'The headline and introduction shown at the top of the home page.',
            'fields' => [
                'hero.eyebrow' => ['name' => 'hero_eyebrow', 'label' => 'Eyebrow', 'type' => 'text'],
                'hero.title' => ['name' => 'hero_title', 'label' => 'Headline', 'type' => 'text', 'required' => true],
                'hero.description' => ['name' => 'hero_description', 'label' => 'Introduction', 'type' => 'textarea', 'required' => true, 'hint' => 'A short paragraph shown under the headline.'],
            ],
        ],
        'impact' => [
            'title' => 'Impact counters',
            'description' => 'Numbers shown in the impact strip. Only enter figures HGCI has verified.',
            'fields' => [
                'impact.children_reached' => ['name' => 'impact_children_reached', 'label' => 'Children reached', 'type' => 'text'],
                'impact.projects_supported' => ['name' => 'impact_projects_supported', 'label' => 'Projects supported', 'type' => 'text'],
                'impact.communities_served' => ['name' => 'impact_communities_served', 'label' => 'Communities served', 'type' => 'text'],
            ],
        ],
        'contact' => [
            'title' => 'Contact information',
            'description' => 'Used on the contact page, header and footer. Leave the [ADD: ...] placeholders until HGCI confirms the details.',
            'fields' => [
                'contact.address_line1' => ['name' => 'contact_address_line1', 'label' => 'Address line 1', 'type' => 'text'],
                'contact.address_line2' => ['name' => 'contact_address_line2', 'label' => 'Address line 2', 'type' => 'text'],
                'contact.country' => ['name' => 'contact_country', 'label' => 'Country', 'type' => 'text'],
                'contact.phone' => ['name' => 'contact_phone', 'label' => 'Phone number', 'type' => 'text'],
                'contact.email' => ['name' => 'contact_email', 'label' => 'Public email address', 'type' => 'text', 'hint' => 'Enter a real address, or keep the [ADD: ...] placeholder.'],
                'contact.notification_email' => ['name' => 'contact_notification_email', 'label' => 'Admin notification email', 'type' => 'text', 'hint' => 'Receives notifications from the contact, sponsorship, donation and volunteer forms. Enter a real address, or keep the [ADD: ...] placeholder.'],
                'contact.office_hours' => ['name' => 'contact_office_hours', 'label' => 'Office hours', 'type' => 'text'],
            ],
        ],
        'social' => [
            'title' => 'Social profiles',
            'description' => 'Full profile URLs linked in the footer. Leave the [ADD: ...] placeholders until the accounts are confirmed.',
            'fields' => [
                'social.facebook' => ['name' => 'social_facebook', 'label' => 'Facebook URL', 'type' => 'text'],
                'social.instagram' => ['name' => 'social_instagram', 'label' => 'Instagram URL', 'type' => 'text'],
                'social.x' => ['name' => 'social_x', 'label' => 'X (Twitter) URL', 'type' => 'text'],
                'social.youtube' => ['name' => 'social_youtube', 'label' => 'YouTube URL', 'type' => 'text'],
            ],
        ],
        'giving' => [
            'title' => 'Donation details',
            'description' => 'Shown on the donate page. Leave the [ADD: ...] placeholders until HGCI confirms its giving channels.',
            'fields' => [
                'giving.mobile_money_provider' => ['name' => 'giving_mobile_money_provider', 'label' => 'Mobile money provider', 'type' => 'text'],
                'giving.mobile_money_account_name' => ['name' => 'giving_mobile_money_account_name', 'label' => 'Mobile money account name', 'type' => 'text'],
                'giving.mobile_money_number' => ['name' => 'giving_mobile_money_number', 'label' => 'Mobile money number', 'type' => 'text'],
                'giving.bank_name' => ['name' => 'giving_bank_name', 'label' => 'Bank name', 'type' => 'text'],
                'giving.bank_account_name' => ['name' => 'giving_bank_account_name', 'label' => 'Bank account name', 'type' => 'text'],
                'giving.bank_account_number' => ['name' => 'giving_bank_account_number', 'label' => 'Bank account number', 'type' => 'text'],
                'giving.bank_branch' => ['name' => 'giving_bank_branch', 'label' => 'Bank branch', 'type' => 'text'],
                'giving.bank_swift' => ['name' => 'giving_bank_swift', 'label' => 'SWIFT code', 'type' => 'text'],
                'giving.instructions' => ['name' => 'giving_instructions', 'label' => 'Giving instructions', 'type' => 'textarea', 'hint' => 'Extra guidance shown with the giving details.'],
            ],
        ],
    ];

    public function edit(): View
    {
        return view('admin.settings.edit', [
            'groups' => self::GROUPS,
            'settings' => Setting::allKeyed(),
        ]);
    }

    public function update(SettingRequest $request): RedirectResponse
    {
        $data = $request->validated();

        foreach (self::GROUPS as $group => $config) {
            foreach ($config['fields'] as $key => $field) {
                Setting::put($key, $data[$field['name']] ?? '', 'text', $group);
            }
        }

        return redirect()
            ->route('admin.settings.edit')
            ->with('status', 'Settings saved.');
    }
}
