<?php

namespace App\Notifications;

use App\Models\CourseEnrollment;
use App\Models\User;
use App\Services\NotificationService;

class NotificationActions
{


  public function __construct(
    protected NotificationService $service
  ) {}


  // =============================================
  // COURSE CREATED (overview_form - status published)
  // Called: store() → overview_form → status == published
  // Target: All enrolled students + assigned teachers
  // =============================================
  public function courseCreated($course): void
  {
    // --- Notify Assigned Teachers ---
    $teacherUserIds = $course->teachers()
      ->with('user')
      ->get()
      ->pluck('user.id')
      ->filter()
      ->toArray();

    if (!empty($teacherUserIds)) {
      $this->service->send([
        'title'           => '📚 New Course Assigned',
        'body'            => "You have been assigned to teach: {$course->title}",
        'type'            => 'both',
        'category'        => 'course',
        'action_type'     => 'created',
        'notifiable_type' => 'Course',
        'notifiable_id'   => $course->id,
        'target_type'     => 'specific',
        'user_ids'        => $teacherUserIds,
        'screen'          => 'course_detail',
        'screen_id'       => $course->course_identity,
      ]);
    }

    // --- Notify All Students (company users with student role) ---
    $studentIds = User::where('company_id', $course->company_id)
      ->where('role', 'student')
      ->pluck('id')
      ->toArray();

    if (!empty($studentIds)) {
      $this->service->send([
        'title'           => '🎉 New Course Available!',
        'body'            => "{$course->title} is now available. Enroll now!",
        'type'            => 'both',
        'category'        => 'course',
        'action_type'     => 'created',
        'notifiable_type' => 'Course',
        'notifiable_id'   => $course->id,
        'target_type'     => 'specific',
        'user_ids'        => $studentIds,
        'screen'          => 'course_detail',
        'screen_id'       => $course->course_identity,
        'extra_data'      => [
          'started_at' => $course->started_at,
          'ended_at'   => $course->ended_at,
          'net_price'  => $course->net_price,
        ],
      ]);
    }

    // --- Notify Admin ---
    $this->service->sendToAdmins([
      'title'           => '✅ Course Published',
      'body'            => "Course \"{$course->title}\" has been published successfully.",
      'type'            => 'in_app',
      'category'        => 'course',
      'action_type'     => 'created',
      'notifiable_type' => 'Course',
      'notifiable_id'   => $course->id,
      'screen'          => 'course_detail',
      'screen_id'       => $course->course_identity,
    ]);
  }

  // =============================================
  // COURSE UPDATED
  // Called: store() → basic_form / pricing_form / advanced_form (isUpdate = true)
  // Target: Enrolled students + assigned teachers
  // =============================================
  public function courseUpdated($course): void
  {
    // Get enrolled student IDs
    $enrolledStudentIds = CourseEnrollment::where('course_id', $course->id)
      ->where('status', 'active')
      ->pluck('user_id')
      ->toArray();

    // Get assigned teacher user IDs
    $teacherUserIds = $course->teachers()
      ->with('user')
      ->get()
      ->pluck('user.id')
      ->filter()
      ->toArray();

    // --- Notify Enrolled Students ---
    if (!empty($enrolledStudentIds)) {
      $this->service->send([
        'title'           => '📝 Course Updated',
        'body'            => "{$course->title} has been updated. Check what\'s new!",
        'type'            => 'both',
        'category'        => 'course',
        'action_type'     => 'updated',
        'notifiable_type' => 'Course',
        'notifiable_id'   => $course->id,
        'target_type'     => 'specific',
        'user_ids'        => $enrolledStudentIds,
        'screen'          => 'course_detail',
        'screen_id'       => $course->course_identity,
      ]);
    }

    // --- Notify Assigned Teachers ---
    if (!empty($teacherUserIds)) {
      $this->service->send([
        'title'           => '📝 Course Updated',
        'body'            => "Course \"{$course->title}\" details have been updated.",
        'type'            => 'both',
        'category'        => 'course',
        'action_type'     => 'updated',
        'notifiable_type' => 'Course',
        'notifiable_id'   => $course->id,
        'target_type'     => 'specific',
        'user_ids'        => $teacherUserIds,
        'screen'          => 'course_detail',
        'screen_id'       => $course->course_identity,
      ]);
    }
  }

