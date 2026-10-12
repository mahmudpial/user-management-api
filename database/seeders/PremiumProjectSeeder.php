<?php

namespace Database\Seeders;

use App\Models\PremiumProject;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PremiumProjectSeeder extends Seeder
{
    public function run(): void
    {
        $projects = [
            [
                'title' => 'SaaS Attendance ERP',
                'summary' => 'A multi-tenant workforce platform for attendance, shifts, leave, payroll exports, and team reporting.',
                'full_description' => <<<'MARKDOWN'
## SaaS Attendance ERP

A production-minded workforce management starter for agencies and growing businesses. It includes role-based workspaces, attendance tracking, shift scheduling, leave approvals, and export-ready payroll summaries.

Designed for teams that need a strong foundation they can brand and extend rather than starting from a blank repository.
MARKDOWN,
                'thumbnail_url' => 'https://images.unsplash.com/photo-1551434678-e076c223a692',
                'live_demo_url' => 'https://demo.example.com/attendance-erp',
                'video_preview_url' => 'https://www.youtube.com/watch?v=ScMzIvxBSi4',
                'tech_stack' => ['Laravel 12', 'Vue 3', 'PostgreSQL', 'Redis', 'Docker'],
                'is_featured' => true,
                'is_published' => true,
                'order' => 1,
                'pricing_tiers' => [
                    [
                        'tier_name' => 'Single License',
                        'price' => 129.00,
                        'discount_price' => 99.00,
                        'features' => ['One production deployment', 'Source code and setup guide', '12 months of updates'],
                    ],
                    [
                        'tier_name' => 'Commercial / Multi-use',
                        'price' => 349.00,
                        'features' => ['Unlimited deployments for one organization', 'Priority setup guidance', '12 months of updates'],
                    ],
                    [
                        'tier_name' => 'Full White-label Resell',
                        'price' => 799.00,
                        'features' => ['Rebrand and resell to clients', 'Extended commercial usage', '12 months of updates'],
                    ],
                ],
            ],
            [
                'title' => 'Multi-vendor eCommerce Marketplace',
                'summary' => 'A marketplace foundation with vendor onboarding, catalog management, commission rules, and order workflows.',
                'full_description' => <<<'MARKDOWN'
## Multi-vendor eCommerce Marketplace

A complete marketplace starter that brings customer shopping, vendor operations, and administrator oversight into one application. Build on vendor onboarding, product moderation, configurable commissions, order tracking, and sales dashboards.

Payment provider credentials and production configuration are intentionally left to the purchaser.
MARKDOWN,
                'thumbnail_url' => 'https://images.unsplash.com/photo-1556742049-0cfed4f6a45d',
                'live_demo_url' => 'https://demo.example.com/vendor-marketplace',
                'video_preview_url' => 'https://www.youtube.com/watch?v=ysz5S6PUM-U',
                'tech_stack' => ['Laravel 12', 'React', 'Inertia.js', 'MySQL', 'Stripe-ready'],
                'is_featured' => true,
                'is_published' => true,
                'order' => 2,
                'pricing_tiers' => [
                    [
                        'tier_name' => 'Single License',
                        'price' => 179.00,
                        'discount_price' => 149.00,
                        'features' => ['One marketplace deployment', 'Vendor and admin dashboards', 'Documentation and updates'],
                    ],
                    [
                        'tier_name' => 'Commercial / Multi-use',
                        'price' => 499.00,
                        'features' => ['Multiple deployments for one business', 'Commercial customization rights', 'Priority support'],
                    ],
                    [
                        'tier_name' => 'Full White-label Resell',
                        'price' => 1199.00,
                        'features' => ['Rebrand for client projects', 'Resell under your own brand', 'Extended commercial rights'],
                    ],
                ],
            ],
            [
                'title' => 'AI Content Engine',
                'summary' => 'A content operations dashboard with prompt templates, campaign workflows, and pluggable AI provider configuration.',
                'full_description' => <<<'MARKDOWN'
## AI Content Engine

A reusable content workspace for planning campaigns and drafting consistent marketing assets. It includes reusable prompt templates, content calendars, approval stages, and provider configuration points for connecting your preferred AI service.

AI provider accounts, API keys, and usage costs are not included with the source code.
MARKDOWN,
                'thumbnail_url' => 'https://images.unsplash.com/photo-1677442136019-21780ecad995',
                'live_demo_url' => 'https://demo.example.com/ai-content-engine',
                'video_preview_url' => 'https://www.youtube.com/watch?v=aircAruvnKk',
                'tech_stack' => ['Laravel 12', 'Next.js', 'TypeScript', 'PostgreSQL', 'OpenAI-compatible API'],
                'is_featured' => false,
                'is_published' => true,
                'order' => 3,
                'pricing_tiers' => [
                    [
                        'tier_name' => 'Single License',
                        'price' => 89.00,
                        'discount_price' => 69.00,
                        'features' => ['One production deployment', 'Content workflow starter', 'Documentation and updates'],
                    ],
                    [
                        'tier_name' => 'Commercial / Multi-use',
                        'price' => 249.00,
                        'features' => ['Multiple deployments for one organization', 'Commercial usage', 'Priority setup guidance'],
                    ],
                    [
                        'tier_name' => 'Full White-label Resell',
                        'price' => 599.00,
                        'features' => ['Rebrand and resell to clients', 'Extended commercial rights', '12 months of updates'],
                    ],
                ],
            ],
        ];

        foreach ($projects as $attributes) {
            $tiers = $attributes['pricing_tiers'];
            unset($attributes['pricing_tiers']);

            $project = PremiumProject::updateOrCreate(['slug' => Str::slug($attributes['title'])], $attributes);

            foreach ($tiers as $tier) {
                $project->pricingTiers()->updateOrCreate(['tier_name' => $tier['tier_name']], $tier + [
                    'billing_type' => 'one_time',
                    'file_path' => null,
                ]);
            }
        }
    }
}
