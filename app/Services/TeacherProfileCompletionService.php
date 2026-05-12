<?php

namespace App\Services;

use App\Models\User;

class TeacherProfileCompletionService
{
    public static function calculate(User $user): array
    {

        $sections = [

            // =========================
            // Personal Information
            // =========================
            'personal_information' => [
                'label' => 'Personal Information',
                'percentage' => 10,
                'completed' => false,
            ],

            // =========================
            // Teaching Details
            // =========================
            'teaching_details' => [
                'label' => 'Teaching Details',
                'percentage' => 10,
                'completed' => false,
            ],

            // =========================
            // Upload CV
            // =========================
            'upload_cv' => [
                'label' => 'Upload CV',
                'percentage' => 10,
                'completed' => false,
            ],

            // =========================
            // App Showing Details
            // =========================
            'app_showing_details' => [
                'label' => 'App Showing Details',
                'percentage' => 20,
                'completed' => false,
            ],

            // =========================
            // Teaching Grades
            // =========================
            'teaching_grades' => [
                'label' => 'Teaching Grades',
                'percentage' => 20,
                'completed' => false,
            ],

            // =========================
            // Teaching Slots
            // =========================
            'teaching_slots' => [
                'label' => 'Teaching Slots',
                'percentage' => 10,
                'completed' => false,
            ],

            // =========================
            // App Avatar
            // =========================
            'app_avatar' => [
                'label' => 'App Avatar',
                'percentage' => 20,
                'completed' => false,
            ],

        ];

        $total = 0;

        // =====================================================
        // PERSONAL INFORMATION
        // =====================================================

        if (
            !empty($user->name) &&
            !empty($user->email) &&
            !empty($user->mobile)
        ) {

            $sections['personal_information']['completed'] = true;

            $total += $sections['personal_information']['percentage'];
        }

        // =====================================================
        // TEACHING DETAILS
        // =====================================================

        if (
            !empty($user->teacherDetails?->experience) &&
            !empty($user->teacherDetails?->about_me) &&
            !empty($user->teacherDetails?->qualification)
        ) {

            $sections['teaching_details']['completed'] = true;

            $total += $sections['teaching_details']['percentage'];
        }

        // =====================================================
        // UPLOAD CV
        // =====================================================

        if (!empty($user->teacherDetails?->cv)) {

            $sections['upload_cv']['completed'] = true;

            $total += $sections['upload_cv']['percentage'];
        }

        // =====================================================
        // APP SHOWING DETAILS
        // =====================================================

        if (
            !empty($user->teacherDetails?->app_title) &&
            !empty($user->teacherDetails?->app_description) &&
            !empty($user->teacherDetails?->tag_line)
        ) {

            $sections['app_showing_details']['completed'] = true;

            $total += $sections['app_showing_details']['percentage'];
        }

        // =====================================================
        // TEACHING GRADES
        // =====================================================

        if (
            $user->teachingGrades &&
            $user->teachingGrades->count() > 0
        ) {

            $sections['teaching_grades']['completed'] = true;

            $total += $sections['teaching_grades']['percentage'];
        }

        // =====================================================
        // TEACHING SLOTS
        // =====================================================

        if (
            $user->teachingSlots &&
            $user->teachingSlots->count() > 0
        ) {

            $sections['teaching_slots']['completed'] = true;

            $total += $sections['teaching_slots']['percentage'];
        }

        // =====================================================
        // APP AVATAR
        // =====================================================

        if (!empty($user->app_avatar)) {

            $sections['app_avatar']['completed'] = true;

            $total += $sections['app_avatar']['percentage'];
        }

        // =====================================================
        // PENDING SECTIONS
        // =====================================================

        $pendingSections = collect($sections)
            ->filter(function ($item) {

                return $item['completed'] == false;

            })
            ->pluck('label')
            ->values();

        // =====================================================
        // COMPLETED SECTIONS
        // =====================================================

        $completedSections = collect($sections)
            ->filter(function ($item) {

                return $item['completed'] == true;

            })
            ->pluck('label')
            ->values();

        return [

            'total_percentage' => $total,

            'sections' => $sections,

            'completed_sections' => $completedSections,

            'pending_sections' => $pendingSections,

            'is_completed' => $total >= 100,

        ];
    }
}