  // =============================================
  // TEACHER ADDED (addon teacher)
  // Called: addonTeacherUpdate() → foreach teachers
  // Target: The specific teacher added + enrolled students
  // =============================================
  public function courseTeacherAdded($course, $teacherId): void
  {
    // $teacherId here is Teacher model ID (not user_id)
    // Resolve teacher's user_id
    $teacher = User::where('id', $teacherId)->first();

    if (!$teacher || !$teacher->user) return;

    // --- Notify the Teacher ---
    $this->service->sendToUser($teacher->user->id, [
      'title'           => '👨‍🏫 You\'ve Been Added to a Course',
      'body'            => "You have been added as a teacher for: {$course->title}",
      'type'            => 'both',
      'category'        => 'course',
      'action_type'     => 'teacher_added',
      'notifiable_type' => 'Course',
      'notifiable_id'   => $course->id,
      'screen'          => 'course_detail',
      'screen_id'       => $course->course_identity,
      'extra_data'      => [
        'started_at' => $course->started_at,
        'ended_at'   => $course->ended_at,
      ],
    ]);

    // --- Notify Enrolled Students ---
    $enrolledStudentIds = CourseEnrollment::where('course_id', $course->id)
      ->where('status', 'active')
      ->pluck('user_id')
      ->toArray();

    if (!empty($enrolledStudentIds)) {
      $this->service->send([
        'title'           => '👨‍🏫 New Teacher Added',
        'body'            => "{$teacher->user->name} has been added to {$course->title}",
        'type'            => 'both',
        'category'        => 'course',
        'action_type'     => 'teacher_added',
        'notifiable_type' => 'Course',
        'notifiable_id'   => $course->id,
        'target_type'     => 'specific',
        'user_ids'        => $enrolledStudentIds,
        'screen'          => 'course_detail',
        'screen_id'       => $course->course_identity,
      ]);
    }

    // --- Notify Admin (in-app only) ---
    $this->service->sendToAdmins([
      'title'           => '👨‍🏫 Teacher Added to Course',
      'body'            => "{$teacher->user->name} added to \"{$course->title}\"",
      'type'            => 'in_app',
      'category'        => 'course',
      'action_type'     => 'teacher_added',
      'notifiable_type' => 'Course',
      'notifiable_id'   => $course->id,
      'screen'          => 'course_detail',
      'screen_id'       => $course->course_identity,
    ]);
  }

  // =============================================
  // CLASS STARTED
  // Called: When teacher/admin starts a class session
  // Target: All active enrolled students
  // =============================================
  public function courseClassStarted($class): void
  {
    $enrolledStudentIds = CourseEnrollment::where('course_id', $class->course_id)
      ->where('status', 'active')
      ->pluck('user_id')
      ->toArray();

    if (empty($enrolledStudentIds)) return;

    $this->service->send([
      'title'           => '🚀 Class is LIVE!',
      'body'            => "{$class->course->title} class is starting now! Join now.",
      'type'            => 'both',
      'category'        => 'course',
      'action_type'     => 'class_started',
      'notifiable_type' => 'CourseClass',
      'notifiable_id'   => $class->id,
      'target_type'     => 'specific',
      'user_ids'        => $enrolledStudentIds,
      'screen'          => 'class_join',
      'screen_id'       => $class->id,
      'extra_data'      => [
        'join_url'        => $class->join_url ?? null,
        'course_identity' => $class->course->course_identity,
        'start_time'      => now()->toISOString(),
        'set_reminder'    => false,
      ],
    ]);
  }

  // =============================================
  // ENROLLMENT / ADMISSION CREATED
  // Called: When student enrolls in a course
  // Target: The student + admin + assigned teachers
  // =============================================

