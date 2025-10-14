<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        $tables = [
            'users',
            'courses',
            'course_categories',
            'course_sub_categories',
            'course_classes',
            'course_materials',
            'teacher_professional_info',
            'teacher_personals',
            'teacher_subjects',
            'teacher_working_days',
            'teacher_working_hours',
            'teacher_grades',
            'student_personal_info',
            'student_activities',
            'student_available_days',
            'student_available_hours',
            'student_grades',
            'user_additional_info',
            'coupons',
            'coupon_course',
            'media_files',
            'media_folders',
            'payroll_details',
            'payroll_advances',
            'support_tickets',
            'support_ticket_attachments',
            'activity_logs',
            'api_logs',
            'companies',
            'roles',
            'permissions',
            'company_permissions',
            'webinars',
            'webinar_registrations',
            'stream_providers',
            'provider_credentials',
        ];

        foreach ($tables as $table) {
            Schema::table($table, function (Blueprint $table) {
                if (!Schema::hasColumn($table->getTable(), 'deleted_at')) {
                    $table->softDeletes();
                }
            });
        }
    }

    public function down(): void
    {
        $tables = [
            'users', 'courses', 'course_categories', 'course_sub_categories',
            'course_classes', 'course_materials', 'teacher_professional_info',
            'teacher_personals', 'teacher_subjects', 'teacher_working_days',
            'teacher_working_hours', 'teacher_grades', 'student_personal_info',
            'student_activities', 'student_available_days', 'student_available_hours',
            'student_grades', 'user_additional_info', 'coupons', 'coupon_course',
            'media_files', 'media_folders', 'payroll_details', 'payroll_advances',
            'support_tickets', 'support_ticket_attachments', 'activity_logs',
            'api_logs', 'companies', 'roles', 'permissions', 'company_permissions',
            'webinars', 'webinar_registrations', 'stream_providers', 'provider_credentials',
        ];

        foreach ($tables as $table) {
            Schema::table($table, function (Blueprint $table) {
                if (Schema::hasColumn($table->getTable(), 'deleted_at')) {
                    $table->dropSoftDeletes();
                }
            });
        }
    }
};
