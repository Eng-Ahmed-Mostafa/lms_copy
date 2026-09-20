<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /*
        |--------------------------------------------------------------------------
        | 01. Create Permissions
        |--------------------------------------------------------------------------
        */

        $permissions = [

            /*
            |--------------------------------------------------------------------------
            | 01. Identity & Access
            |--------------------------------------------------------------------------
            */

            'users.view',
            'users.create',
            'users.update',
            'users.delete',
            'users.restore',
            'users.force-delete',

            'roles.view',
            'roles.create',
            'roles.update',
            'roles.delete',
            'roles.assign',

            'permissions.view',
            'permissions.create',
            'permissions.update',
            'permissions.delete',
            'permissions.assign',

            'auth.login',
            'auth.logout',
            'auth.register',
            'auth.refresh-token',
            'auth.forgot-password',
            'auth.reset-password',
            'auth.verify-email',
            'auth.resend-verification-email',
            'auth.verify-phone',
            'auth.resend-verification-phone',

            'devices.view',
            'devices.revoke',
            'devices.revoke-all',

            'login-attempts.view',
            'login-attempts.delete',

            'sessions.view',
            'sessions.revoke',
            'sessions.revoke-all',

            'preferences.view',
            'preferences.update',

            'audit-logs.view',
            'audit-logs.delete',

            /*
            |--------------------------------------------------------------------------
            | 02. Academic Structure
            |--------------------------------------------------------------------------
            */

            'academic-years.view',
            'academic-years.create',
            'academic-years.update',
            'academic-years.delete',
            'academic-years.restore',

            'terms.view',
            'terms.create',
            'terms.update',
            'terms.delete',

            'grades.view',
            'grades.create',
            'grades.update',
            'grades.delete',

            'sections.view',
            'sections.create',
            'sections.update',
            'sections.delete',

            'subjects.view',
            'subjects.create',
            'subjects.update',
            'subjects.delete',

            'departments.view',
            'departments.create',
            'departments.update',
            'departments.delete',

            /*
            |--------------------------------------------------------------------------
            | 03. People
            |--------------------------------------------------------------------------
            */

            'students.view',
            'students.create',
            'students.update',
            'students.delete',
            'students.restore',
            'students.suspend',

            'teachers.view',
            'teachers.create',
            'teachers.update',
            'teachers.delete',
            'teachers.restore',
            'teachers.suspend',

            'parents.view',
            'parents.create',
            'parents.update',
            'parents.delete',

            'parent-student.view',
            'parent-student.create',
            'parent-student.update',
            'parent-student.delete',

            'staff.view',
            'staff.create',
            'staff.update',
            'staff.delete',

            'profiles.view',
            'profiles.update',

            /*
            |--------------------------------------------------------------------------
            | 04. Courses & Content
            |--------------------------------------------------------------------------
            */

            'courses.view',
            'courses.create',
            'courses.update',
            'courses.delete',
            'courses.restore',
            'courses.publish',
            'courses.unpublish',
            'courses.approve',
            'courses.reject',
            'courses.archive',

            'course-categories.view',
            'course-categories.create',
            'course-categories.update',
            'course-categories.delete',

            'course-sections.view',
            'course-sections.create',
            'course-sections.update',
            'course-sections.delete',
            'course-sections.reorder',

            'lessons.view',
            'lessons.create',
            'lessons.update',
            'lessons.delete',
            'lessons.restore',
            'lessons.publish',
            'lessons.unpublish',
            'lessons.reorder',

            'lesson-content.view',
            'lesson-content.create',
            'lesson-content.update',
            'lesson-content.delete',

            'lesson-versions.view',
            'lesson-versions.create',
            'lesson-versions.update',
            'lesson-versions.delete',
            'lesson-versions.restore',
            'lesson-versions.compare',

            'content-approvals.view',
            'content-approvals.submit',
            'content-approvals.approve',
            'content-approvals.reject',
            'content-approvals.request-changes',

            'course-teachers.view',
            'course-teachers.assign',
            'course-teachers.remove',

            'course-resources.view',
            'course-resources.create',
            'course-resources.update',
            'course-resources.delete',

            /*
            |--------------------------------------------------------------------------
            | 05. Enrollment
            |--------------------------------------------------------------------------
            */

            'enrollments.view',
            'enrollments.create',
            'enrollments.update',
            'enrollments.delete',
            'enrollments.cancel',
            'enrollments.approve',
            'enrollments.reject',

            'enrollment-history.view',

            'course-access.grant',
            'course-access.revoke',

            'waitlists.view',
            'waitlists.create',
            'waitlists.delete',

            /*
            |--------------------------------------------------------------------------
            | 06. Learning Progress
            |--------------------------------------------------------------------------
            */

            'learning-progress.view',
            'learning-progress.update',
            'learning-progress.reset',

            'lesson-progress.view',
            'lesson-progress.update',
            'lesson-progress.reset',

            'course-progress.view',
            'course-progress.update',
            'course-progress.reset',

            'learning-activity.view',

            'attendance.view',
            'attendance.create',
            'attendance.update',
            'attendance.delete',

            'student-statistics.view',

            /*
            |--------------------------------------------------------------------------
            | 07. Assessments
            |--------------------------------------------------------------------------
            */

            'assessments.view',
            'assessments.create',
            'assessments.update',
            'assessments.delete',
            'assessments.publish',
            'assessments.unpublish',

            'questions.view',
            'questions.create',
            'questions.update',
            'questions.delete',
            'questions.import',
            'questions.export',

            'question-banks.view',
            'question-banks.create',
            'question-banks.update',
            'question-banks.delete',

            'question-options.view',
            'question-options.create',
            'question-options.update',
            'question-options.delete',

            'exam-attempts.view',
            'exam-attempts.start',
            'exam-attempts.submit',
            'exam-attempts.cancel',
            'exam-attempts.reset',

            'exam-results.view',
            'exam-results.publish',
            'exam-results.update',

            /*
            |--------------------------------------------------------------------------
            | NOTE:
            | grades.* already exists in Academic Structure.
            | Do not duplicate it here.
            |--------------------------------------------------------------------------
            */

            'grading.view',
            'grading.create',
            'grading.update',

            /*
            |--------------------------------------------------------------------------
            | 08. Assignments
            |--------------------------------------------------------------------------
            */

            'assignments.view',
            'assignments.create',
            'assignments.update',
            'assignments.delete',
            'assignments.publish',
            'assignments.unpublish',

            'assignment-submissions.view',
            'assignment-submissions.create',
            'assignment-submissions.update',
            'assignment-submissions.delete',
            'assignment-submissions.submit',
            'assignment-submissions.resubmit',

            'assignment-grades.view',
            'assignment-grades.create',
            'assignment-grades.update',
            'assignment-grades.delete',

            'assignment-feedback.view',
            'assignment-feedback.create',
            'assignment-feedback.update',
            'assignment-feedback.delete',

            /*
            |--------------------------------------------------------------------------
            | 09. Live Classes
            |--------------------------------------------------------------------------
            */

            'live-classes.view',
            'live-classes.create',
            'live-classes.update',
            'live-classes.delete',
            'live-classes.start',
            'live-classes.end',
            'live-classes.cancel',

            'live-class-attendance.view',
            'live-class-attendance.create',
            'live-class-attendance.update',
            'live-class-attendance.delete',

            'live-class-recordings.view',
            'live-class-recordings.create',
            'live-class-recordings.update',
            'live-class-recordings.delete',

            'whiteboard.view',
            'whiteboard.create',
            'whiteboard.update',
            'whiteboard.delete',
            'whiteboard.save',

            /*
            |--------------------------------------------------------------------------
            | 10. Communication
            |--------------------------------------------------------------------------
            */

            'conversations.view',
            'conversations.create',
            'conversations.update',
            'conversations.delete',

            'messages.view',
            'messages.create',
            'messages.update',
            'messages.delete',
            'messages.send',

            'announcements.view',
            'announcements.create',
            'announcements.update',
            'announcements.delete',
            'announcements.publish',

            'comments.view',
            'comments.create',
            'comments.update',
            'comments.delete',
            'comments.moderate',

            'chat.view',
            'chat.send',
            'chat.delete',
            'chat.moderate',

            /*
            |--------------------------------------------------------------------------
            | 11. Notifications
            |--------------------------------------------------------------------------
            */

            'notifications.view',
            'notifications.create',
            'notifications.update',
            'notifications.delete',
            'notifications.send',

            'notifications.mark-read',
            'notifications.mark-all-read',

            'notification-preferences.view',
            'notification-preferences.update',

            'email-notifications.send',
            'sms-notifications.send',
            'push-notifications.send',

            /*
            |--------------------------------------------------------------------------
            | 12. Commerce & Payment
            |--------------------------------------------------------------------------
            */

            'orders.view',
            'orders.create',
            'orders.update',
            'orders.delete',
            'orders.cancel',
            'orders.refund',

            'payments.view',
            'payments.create',
            'payments.update',
            'payments.delete',
            'payments.refund',
            'payments.verify',

            'transactions.view',
            'transactions.create',
            'transactions.update',
            'transactions.delete',

            'invoices.view',
            'invoices.create',
            'invoices.update',
            'invoices.delete',
            'invoices.download',

            'payment-methods.view',
            'payment-methods.create',
            'payment-methods.update',
            'payment-methods.delete',

            'payment-gateways.view',
            'payment-gateways.create',
            'payment-gateways.update',
            'payment-gateways.delete',
            'payment-gateways.enable',
            'payment-gateways.disable',

            /*
            |--------------------------------------------------------------------------
            | 13. Subscriptions
            |--------------------------------------------------------------------------
            */

            'subscriptions.view',
            'subscriptions.create',
            'subscriptions.update',
            'subscriptions.delete',
            'subscriptions.cancel',
            'subscriptions.pause',
            'subscriptions.resume',

            'subscription-plans.view',
            'subscription-plans.create',
            'subscription-plans.update',
            'subscription-plans.delete',
            'subscription-plans.publish',
            'subscription-plans.unpublish',

            'subscription-history.view',

            /*
            |--------------------------------------------------------------------------
            | 14. Coupons & Promotions
            |--------------------------------------------------------------------------
            */

            'coupons.view',
            'coupons.create',
            'coupons.update',
            'coupons.delete',
            'coupons.activate',
            'coupons.deactivate',

            'promotions.view',
            'promotions.create',
            'promotions.update',
            'promotions.delete',
            'promotions.activate',
            'promotions.deactivate',

            'discounts.view',
            'discounts.create',
            'discounts.update',
            'discounts.delete',

            /*
            |--------------------------------------------------------------------------
            | 15. Certificates
            |--------------------------------------------------------------------------
            */

            'certificates.view',
            'certificates.create',
            'certificates.update',
            'certificates.delete',
            'certificates.issue',
            'certificates.revoke',
            'certificates.download',
            'certificates.verify',

            'certificate-templates.view',
            'certificate-templates.create',
            'certificate-templates.update',
            'certificate-templates.delete',

            /*
            |--------------------------------------------------------------------------
            | 16. Reviews
            |--------------------------------------------------------------------------
            */

            'reviews.view',
            'reviews.create',
            'reviews.update',
            'reviews.delete',
            'reviews.approve',
            'reviews.reject',
            'reviews.moderate',

            'ratings.view',
            'ratings.create',
            'ratings.update',
            'ratings.delete',

            /*
            |--------------------------------------------------------------------------
            | 17. Media
            |--------------------------------------------------------------------------
            */

            'media.view',
            'media.upload',
            'media.update',
            'media.delete',
            'media.download',

            'media-folders.view',
            'media-folders.create',
            'media-folders.update',
            'media-folders.delete',

            'videos.view',
            'videos.upload',
            'videos.update',
            'videos.delete',

            'documents.view',
            'documents.upload',
            'documents.update',
            'documents.delete',

            'images.view',
            'images.upload',
            'images.update',
            'images.delete',

            /*
            |--------------------------------------------------------------------------
            | 18. Support
            |--------------------------------------------------------------------------
            */

            'support-tickets.view',
            'support-tickets.create',
            'support-tickets.update',
            'support-tickets.delete',
            'support-tickets.assign',
            'support-tickets.close',
            'support-tickets.reopen',

            'support-messages.view',
            'support-messages.create',
            'support-messages.update',
            'support-messages.delete',

            'faq.view',
            'faq.create',
            'faq.update',
            'faq.delete',
            'faq.publish',

            'support-categories.view',
            'support-categories.create',
            'support-categories.update',
            'support-categories.delete',

            /*
            |--------------------------------------------------------------------------
            | 19. Analytics
            |--------------------------------------------------------------------------
            */

            'analytics.view',
            'analytics.export',

            'dashboard.view',

            'student-analytics.view',
            'teacher-analytics.view',
            'course-analytics.view',
            'enrollment-analytics.view',
            'assessment-analytics.view',
            'assignment-analytics.view',
            'attendance-analytics.view',
            'financial-analytics.view',
            'revenue-analytics.view',
            'subscription-analytics.view',
            'user-analytics.view',

            'reports.view',
            'reports.create',
            'reports.export',
            'reports.download',
        ];

        /*
        |--------------------------------------------------------------------------
        | Create Permissions
        |--------------------------------------------------------------------------
        */

        foreach ($permissions as $permission) {
            Permission::firstOrCreate([
                'name' => $permission,
                'guard_name' => 'sanctum',
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | 02. Roles
        |--------------------------------------------------------------------------
        */

        /*
        |--------------------------------------------------------------------------
        | Super Admin
        |--------------------------------------------------------------------------
        |
        | Super Admin receives every permission.
        |
        */

        $superAdminPermissions = $permissions;

        /*
        |--------------------------------------------------------------------------
        | Admin
        |--------------------------------------------------------------------------
        */

        $adminPermissions = [

            // Identity
            'users.view',
            'users.create',
            'users.update',
            'users.delete',
            'users.restore',
            'users.force-delete',

            'roles.view',
            'roles.create',
            'roles.update',
            'roles.delete',
            'roles.assign',

            'permissions.view',
            'permissions.assign',

            'devices.view',
            'devices.revoke',
            'devices.revoke-all',

            'login-attempts.view',
            'login-attempts.delete',

            'sessions.view',
            'sessions.revoke',
            'sessions.revoke-all',

            'preferences.view',
            'preferences.update',

            'audit-logs.view',
            'audit-logs.delete',

            // Academic
            'academic-years.view',
            'academic-years.create',
            'academic-years.update',
            'academic-years.delete',
            'academic-years.restore',

            'terms.view',
            'terms.create',
            'terms.update',
            'terms.delete',

            'grades.view',
            'grades.create',
            'grades.update',
            'grades.delete',

            'sections.view',
            'sections.create',
            'sections.update',
            'sections.delete',

            'subjects.view',
            'subjects.create',
            'subjects.update',
            'subjects.delete',

            'departments.view',
            'departments.create',
            'departments.update',
            'departments.delete',

            // People
            'students.view',
            'students.create',
            'students.update',
            'students.delete',
            'students.restore',
            'students.suspend',

            'teachers.view',
            'teachers.create',
            'teachers.update',
            'teachers.delete',
            'teachers.restore',
            'teachers.suspend',

            'parents.view',
            'parents.create',
            'parents.update',
            'parents.delete',

            'parent-student.view',
            'parent-student.create',
            'parent-student.update',
            'parent-student.delete',

            'staff.view',
            'staff.create',
            'staff.update',
            'staff.delete',

            'profiles.view',
            'profiles.update',

            // Courses
            'courses.view',
            'courses.create',
            'courses.update',
            'courses.delete',
            'courses.restore',
            'courses.publish',
            'courses.unpublish',
            'courses.approve',
            'courses.reject',
            'courses.archive',

            'course-categories.view',
            'course-categories.create',
            'course-categories.update',
            'course-categories.delete',

            'course-sections.view',
            'course-sections.create',
            'course-sections.update',
            'course-sections.delete',
            'course-sections.reorder',

            'lessons.view',
            'lessons.create',
            'lessons.update',
            'lessons.delete',
            'lessons.restore',
            'lessons.publish',
            'lessons.unpublish',
            'lessons.reorder',

            'lesson-content.view',
            'lesson-content.create',
            'lesson-content.update',
            'lesson-content.delete',

            'lesson-versions.view',
            'lesson-versions.create',
            'lesson-versions.update',
            'lesson-versions.delete',
            'lesson-versions.restore',
            'lesson-versions.compare',

            'content-approvals.view',
            'content-approvals.submit',
            'content-approvals.approve',
            'content-approvals.reject',
            'content-approvals.request-changes',

            'course-teachers.view',
            'course-teachers.assign',
            'course-teachers.remove',

            'course-resources.view',
            'course-resources.create',
            'course-resources.update',
            'course-resources.delete',

            // Enrollment
            'enrollments.view',
            'enrollments.create',
            'enrollments.update',
            'enrollments.delete',
            'enrollments.cancel',
            'enrollments.approve',
            'enrollments.reject',

            'enrollment-history.view',

            'course-access.grant',
            'course-access.revoke',

            'waitlists.view',
            'waitlists.create',
            'waitlists.delete',

            // Progress
            'learning-progress.view',
            'learning-progress.update',
            'learning-progress.reset',

            'lesson-progress.view',
            'lesson-progress.update',
            'lesson-progress.reset',

            'course-progress.view',
            'course-progress.update',
            'course-progress.reset',

            'learning-activity.view',

            'attendance.view',
            'attendance.create',
            'attendance.update',
            'attendance.delete',

            'student-statistics.view',

            // Assessments
            'assessments.view',
            'assessments.create',
            'assessments.update',
            'assessments.delete',
            'assessments.publish',
            'assessments.unpublish',

            'questions.view',
            'questions.create',
            'questions.update',
            'questions.delete',
            'questions.import',
            'questions.export',

            'question-banks.view',
            'question-banks.create',
            'question-banks.update',
            'question-banks.delete',

            'question-options.view',
            'question-options.create',
            'question-options.update',
            'question-options.delete',

            'exam-attempts.view',
            'exam-attempts.reset',

            'exam-results.view',
            'exam-results.publish',
            'exam-results.update',

            'grading.view',
            'grading.create',
            'grading.update',

            // Assignments
            'assignments.view',
            'assignments.create',
            'assignments.update',
            'assignments.delete',
            'assignments.publish',
            'assignments.unpublish',

            'assignment-submissions.view',
            'assignment-submissions.create',
            'assignment-submissions.update',
            'assignment-submissions.delete',
            'assignment-submissions.submit',
            'assignment-submissions.resubmit',

            'assignment-grades.view',
            'assignment-grades.create',
            'assignment-grades.update',
            'assignment-grades.delete',

            'assignment-feedback.view',
            'assignment-feedback.create',
            'assignment-feedback.update',
            'assignment-feedback.delete',

            // Live classes
            'live-classes.view',
            'live-classes.create',
            'live-classes.update',
            'live-classes.delete',
            'live-classes.start',
            'live-classes.end',
            'live-classes.cancel',

            'live-class-attendance.view',
            'live-class-attendance.create',
            'live-class-attendance.update',
            'live-class-attendance.delete',

            'live-class-recordings.view',
            'live-class-recordings.create',
            'live-class-recordings.update',
            'live-class-recordings.delete',

            'whiteboard.view',
            'whiteboard.create',
            'whiteboard.update',
            'whiteboard.delete',
            'whiteboard.save',

            // Communication
            'conversations.view',
            'conversations.create',
            'conversations.update',
            'conversations.delete',

            'messages.view',
            'messages.create',
            'messages.update',
            'messages.delete',
            'messages.send',

            'announcements.view',
            'announcements.create',
            'announcements.update',
            'announcements.delete',
            'announcements.publish',

            'comments.view',
            'comments.create',
            'comments.update',
            'comments.delete',
            'comments.moderate',

            'chat.view',
            'chat.send',
            'chat.delete',
            'chat.moderate',

            // Notifications
            'notifications.view',
            'notifications.create',
            'notifications.update',
            'notifications.delete',
            'notifications.send',

            'notifications.mark-read',
            'notifications.mark-all-read',

            'notification-preferences.view',
            'notification-preferences.update',

            'email-notifications.send',
            'sms-notifications.send',
            'push-notifications.send',

            // Commerce
            'orders.view',
            'orders.create',
            'orders.update',
            'orders.delete',
            'orders.cancel',
            'orders.refund',

            'payments.view',
            'payments.create',
            'payments.update',
            'payments.delete',
            'payments.refund',
            'payments.verify',

            'transactions.view',
            'transactions.create',
            'transactions.update',
            'transactions.delete',

            'invoices.view',
            'invoices.create',
            'invoices.update',
            'invoices.delete',
            'invoices.download',

            'payment-methods.view',
            'payment-methods.create',
            'payment-methods.update',
            'payment-methods.delete',

            'payment-gateways.view',
            'payment-gateways.create',
            'payment-gateways.update',
            'payment-gateways.delete',
            'payment-gateways.enable',
            'payment-gateways.disable',

            // Subscriptions
            'subscriptions.view',
            'subscriptions.create',
            'subscriptions.update',
            'subscriptions.delete',
            'subscriptions.cancel',
            'subscriptions.pause',
            'subscriptions.resume',

            'subscription-plans.view',
            'subscription-plans.create',
            'subscription-plans.update',
            'subscription-plans.delete',
            'subscription-plans.publish',
            'subscription-plans.unpublish',

            'subscription-history.view',

            // Promotions
            'coupons.view',
            'coupons.create',
            'coupons.update',
            'coupons.delete',
            'coupons.activate',
            'coupons.deactivate',

            'promotions.view',
            'promotions.create',
            'promotions.update',
            'promotions.delete',
            'promotions.activate',
            'promotions.deactivate',

            'discounts.view',
            'discounts.create',
            'discounts.update',
            'discounts.delete',

            // Certificates
            'certificates.view',
            'certificates.create',
            'certificates.update',
            'certificates.delete',
            'certificates.issue',
            'certificates.revoke',
            'certificates.download',
            'certificates.verify',

            'certificate-templates.view',
            'certificate-templates.create',
            'certificate-templates.update',
            'certificate-templates.delete',

            // Reviews
            'reviews.view',
            'reviews.create',
            'reviews.update',
            'reviews.delete',
            'reviews.approve',
            'reviews.reject',
            'reviews.moderate',

            'ratings.view',
            'ratings.create',
            'ratings.update',
            'ratings.delete',

            // Media
            'media.view',
            'media.upload',
            'media.update',
            'media.delete',
            'media.download',

            'media-folders.view',
            'media-folders.create',
            'media-folders.update',
            'media-folders.delete',

            'videos.view',
            'videos.upload',
            'videos.update',
            'videos.delete',

            'documents.view',
            'documents.upload',
            'documents.update',
            'documents.delete',

            'images.view',
            'images.upload',
            'images.update',
            'images.delete',

            // Support
            'support-tickets.view',
            'support-tickets.create',
            'support-tickets.update',
            'support-tickets.delete',
            'support-tickets.assign',
            'support-tickets.close',
            'support-tickets.reopen',

            'support-messages.view',
            'support-messages.create',
            'support-messages.update',
            'support-messages.delete',

            'faq.view',
            'faq.create',
            'faq.update',
            'faq.delete',
            'faq.publish',

            'support-categories.view',
            'support-categories.create',
            'support-categories.update',
            'support-categories.delete',

            // Analytics
            'analytics.view',
            'analytics.export',
            'dashboard.view',

            'student-analytics.view',
            'teacher-analytics.view',
            'course-analytics.view',
            'enrollment-analytics.view',
            'assessment-analytics.view',
            'assignment-analytics.view',
            'attendance-analytics.view',
            'financial-analytics.view',
            'revenue-analytics.view',
            'subscription-analytics.view',
            'user-analytics.view',

            'reports.view',
            'reports.create',
            'reports.export',
            'reports.download',
        ];

        /*
        |--------------------------------------------------------------------------
        | 03. Academic Manager
        |--------------------------------------------------------------------------
        */

        $academicManagerPermissions = [

            // Academic Structure
            'academic-years.view',
            'academic-years.create',
            'academic-years.update',
            'academic-years.delete',
            'academic-years.restore',

            'terms.view',
            'terms.create',
            'terms.update',
            'terms.delete',

            'grades.view',
            'grades.create',
            'grades.update',
            'grades.delete',

            'sections.view',
            'sections.create',
            'sections.update',
            'sections.delete',

            'subjects.view',
            'subjects.create',
            'subjects.update',
            'subjects.delete',

            'departments.view',
            'departments.create',
            'departments.update',
            'departments.delete',

            // People
            'students.view',
            'students.create',
            'students.update',
            'students.delete',
            'students.restore',
            'students.suspend',

            'teachers.view',
            'teachers.create',
            'teachers.update',
            'teachers.delete',
            'teachers.restore',
            'teachers.suspend',

            'parents.view',
            'parents.create',
            'parents.update',
            'parents.delete',

            'parent-student.view',
            'parent-student.create',
            'parent-student.update',
            'parent-student.delete',

            'staff.view',

            'profiles.view',
            'profiles.update',

            // Enrollment
            'enrollments.view',
            'enrollments.create',
            'enrollments.update',
            'enrollments.delete',
            'enrollments.cancel',
            'enrollments.approve',
            'enrollments.reject',

            'enrollment-history.view',

            'course-access.grant',
            'course-access.revoke',

            'waitlists.view',
            'waitlists.create',
            'waitlists.delete',

            // Progress
            'learning-progress.view',
            'lesson-progress.view',
            'course-progress.view',
            'learning-activity.view',

            // Attendance
            'attendance.view',
            'attendance.create',
            'attendance.update',
            'attendance.delete',

            'student-statistics.view',

            // Analytics
            'student-analytics.view',
            'teacher-analytics.view',
            'enrollment-analytics.view',

            'dashboard.view',
        ];

        /*
        |--------------------------------------------------------------------------
        | 04. Content Manager
        |--------------------------------------------------------------------------
        */

        $contentManagerPermissions = [

            'courses.view',
            'courses.create',
            'courses.update',
            'courses.delete',
            'courses.restore',
            'courses.publish',
            'courses.unpublish',
            'courses.approve',
            'courses.reject',
            'courses.archive',

            'course-categories.view',
            'course-categories.create',
            'course-categories.update',
            'course-categories.delete',

            'course-sections.view',
            'course-sections.create',
            'course-sections.update',
            'course-sections.delete',
            'course-sections.reorder',

            'lessons.view',
            'lessons.create',
            'lessons.update',
            'lessons.delete',
            'lessons.restore',
            'lessons.publish',
            'lessons.unpublish',
            'lessons.reorder',

            'lesson-content.view',
            'lesson-content.create',
            'lesson-content.update',
            'lesson-content.delete',

            'lesson-versions.view',
            'lesson-versions.create',
            'lesson-versions.update',
            'lesson-versions.delete',
            'lesson-versions.restore',
            'lesson-versions.compare',

            'content-approvals.view',
            'content-approvals.submit',
            'content-approvals.approve',
            'content-approvals.reject',
            'content-approvals.request-changes',

            'course-teachers.view',
            'course-teachers.assign',
            'course-teachers.remove',

            'course-resources.view',
            'course-resources.create',
            'course-resources.update',
            'course-resources.delete',

            // Media
            'media.view',
            'media.upload',
            'media.update',
            'media.delete',
            'media.download',

            'media-folders.view',
            'media-folders.create',
            'media-folders.update',
            'media-folders.delete',

            'videos.view',
            'videos.upload',
            'videos.update',
            'videos.delete',

            'documents.view',
            'documents.upload',
            'documents.update',
            'documents.delete',

            'images.view',
            'images.upload',
            'images.update',
            'images.delete',

            'dashboard.view',
            'course-analytics.view',
        ];

        /*
        |--------------------------------------------------------------------------
        | 05. Teacher
        |--------------------------------------------------------------------------
        */

        $teacherPermissions = [

            // Courses
            'courses.view',
            'courses.create',
            'courses.update',

            'course-sections.view',
            'course-sections.create',
            'course-sections.update',
            'course-sections.delete',
            'course-sections.reorder',

            'lessons.view',
            'lessons.create',
            'lessons.update',
            'lessons.delete',
            'lessons.reorder',

            'lesson-content.view',
            'lesson-content.create',
            'lesson-content.update',
            'lesson-content.delete',

            'lesson-versions.view',
            'lesson-versions.create',
            'lesson-versions.update',
            'lesson-versions.compare',

            'content-approvals.view',
            'content-approvals.submit',

            'course-teachers.view',

            'course-resources.view',
            'course-resources.create',
            'course-resources.update',
            'course-resources.delete',

            // Students
            'students.view',

            // Enrollment
            'enrollments.view',

            // Progress
            'learning-progress.view',
            'lesson-progress.view',
            'lesson-progress.update',
            'course-progress.view',

            'attendance.view',
            'attendance.create',
            'attendance.update',

            'student-statistics.view',

            // Assessments
            'assessments.view',
            'assessments.create',
            'assessments.update',
            'assessments.delete',
            'assessments.publish',
            'assessments.unpublish',

            'questions.view',
            'questions.create',
            'questions.update',
            'questions.delete',
            'questions.import',
            'questions.export',

            'question-banks.view',
            'question-banks.create',
            'question-banks.update',
            'question-banks.delete',

            'question-options.view',
            'question-options.create',
            'question-options.update',
            'question-options.delete',

            'exam-attempts.view',

            'exam-results.view',
            'exam-results.publish',
            'exam-results.update',

            'grades.view',
            'grades.create',
            'grades.update',

            'grading.view',
            'grading.create',
            'grading.update',

            // Assignments
            'assignments.view',
            'assignments.create',
            'assignments.update',
            'assignments.delete',
            'assignments.publish',
            'assignments.unpublish',

            'assignment-submissions.view',

            'assignment-grades.view',
            'assignment-grades.create',
            'assignment-grades.update',

            'assignment-feedback.view',
            'assignment-feedback.create',
            'assignment-feedback.update',

            // Live Classes
            'live-classes.view',
            'live-classes.create',
            'live-classes.update',
            'live-classes.delete',
            'live-classes.start',
            'live-classes.end',
            'live-classes.cancel',

            'live-class-attendance.view',
            'live-class-attendance.create',
            'live-class-attendance.update',

            'live-class-recordings.view',
            'live-class-recordings.create',
            'live-class-recordings.update',

            'whiteboard.view',
            'whiteboard.create',
            'whiteboard.update',
            'whiteboard.delete',
            'whiteboard.save',

            // Communication
            'conversations.view',
            'conversations.create',

            'messages.view',
            'messages.create',
            'messages.send',

            'announcements.view',

            'comments.view',
            'comments.create',
            'comments.update',

            'chat.view',
            'chat.send',

            // Reviews
            'reviews.view',

            // Analytics
            'teacher-analytics.view',
            'course-analytics.view',
            'assessment-analytics.view',
            'assignment-analytics.view',
            'attendance-analytics.view',

            'dashboard.view',
        ];

        /*
        |--------------------------------------------------------------------------
        | 06. Student
        |--------------------------------------------------------------------------
        */

        $studentPermissions = [

            // Profile
            'profiles.view',
            'profiles.update',
            'preferences.view',
            'preferences.update',

            // Courses
            'courses.view',
            'course-categories.view',
            'course-sections.view',
            'lessons.view',
            'lesson-content.view',
            'lesson-versions.view',
            'course-resources.view',

            // Enrollment
            'enrollments.view',
            'enrollments.create',
            'enrollments.cancel',

            'enrollment-history.view',

            'waitlists.view',
            'waitlists.create',
            'waitlists.delete',

            // Learning
            'learning-progress.view',
            'learning-progress.update',

            'lesson-progress.view',
            'lesson-progress.update',

            'course-progress.view',
            'course-progress.update',

            'learning-activity.view',

            // Assessments
            'assessments.view',
            'questions.view',

            'exam-attempts.view',
            'exam-attempts.start',
            'exam-attempts.submit',
            'exam-attempts.cancel',

            'exam-results.view',

            'grades.view',
            'grading.view',

            // Assignments
            'assignments.view',

            'assignment-submissions.view',
            'assignment-submissions.create',
            'assignment-submissions.update',
            'assignment-submissions.submit',
            'assignment-submissions.resubmit',

            'assignment-grades.view',
            'assignment-feedback.view',

            // Live Classes
            'live-classes.view',
            'live-class-attendance.view',
            'live-class-recordings.view',
            'whiteboard.view',

            // Communication
            'conversations.view',
            'conversations.create',

            'messages.view',
            'messages.create',
            'messages.send',

            'announcements.view',

            'comments.view',
            'comments.create',
            'comments.update',
            'comments.delete',

            'chat.view',
            'chat.send',

            // Notifications
            'notifications.view',
            'notifications.mark-read',
            'notifications.mark-all-read',

            'notification-preferences.view',
            'notification-preferences.update',

            // Commerce
            'orders.view',
            'orders.create',
            'orders.cancel',

            'payments.view',
            'payments.create',

            'transactions.view',

            'invoices.view',
            'invoices.download',

            'payment-methods.view',
            'payment-methods.create',
            'payment-methods.update',
            'payment-methods.delete',

            // Subscriptions
            'subscriptions.view',
            'subscriptions.create',
            'subscriptions.cancel',
            'subscriptions.pause',
            'subscriptions.resume',

            'subscription-plans.view',
            'subscription-history.view',

            // Coupons
            'coupons.view',
            'discounts.view',

            // Certificates
            'certificates.view',
            'certificates.download',
            'certificates.verify',

            // Reviews
            'reviews.view',
            'reviews.create',
            'reviews.update',
            'reviews.delete',

            'ratings.view',
            'ratings.create',
            'ratings.update',
            'ratings.delete',

            // Media
            'media.view',
            'media.download',
            'videos.view',
            'documents.view',
            'images.view',

            // Support
            'support-tickets.view',
            'support-tickets.create',
            'support-tickets.update',

            'support-messages.view',
            'support-messages.create',

            'faq.view',
            'support-categories.view',

            // Analytics
            'dashboard.view',
            'student-analytics.view',
        ];

        /*
        |--------------------------------------------------------------------------
        | 07. Parent
        |--------------------------------------------------------------------------
        */

        $parentPermissions = [

            'profiles.view',
            'profiles.update',
            'preferences.view',
            'preferences.update',

            // Children
            'students.view',
            'parent-student.view',

            // Courses
            'courses.view',
            'course-categories.view',
            'course-sections.view',
            'lessons.view',
            'lesson-content.view',

            // Enrollment
            'enrollments.view',
            'enrollment-history.view',

            // Progress
            'learning-progress.view',
            'lesson-progress.view',
            'course-progress.view',
            'learning-activity.view',

            'attendance.view',
            'student-statistics.view',

            // Assessments
            'assessments.view',
            'exam-attempts.view',
            'exam-results.view',

            'grades.view',
            'grading.view',

            // Assignments
            'assignments.view',
            'assignment-submissions.view',
            'assignment-grades.view',
            'assignment-feedback.view',

            // Live Classes
            'live-classes.view',
            'live-class-attendance.view',
            'live-class-recordings.view',

            // Communication
            'conversations.view',
            'messages.view',
            'announcements.view',
            'comments.view',
            'chat.view',

            // Notifications
            'notifications.view',
            'notifications.mark-read',
            'notifications.mark-all-read',

            'notification-preferences.view',
            'notification-preferences.update',

            // Certificates
            'certificates.view',
            'certificates.download',
            'certificates.verify',

            // Commerce
            'orders.view',
            'payments.view',
            'transactions.view',

            'invoices.view',
            'invoices.download',

            // Subscriptions
            'subscriptions.view',
            'subscription-plans.view',
            'subscription-history.view',

            // Support
            'support-tickets.view',
            'support-tickets.create',
            'support-tickets.update',

            'support-messages.view',
            'support-messages.create',

            'faq.view',

            // Analytics
            'dashboard.view',
            'student-analytics.view',
        ];

        /*
        |--------------------------------------------------------------------------
        | 08. Finance Manager
        |--------------------------------------------------------------------------
        */

        $financeManagerPermissions = [

            // Orders
            'orders.view',
            'orders.create',
            'orders.update',
            'orders.delete',
            'orders.cancel',
            'orders.refund',

            // Payments
            'payments.view',
            'payments.create',
            'payments.update',
            'payments.delete',
            'payments.refund',
            'payments.verify',

            // Transactions
            'transactions.view',
            'transactions.create',
            'transactions.update',
            'transactions.delete',

            // Invoices
            'invoices.view',
            'invoices.create',
            'invoices.update',
            'invoices.delete',
            'invoices.download',

            // Payment Methods
            'payment-methods.view',
            'payment-methods.create',
            'payment-methods.update',
            'payment-methods.delete',

            // Gateways
            'payment-gateways.view',
            'payment-gateways.create',
            'payment-gateways.update',
            'payment-gateways.delete',
            'payment-gateways.enable',
            'payment-gateways.disable',

            // Subscriptions
            'subscriptions.view',
            'subscriptions.create',
            'subscriptions.update',
            'subscriptions.delete',
            'subscriptions.cancel',
            'subscriptions.pause',
            'subscriptions.resume',

            'subscription-plans.view',
            'subscription-plans.create',
            'subscription-plans.update',
            'subscription-plans.delete',
            'subscription-plans.publish',
            'subscription-plans.unpublish',

            'subscription-history.view',

            // Coupons
            'coupons.view',
            'coupons.create',
            'coupons.update',
            'coupons.delete',
            'coupons.activate',
            'coupons.deactivate',

            // Promotions
            'promotions.view',
            'promotions.create',
            'promotions.update',
            'promotions.delete',
            'promotions.activate',
            'promotions.deactivate',

            // Discounts
            'discounts.view',
            'discounts.create',
            'discounts.update',
            'discounts.delete',

            // Analytics
            'financial-analytics.view',
            'revenue-analytics.view',
            'subscription-analytics.view',

            'reports.view',
            'reports.create',
            'reports.export',
            'reports.download',

            'dashboard.view',
        ];

        /*
        |--------------------------------------------------------------------------
        | 09. Support Agent
        |--------------------------------------------------------------------------
        */

        $supportAgentPermissions = [

            'support-tickets.view',
            'support-tickets.create',
            'support-tickets.update',
            'support-tickets.assign',
            'support-tickets.close',
            'support-tickets.reopen',

            'support-messages.view',
            'support-messages.create',
            'support-messages.update',

            'faq.view',

            'support-categories.view',

            'users.view',

            'students.view',
            'teachers.view',
            'parents.view',

            'profiles.view',

            'conversations.view',
            'conversations.create',

            'messages.view',
            'messages.create',
            'messages.send',

            'chat.view',
            'chat.send',
            'chat.moderate',

            'notifications.view',
            'notifications.send',

            'email-notifications.send',
            'sms-notifications.send',

            'dashboard.view',
        ];

        /*
        |--------------------------------------------------------------------------
        | 10. Moderator
        |--------------------------------------------------------------------------
        */

        $moderatorPermissions = [

            // Courses
            'courses.view',
            'courses.approve',
            'courses.reject',
            'courses.publish',
            'courses.unpublish',

            'lessons.view',
            'lessons.publish',
            'lessons.unpublish',

            // Content Approval
            'content-approvals.view',
            'content-approvals.approve',
            'content-approvals.reject',
            'content-approvals.request-changes',

            // Reviews
            'reviews.view',
            'reviews.approve',
            'reviews.reject',
            'reviews.moderate',

            'ratings.view',

            // Comments
            'comments.view',
            'comments.delete',
            'comments.moderate',

            // Chat
            'chat.view',
            'chat.delete',
            'chat.moderate',

            // Announcements
            'announcements.view',
            'announcements.publish',

            // Support
            'support-tickets.view',
            'support-messages.view',
            'faq.view',

            // Reports
            'reports.view',

            'dashboard.view',
        ];

        /*
        |--------------------------------------------------------------------------
        | 11. Analyst
        |--------------------------------------------------------------------------
        */

        $analystPermissions = [

            'dashboard.view',

            'analytics.view',
            'analytics.export',

            'student-analytics.view',
            'teacher-analytics.view',
            'course-analytics.view',
            'enrollment-analytics.view',
            'assessment-analytics.view',
            'assignment-analytics.view',
            'attendance-analytics.view',
            'financial-analytics.view',
            'revenue-analytics.view',
            'subscription-analytics.view',
            'user-analytics.view',

            'reports.view',
            'reports.create',
            'reports.export',
            'reports.download',

            // Read-only data
            'users.view',
            'students.view',
            'teachers.view',
            'parents.view',

            'courses.view',
            'enrollments.view',

            'assessments.view',
            'exam-results.view',

            'assignments.view',
            'assignment-submissions.view',
            'assignment-grades.view',

            'attendance.view',

            'orders.view',
            'payments.view',
            'transactions.view',
            'invoices.view',

            'subscriptions.view',
            'subscription-history.view',
        ];

        /*
        |--------------------------------------------------------------------------
        | 12. Create / Sync Roles
        |--------------------------------------------------------------------------
        */

        $roles = [
            'super-admin'      => $superAdminPermissions,
            'admin'            => $adminPermissions,
            'academic-manager' => $academicManagerPermissions,
            'content-manager'  => $contentManagerPermissions,
            'teacher'          => $teacherPermissions,
            'student'          => $studentPermissions,
            'parent'           => $parentPermissions,
            'finance-manager'  => $financeManagerPermissions,
            'support-agent'    => $supportAgentPermissions,
            'moderator'        => $moderatorPermissions,
            'analyst'          => $analystPermissions,
        ];

        foreach ($roles as $roleName => $rolePermissions) {

            $role = Role::firstOrCreate([
                'name' => $roleName,
                'guard_name' => 'sanctum',
            ]);

            $role->syncPermissions($rolePermissions);
        }
    }
}