  public function courseEnrollmentCreated($enrollment): void
  {
    $course  = $enrollment->course;
    $student = $enrollment->user;

    // --- Notify Student ---
    $this->service->sendToUser($student->id, [
      'title'           => '🎓 Enrollment Confirmed!',
      'body'            => "You have successfully enrolled in {$course->title}",
      'type'            => 'both',
      'category'        => 'course',
      'action_type'     => 'enrollment_created',
      'notifiable_type' => 'CourseEnrollment',
      'notifiable_id'   => $enrollment->id,
      'screen'          => 'course_detail',
      'screen_id'       => $course->course_identity,
      'extra_data'      => [
        'started_at'  => $course->started_at,
        'ended_at'    => $course->ended_at,
        'expiry_date' => $enrollment->expiry_date,
      ],
    ]);

    // --- Notify Admin ---
    $this->service->sendToAdmins([
      'title'           => '🎓 New Enrollment',
      'body'            => "{$student->name} enrolled in \"{$course->title}\"",
      'type'            => 'in_app',
      'category'        => 'admission',
      'action_type'     => 'enrollment_created',
      'notifiable_type' => 'CourseEnrollment',
      'notifiable_id'   => $enrollment->id,
      'screen'          => 'course_enrollments',
      'screen_id'       => $course->course_identity,
    ]);

    // --- Notify Assigned Teachers ---
    $teacherUserIds = $course->teachers()
      ->with('user')
      ->get()
      ->pluck('user.id')
      ->filter()
      ->toArray();

    if (!empty($teacherUserIds)) {
      $this->service->send([
        'title'           => '👤 New Student Enrolled',
        'body'            => "{$student->name} joined your course: {$course->title}",
        'type'            => 'in_app',
        'category'        => 'course',
        'action_type'     => 'enrollment_created',
        'notifiable_type' => 'CourseEnrollment',
        'notifiable_id'   => $enrollment->id,
        'target_type'     => 'specific',
        'user_ids'        => $teacherUserIds,
        'screen'          => 'course_enrollments',
        'screen_id'       => $course->course_identity,
      ]);
    }
  }

  // =============================================
  // ENROLLMENT SUSPENDED
  // Called: suspendAdmission()
  // Target: The student whose enrollment was suspended
  // =============================================
  public function courseEnrollmentSuspended($enrollment): void
  {
    $course  = $enrollment->course;
    $student = $enrollment->user;

    // --- Notify Student ---
    $this->service->sendToUser($student->id, [
      'title'           => '⚠️ Enrollment Suspended',
      'body'            => "Your enrollment in \"{$course->title}\" has been suspended. Contact admin.",
      'type'            => 'both',
      'category'        => 'course',
      'action_type'     => 'enrollment_suspended',
      'notifiable_type' => 'CourseEnrollment',
      'notifiable_id'   => $enrollment->id,
      'screen'          => 'course_detail',
      'screen_id'       => $course->course_identity,
      'extra_data'      => [
        'suspend_reason' => $enrollment->suspend_reason,
      ],
    ]);

    // --- Notify Admin (in-app) ---
    $this->service->sendToAdmins([
      'title'           => '⚠️ Enrollment Suspended',
      'body'            => "{$student->name} enrollment in \"{$course->title}\" suspended.",
      'type'            => 'in_app',
      'category'        => 'course',
      'action_type'     => 'enrollment_suspended',
      'notifiable_type' => 'CourseEnrollment',
      'notifiable_id'   => $enrollment->id,
      'screen'          => 'course_enrollments',
      'screen_id'       => $course->course_identity,
    ]);
  }

  // =============================================
  // ENROLLMENT REMOVED
  // Called: removeAdmission()
  // Target: The student who was removed
  // =============================================
  public function courseEnrollmentRemoved($enrollment): void
  {
    $course  = $enrollment->course;
    $student = $enrollment->user;

    // --- Notify Student ---
    $this->service->sendToUser($student->id, [
      'title'           => '❌ Enrollment Removed',
      'body'            => "Your enrollment in \"{$course->title}\" has been removed.",
      'type'            => 'both',
      'category'        => 'course',
      'action_type'     => 'enrollment_removed',
      'notifiable_type' => 'CourseEnrollment',
      'notifiable_id'   => $enrollment->id,
      'screen'          => 'course_detail',
      'screen_id'       => $course->course_identity,
    ]);

    // --- Notify Admin (in-app) ---
    $this->service->sendToAdmins([
      'title'           => '❌ Enrollment Removed',
      'body'            => "{$student->name} removed from \"{$course->title}\"",
      'type'            => 'in_app',
      'category'        => 'course',
      'action_type'     => 'enrollment_removed',
      'notifiable_type' => 'CourseEnrollment',
      'notifiable_id'   => $enrollment->id,
      'screen'          => 'course_enrollments',
      'screen_id'       => $course->course_identity,
    ]);
  }

