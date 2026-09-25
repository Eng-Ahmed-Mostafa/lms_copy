<?php

namespace App\Providers;

use App\Interface\Api\Academic\AcademicYearInterface;
use App\Interface\Api\Academic\ClassroomInterface;
use App\Interface\Api\Academic\GradeInterface;
use App\Interface\Api\Academic\SubjectInterface;
use App\Interface\Api\Academic\TermInterface;
use App\Interface\Api\Auth\AuthInterface;
use App\Interface\Api\Courses\ChapterInterface;
use App\Interface\Api\Courses\CourseCategoryInterface;
use App\Interface\Api\Courses\CourseInterface;
use App\Interface\Api\People\GuardianInterface;
use App\Interface\Api\People\StudentInterface;
use App\Interface\Api\People\TeacherInterface;
use App\Interface\Api\User\PermissionInterface;
use App\Interface\Api\User\RoleInterface;
use App\Interface\Api\User\UserInterface;
use App\Repository\Api\Academic\TermRepository;
use App\Repository\Api\Academic\AcademicYearRepository;
use App\Repository\Api\Academic\ClassroomRepository;
use App\Repository\Api\Academic\GradeRepository;
use App\Repository\Api\Academic\SubjectRepository;
use App\Repository\Api\Auth\AuthRepository;
use App\Repository\Api\Courses\ChapterRepository;
use App\Repository\Api\Courses\CourseCategoryRepository;
use App\Repository\Api\Courses\CourseRepository;
use App\Repository\Api\People\GuardianRepository;
use App\Repository\Api\People\StudentRepository;
use App\Repository\Api\People\TeacherRepository;
use App\Repository\Api\User\PermissionRepository;
use App\Repository\Api\User\RoleRepository;
use App\Repository\Api\User\UserRepository;
use Illuminate\Support\ServiceProvider;

class InterfaceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(
            AuthInterface::class,
            AuthRepository::class
        );

        $this->app->bind(
            UserInterface::class,
            UserRepository::class
        );

        $this->app->bind(
            RoleInterface::class,
            RoleRepository::class
        );

        $this->app->bind(
            PermissionInterface::class,
            PermissionRepository::class
        );

        $this->app->bind(
            AcademicYearInterface::class,
            AcademicYearRepository::class
        );

        $this->app->bind(
            TermInterface::class,
            TermRepository::class
        );

        $this->app->bind(
            GradeInterface::class,
            GradeRepository::class
        );

        $this->app->bind(
            ClassroomInterface::class,
            ClassroomRepository::class
        );

        $this->app->bind(
            SubjectInterface::class,
            SubjectRepository::class
        );

        $this->app->bind(
            TeacherInterface::class,
            TeacherRepository::class
        );

        $this->app->bind(
            StudentInterface::class,
            StudentRepository::class
        );

        $this->app->bind(
            GuardianInterface::class,
            GuardianRepository::class
        );

        $this->app->bind(
            CourseCategoryInterface::class,
            CourseCategoryRepository::class
        );

        $this->app->bind(
            CourseInterface::class,
            CourseRepository::class
        );

        $this->app->bind(
            ChapterInterface::class,
            ChapterRepository::class
        );
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
