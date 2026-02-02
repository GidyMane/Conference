<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SubmittedAbstract;
use App\Models\SubTheme;
use Illuminate\Support\Str;

class SubmittedAbstractSeeder extends Seeder
{
    public function run(): void
    {
        // Get existing sub themes (required because of FK)
        $subThemes = SubTheme::pluck('id');

        if ($subThemes->isEmpty()) {
            $this->command->warn('No sub_themes found. Seed sub_themes first.');
            return;
        }

        SubmittedAbstract::insert([
            [
                'submission_code' => 'ABS-' . Str::upper(Str::random(6)),
                'author_name' => 'Dr. Jane Mwangi',
                'author_email' => 'jane.mwangi@example.com',
                'author_phone' => '0712345678',
                'organisation' => 'KALRO',
                'department' => 'Crop Science',
                'position' => 'Research Scientist',
                'sub_theme_id' => $subThemes[0],
                'paper_title' => 'Climate-Resilient Maize Varieties',
                'abstract_text' => 'This study evaluates drought-tolerant maize varieties suitable for semi-arid regions.',
                'keywords' => 'maize, climate change, drought',
                'presentation_preference' => 'ORAL',
                'attendance_mode' => 'PHYSICAL',
                'special_requirements' => null,
                'status' => 'PENDING',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'submission_code' => 'ABS-' . Str::upper(Str::random(6)),
                'author_name' => 'Mr. Peter Otieno',
                'author_email' => 'peter.otieno@example.com',
                'author_phone' => '0722334455',
                'organisation' => 'University of Nairobi',
                'department' => 'Agricultural Economics',
                'position' => 'Lecturer',
                'sub_theme_id' => $subThemes[1] ?? $subThemes[0],
                'paper_title' => 'Market Access for Smallholder Farmers',
                'abstract_text' => 'An analysis of barriers affecting smallholder farmers’ access to regional markets.',
                'keywords' => 'markets, farmers, agriculture',
                'presentation_preference' => 'POSTER',
                'attendance_mode' => 'VIRTUAL',
                'special_requirements' => 'Zoom access',
                'status' => 'UNDER_REVIEW',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'submission_code' => 'ABS-' . Str::upper(Str::random(6)),
                'author_name' => 'Ms. Amina Hassan',
                'author_email' => 'amina.hassan@example.com',
                'author_phone' => null,
                'organisation' => 'Egerton University',
                'department' => 'Animal Science',
                'position' => 'Postgraduate Student',
                'sub_theme_id' => $subThemes[2] ?? $subThemes[0],
                'paper_title' => 'Improving Dairy Productivity in Kenya',
                'abstract_text' => 'This paper explores feed optimization strategies to improve milk yield.',
                'keywords' => 'dairy, livestock, productivity',
                'presentation_preference' => 'ORAL',
                'attendance_mode' => 'BOTH',
                'special_requirements' => null,
                'status' => 'APPROVED',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}