  // =============================================
  // ADMISSION
  // =============================================
  public function admissionCreated($admission): void
  {
    // Notify admin + staff
    $this->service->sendToAdmins([
      'title'           => '🎓 New Admission Request',
      'body'            => "{$admission->student->name} submitted an admission request",
      'category'        => 'admission',
      'action_type'     => 'created',
      'notifiable_type' => 'Admission',
      'notifiable_id'   => $admission->id,
      'screen'          => 'admission_detail',
      'screen_id'       => $admission->id,
    ]);
  }

  public function admissionApproved($admission): void
  {
    // Notify student
    $this->service->sendToUser($admission->student_id, [
      'title'           => '✅ Admission Approved!',
      'body'            => 'Congratulations! Your admission has been approved.',
      'category'        => 'admission',
      'action_type'     => 'approved',
      'notifiable_type' => 'Admission',
      'notifiable_id'   => $admission->id,
      'screen'          => 'admission_detail',
      'screen_id'       => $admission->id,
    ]);
  }

  public function admissionRejected($admission): void
  {
    $this->service->sendToUser($admission->student_id, [
      'title'           => '❌ Admission Update',
      'body'            => 'Your admission request has been reviewed. Please contact us for more info.',
      'category'        => 'admission',
      'action_type'     => 'rejected',
      'notifiable_type' => 'Admission',
      'notifiable_id'   => $admission->id,
      'screen'          => 'admission_detail',
      'screen_id'       => $admission->id,
    ]);
  }

  // =============================================
  // COURSE
  // =============================================
  // public function courseCreated($course): void
  // {
  //     $this->service->sendToAll([
  //         'title'           => '📚 Course Available',
  //         'body'            => "Course: {$course->title} is now available!",
  //         'category'        => 'course',
  //         'action_type'     => 'created',
  //         'notifiable_type' => 'Course',
  //         'notifiable_id'   => $course->id,
  //         'screen'          => 'course_detail',
  //         'screen_id'       => $course->id,
  //     ]);
  // }


  // public function courseTeacherAdded($course, $teacher): void
  // {
  //     // Notify teacher
  //     $this->service->sendToUser($teacher, [
  //         'title'           => '👨‍🏫 You\'ve Been Assigned',
  //         'body'            => "You have been assigned to teach: {$course->title}",
  //         'category'        => 'course',
  //         'action_type'     => 'teacher_added',
  //         'notifiable_type' => 'Course',
  //         'notifiable_id'   => $course->id,
  //         'screen'          => 'course_detail',
  //         'screen_id'       => $course->id,
  //     ]);

  //     // Notify enrolled students
  //     $enrolledIds = $course->enrolledStudents->pluck('id')->toArray();
  //     if (!empty($enrolledIds)) {
  //         $this->service->send([
  //             'title'           => '👨‍🏫 New Teacher Added',
  //             'body'            => "{$teacher->name} is now teaching {$course->title}",
  //             'category'        => 'course',
  //             'action_type'     => 'teacher_added',
  //             'notifiable_type' => 'Course',
  //             'notifiable_id'   => $course->id,
  //             'target_type'     => 'specific',
  //             'user_ids'        => $enrolledIds,
  //             'screen'          => 'course_detail',
  //             'screen_id'       => $course->id,
  //         ]);
  //     }
  // }

  // public function courseClassStarted($class): void
  // {
  //     $enrolledIds = $class->course->enrolledStudents->pluck('id')->toArray();
  //     if (empty($enrolledIds)) return;

  //     $this->service->send([
  //         'title'           => '🚀 Class is LIVE!',
  //         'body'            => "{$class->course->title} class is starting now! Join now.",
  //         'category'        => 'course',
  //         'action_type'     => 'class_started',
  //         'notifiable_type' => 'CourseClass',
  //         'notifiable_id'   => $class->id,
  //         'target_type'     => 'specific',
  //         'user_ids'        => $enrolledIds,
  //         'screen'          => 'class_join',
  //         'screen_id'       => $class->id,
  //         'extra_data'      => [
  //             'join_url'   => $class->join_url,
  //             'start_time' => now()->toISOString(),
  //         ],
  //     ]);
  // }

  // =============================================
  // WEBINAR
  // =============================================
  public function webinarCreated($webinar): void
  {
    $this->service->sendToAll([
      'title'           => '🎥 New Webinar Scheduled',
      'body'            => "{$webinar->title} - {$webinar->start_time->format('M d, h:i A')}",
      'category'        => 'webinar',
      'action_type'     => 'created',
      'notifiable_type' => 'Webinar',
      'notifiable_id'   => $webinar->id,
      'screen'          => 'webinar_detail',
      'screen_id'       => $webinar->id,
      'extra_data'      => [
        'start_time'   => $webinar->start_time->toISOString(),
        'set_reminder' => true,
      ],
    ]);
  }

