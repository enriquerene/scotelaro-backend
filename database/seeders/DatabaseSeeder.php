<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // First, create default modalities if none exist
        if (\App\Models\Modality::count() === 0) {
            $factory = new \Database\Factories\ModalityFactory();
            $defaultModalities = $factory->defaultModalities();
            
            foreach ($defaultModalities as $modalityData) {
                \App\Models\Modality::create($modalityData);
            }
            
            $this->command->info("Created " . count($defaultModalities) . " default modalities");
        }

        // Create a pricing tier if none exists
        $pricingTier = \App\Models\PricingTier::first();
        if (!$pricingTier) {
            $pricingTier = \App\Models\PricingTier::create([
                'name' => 'Basic Plan',
                'notes' => 'Access to 3 classes per week',
                'price' => 99.90,
                'class_count' => 3,
            ]);
            $this->command->info("Created pricing tier: {$pricingTier->name}");
        }

        // 1. Student without enrollment (for testing onboarding flow)
        $studentWithoutEnrollment = User::factory()->create([
            'name' => 'João Silva (Student - No Subscription)',
            'email' => 'joao.silva@example.com',
            'phone' => '+55 (11) 98765-4321',
            'role' => \App\Models\User::ROLE_STUDENT,
        ]);
        
        $this->command->info("Created student without subscription: joao.silva@example.com / password");

        // 2. Student with subscription (for testing app access)
        $studentWithSubscription = User::factory()->create([
            'name' => 'Maria Santos (Student - With Subscription)',
            'email' => 'maria.santos@example.com',
            'phone' => '+55 (21) 99876-5432',
            'role' => \App\Models\User::ROLE_STUDENT,
        ]);
        
        // Create a subscription for this student (using only existing columns)
        $studentWithSubscription->subscriptions()->create([
            'pricing_tier_id' => $pricingTier->id,
            'starts_at' => now(),
            'ends_at' => now()->addMonth(),
            'status' => 'active',
        ]);
        
        $this->command->info("Created student with subscription: maria.santos@example.com / password");

        // 3. Admin user (for creating resources manually)
        $adminUser = User::factory()->admin()->create([
            'name' => 'Admin User',
            'email' => 'admin@scotelaro.com',
            'phone' => '+55 (31) 91234-5678',
        ]);
        
        $this->command->info("Created admin user: admin@scotelaro.com / password");

        // 4. Staff user (optional, for testing different roles)
        $staffUser = User::factory()->staff()->create([
            'name' => 'Carlos Oliveira (Staff)',
            'email' => 'carlos.oliveira@example.com',
            'phone' => '+55 (41) 92345-6789',
        ]);
        
        $this->command->info("Created staff user: carlos.oliveira@example.com / password");

        // Create a few more random students for testing
        User::factory()->count(3)->create([
            'role' => \App\Models\User::ROLE_STUDENT,
        ]);
        
        $this->command->info("Created 3 additional random student users");
        $this->command->info("\n=== Login Credentials ===");
        $this->command->info("All users have password: 'password'");
        $this->command->info("Student (no subscription): joao.silva@example.com");
        $this->command->info("Student (with subscription): maria.santos@example.com");
        $this->command->info("Admin: admin@scotelaro.com");
        $this->command->info("Staff: carlos.oliveira@example.com");
    }
}
