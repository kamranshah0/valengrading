<?php

namespace Tests\Unit;

use App\Models\Submission;
use App\Models\SubmissionCard;
use App\Models\User;
use App\Models\ServiceLevel;
use App\Models\SubmissionType;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminSubmissionCardTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(\Database\Seeders\ServiceLevelSeeder::class);
        $this->seed(\Database\Seeders\SubmissionTypeSeeder::class);
    }

    public function test_card_status_update_does_not_require_title()
    {
        // 1. Setup
        $user = User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
        ]);
        // Force admin role if there's no role management, or just standard if it works
        // Assuming 'role' column exists based on previous grep/view
        $user->update(['email' => 'admin@test.com']); // ensure unique

        $level = ServiceLevel::first();
        $type = SubmissionType::first();

        $submission = Submission::create([
            'submission_no' => 'VAL-1001',
            'user_id' => $user->id,
            'status' => 'order_arrived',
            'service_level_id' => $level->id,
            'submission_type_id' => $type->id,
        ]);

        $card = SubmissionCard::create([
            'submission_id' => $submission->id,
            'title' => 'Test Card Title',
            'status' => 'Cards Logged',
            'qty' => 1
        ]);

        // 2. Act - Attempt status update without 'title'
        $response = $this->actingAs($user)
            ->patch(route('admin.submissions.cards.update', $card), [
                'status' => 'Grading Complete'
            ]);

        // 3. Assert
        $response->assertStatus(302); // Redirect back
        $this->assertDatabaseHas('submission_cards', [
            'id' => $card->id,
            'status' => 'Grading Complete',
            'title' => 'Test Card Title' // Title should NOT be cleared
        ]);
    }

    public function test_card_edit_with_is_revealed_preserves_data()
    {
         // 1. Setup
         $user = User::create([
            'name' => 'Admin User',
            'email' => 'admin2@example.com',
            'password' => bcrypt('password'),
        ]);

        $level = ServiceLevel::first();
        $type = SubmissionType::first();

        $submission = Submission::create([
            'submission_no' => 'VAL-1002',
            'user_id' => $user->id,
            'status' => 'order_arrived',
            'service_level_id' => $level->id,
            'submission_type_id' => $type->id,
        ]);

        $card = SubmissionCard::create([
            'submission_id' => $submission->id,
            'title' => 'Original Title',
            'is_revealed' => false,
            'qty' => 1
        ]);

        // 2. Act - Update only status
        $this->actingAs($user)
            ->patch(route('admin.submissions.cards.update', $card), [
                'status' => 'Label Created'
            ]);

        // 3. Assert - is_revealed should still be false because it wasn't in the request
        $this->assertDatabaseHas('submission_cards', [
            'id' => $card->id,
            'status' => 'Label Created',
            'is_revealed' => false
        ]);

        // 4. Act - Update with is_revealed true
        $this->actingAs($user)
            ->patch(route('admin.submissions.cards.update', $card), [
                'title' => 'Original Title',
                'status' => 'Label Created',
                'is_revealed' => '1'
            ]);

        // 5. Assert - is_revealed should now be true
        $this->assertDatabaseHas('submission_cards', [
            'id' => $card->id,
            'is_revealed' => true
        ]);
    }
}