  public function webinarUpdated($webinar): void
  {
    $registeredIds = $webinar->registeredUsers->pluck('id')->toArray();
    if (empty($registeredIds)) return;

    $this->service->send([
      'title'           => '📝 Webinar Updated',
      'body'            => "{$webinar->title} details have been updated.",
      'category'        => 'webinar',
      'action_type'     => 'updated',
      'notifiable_type' => 'Webinar',
      'notifiable_id'   => $webinar->id,
      'target_type'     => 'specific',
      'user_ids'        => $registeredIds,
      'screen'          => 'webinar_detail',
      'screen_id'       => $webinar->id,
    ]);
  }

  public function webinarClassStarted($webinar): void
  {
    $registeredIds = $webinar->registeredUsers->pluck('id')->toArray();
    if (empty($registeredIds)) return;

    $this->service->send([
      'title'           => '🔴 Webinar is LIVE!',
      'body'            => "{$webinar->title} is starting now! Tap to join.",
      'category'        => 'webinar',
      'action_type'     => 'started',
      'notifiable_type' => 'Webinar',
      'notifiable_id'   => $webinar->id,
      'target_type'     => 'specific',
      'user_ids'        => $registeredIds,
      'screen'          => 'webinar_join',
      'screen_id'       => $webinar->id,
      'extra_data'      => ['join_url' => $webinar->join_url],
    ]);
  }

  public function webinarTeacherAdded($webinar, $teacher): void
  {
    $this->service->sendToUser($teacher->id, [
      'title'           => '🎥 Webinar Assigned',
      'body'            => "You have been assigned to host: {$webinar->title}",
      'category'        => 'webinar',
      'action_type'     => 'teacher_added',
      'notifiable_type' => 'Webinar',
      'notifiable_id'   => $webinar->id,
      'screen'          => 'webinar_detail',
      'screen_id'       => $webinar->id,
    ]);
  }

  // =============================================
  // WORKSHOP
  // =============================================
  public function workshopCreated($workshop): void
  {
    $this->service->sendToAll([
      'title'           => '🛠️ New Workshop',
      'body'            => "New workshop: {$workshop->title} - {$workshop->start_time->format('M d')}",
      'category'        => 'workshop',
      'action_type'     => 'created',
      'notifiable_type' => 'Workshop',
      'notifiable_id'   => $workshop->id,
      'screen'          => 'workshop_detail',
      'screen_id'       => $workshop->id,
      'extra_data'      => [
        'start_time'   => $workshop->start_time->toISOString(),
        'set_reminder' => true,
      ],
    ]);
  }

  public function workshopUpdated($workshop): void
  {
    $registeredIds = $workshop->registeredUsers->pluck('id')->toArray();
    if (empty($registeredIds)) return;

    $this->service->send([
      'title'           => '📝 Workshop Updated',
      'body'            => "{$workshop->title} details have changed.",
      'category'        => 'workshop',
      'action_type'     => 'updated',
      'notifiable_type' => 'Workshop',
      'notifiable_id'   => $workshop->id,
      'target_type'     => 'specific',
      'user_ids'        => $registeredIds,
      'screen'          => 'workshop_detail',
      'screen_id'       => $workshop->id,
    ]);
  }

  public function workshopClassStarted($workshop): void
  {
    $registeredIds = $workshop->registeredUsers->pluck('id')->toArray();
    if (empty($registeredIds)) return;

    $this->service->send([
      'title'           => '🛠️ Workshop Starting Now!',
      'body'            => "{$workshop->title} is live. Tap to join!",
      'category'        => 'workshop',
      'action_type'     => 'started',
      'notifiable_type' => 'Workshop',
      'notifiable_id'   => $workshop->id,
      'target_type'     => 'specific',
      'user_ids'        => $registeredIds,
      'screen'          => 'workshop_join',
      'screen_id'       => $workshop->id,
      'extra_data'      => ['join_url' => $workshop->join_url],
    ]);
  }

  public function workshopTeacherAdded($workshop, $teacher): void
  {
    $this->service->sendToUser($teacher->id, [
      'title'           => '🛠️ Workshop Assigned',
      'body'            => "You have been assigned to conduct: {$workshop->title}",
      'category'        => 'workshop',
      'action_type'     => 'teacher_added',
      'notifiable_type' => 'Workshop',
      'notifiable_id'   => $workshop->id,
      'screen'          => 'workshop_detail',
      'screen_id'       => $workshop->id,
    ]);
  }

  // =============================================
  // DEMO CLASS
  // =============================================
  public function demoClassCreated($demoClass): void
  {
    // Notify student
    $this->service->sendToUser($demoClass->student_id, [
      'title'           => '🎯 Demo Class Scheduled',
      'body'            => "Your demo class for {$demoClass->course->title} is on {$demoClass->start_time->format('M d, h:i A')}",
      'category'        => 'demo_class',
      'action_type'     => 'created',
      'notifiable_type' => 'DemoClass',
      'notifiable_id'   => $demoClass->id,
      'screen'          => 'demo_class_detail',
      'screen_id'       => $demoClass->id,
      'extra_data'      => [
        'start_time'   => $demoClass->start_time->toISOString(),
        'set_reminder' => true,
      ],
    ]);

    // Notify assigned teacher
    if ($demoClass->teacher_id) {
      $this->service->sendToUser($demoClass->teacher_id, [
        'title'           => '🎯 Demo Class Assigned',
        'body'            => "You have a demo class on {$demoClass->start_time->format('M d, h:i A')}",
        'category'        => 'demo_class',
        'action_type'     => 'created',
        'notifiable_type' => 'DemoClass',
        'notifiable_id'   => $demoClass->id,
        'screen'          => 'demo_class_detail',
        'screen_id'       => $demoClass->id,
      ]);
    }
  }

  public function demoClassUpdated($demoClass): void
  {
    $userIds = array_filter([$demoClass->student_id, $demoClass->teacher_id]);

    $this->service->send([
      'title'           => '🎯 Demo Class Updated',
      'body'            => "Demo class details have been updated.",
      'category'        => 'demo_class',
      'action_type'     => 'updated',
      'notifiable_type' => 'DemoClass',
      'notifiable_id'   => $demoClass->id,
      'target_type'     => 'specific',
      'user_ids'        => $userIds,
      'screen'          => 'demo_class_detail',
      'screen_id'       => $demoClass->id,
    ]);
  }

  // =============================================
  // INVOICE
  // =============================================
  public function invoiceCreated($invoice): void
  {
    // Notify student
    $this->service->sendToUser($invoice->user_id, [
      'title'           => '🧾 New Invoice',
      'body'            => "Invoice #{$invoice->invoice_number} of ₹{$invoice->amount} has been generated.",
      'category'        => 'invoice',
      'action_type'     => 'created',
      'notifiable_type' => 'Invoice',
      'notifiable_id'   => $invoice->id,
      'screen'          => 'invoice_detail',
      'screen_id'       => $invoice->id,
      'extra_data'      => [
        'amount'         => $invoice->amount,
        'due_date'       => $invoice->due_date?->toDateString(),
        'invoice_number' => $invoice->invoice_number,
      ],
    ]);

    // Notify admin
    $this->service->sendToAdmins([
      'title'           => '🧾 Invoice Generated',
      'body'            => "Invoice #{$invoice->invoice_number} for {$invoice->user->name} - ₹{$invoice->amount}",
      'type'            => 'in_app',
      'category'        => 'invoice',
      'action_type'     => 'created',
      'notifiable_type' => 'Invoice',
      'notifiable_id'   => $invoice->id,
      'screen'          => 'invoice_detail',
      'screen_id'       => $invoice->id,
    ]);
  }

  public function invoicePaid($invoice): void
  {
    $this->service->sendToAdmins([
      'title'           => '💰 Payment Received',
      'body'            => "{$invoice->user->name} paid ₹{$invoice->amount} for Invoice #{$invoice->invoice_number}",
      'category'        => 'invoice',
      'action_type'     => 'paid',
      'notifiable_type' => 'Invoice',
      'notifiable_id'   => $invoice->id,
      'screen'          => 'invoice_detail',
      'screen_id'       => $invoice->id,
    ]);
  }

  // =============================================
  // NEW REQUEST (Admin Phone Alert)
  // =============================================
  public function newRequestReceived($request): void
  {
    $this->service->sendToAdmins([
      'title'       => '📞 New Request!',
      'body'        => "{$request->user->name}: {$request->subject}",
      'category'    => 'admission',
      'action_type' => 'new_request',
      'screen'      => 'request_detail',
      'screen_id'   => $request->id,
      'extra_data'  => [
        'phone'   => $request->user->phone,
        'email'   => $request->user->email,
        'urgent'  => true,
      ],
    ]);
  }

  // =============================================
  // REWARD
  // =============================================
  public function rewardUpdated($reward): void
  {
    // Notify student
    $this->service->sendToUser($reward->user_id, [
      'title'           => '🎁 Reward Points Updated!',
      'body'            => "You earned {$reward->points} reward points! Total: {$reward->total_points}",
      'category'        => 'reward',
      'action_type'     => 'updated',
      'notifiable_type' => 'Reward',
      'notifiable_id'   => $reward->id,
      'screen'          => 'rewards',
      'screen_id'       => $reward->user_id,
    ]);

    // Notify admin (in-app only)
    $this->service->sendToAdmins([
      'title'           => '🎁 Reward Given',
      'body'            => "{$reward->user->name} received {$reward->points} reward points",
      'type'            => 'in_app',
      'category'        => 'reward',
      'action_type'     => 'updated',
      'notifiable_type' => 'Reward',
      'notifiable_id'   => $reward->id,
      'screen'          => 'reward_management',
      'screen_id'       => $reward->id,
    ]);
  }

  // =============================================
  // ACHIEVEMENT
  // =============================================
  public function achievementUpdated($achievement): void
  {
    $this->service->sendToUser($achievement->user_id, [
      'title'           => '🏆 Achievement Unlocked!',
      'body'            => "Congratulations! You earned: {$achievement->title}",
      'category'        => 'achievement',
      'action_type'     => 'updated',
      'notifiable_type' => 'Achievement',
      'notifiable_id'   => $achievement->id,
      'screen'          => 'achievements',
      'screen_id'       => $achievement->id,
      'extra_data'      => [
        'badge_url'   => $achievement->badge_url,
        'description' => $achievement->description,
      ],
    ]);
  }

  // =============================================
  // TRANSFER REQUEST
  // =============================================
  public function transferRequested($transfer): void
  {
    // Notify admin + staff
    $this->service->sendToAdmins([
      'title'           => '🔄 Transfer Request',
      'body'            => "{$transfer->user->name} requested a batch transfer",
      'category'        => 'transfer',
      'action_type'     => 'requested',
      'notifiable_type' => 'Transfer',
      'notifiable_id'   => $transfer->id,
      'screen'          => 'transfer_detail',
      'screen_id'       => $transfer->id,
    ]);
  }

  public function transferApproved($transfer): void
  {
    // Notify requesting user
    $this->service->sendToUser($transfer->user_id, [
      'title'           => '✅ Transfer Approved',
      'body'            => 'Your transfer request has been approved.',
      'category'        => 'transfer',
      'action_type'     => 'approved',
      'notifiable_type' => 'Transfer',
      'notifiable_id'   => $transfer->id,
      'screen'          => 'transfer_detail',
      'screen_id'       => $transfer->id,
    ]);
  }

  public function transferRejected($transfer): void
  {
    $this->service->sendToUser($transfer->user_id, [
      'title'           => '❌ Transfer Request Update',
      'body'            => 'Your transfer request has been reviewed. Please contact admin.',
      'category'        => 'transfer',
      'action_type'     => 'rejected',
      'notifiable_type' => 'Transfer',
      'notifiable_id'   => $transfer->id,
      'screen'          => 'transfer_detail',
      'screen_id'       => $transfer->id,
    ]);
  }

  // =============================================
  // SPEND TIME
  // =============================================
  public function spendTimeUpdated($spendTime): void
  {
    // In-app only for admin/staff/teacher
    $this->service->sendToAdminStaffTeacher([
      'title'           => '⏱️ Study Time Logged',
      'body'            => "{$spendTime->user->name} studied {$spendTime->duration} mins on {$spendTime->course->title}",
      'type'            => 'in_app',
      'category'        => 'spend_time',
      'action_type'     => 'updated',
      'notifiable_type' => 'SpendTime',
      'notifiable_id'   => $spendTime->id,
      'screen'          => 'spend_time_report',
      'screen_id'       => $spendTime->user_id,
    ]);
  }
}
