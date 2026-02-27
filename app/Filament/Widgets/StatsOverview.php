<?php

namespace App\Filament\Widgets;

use App\Models\Course;
use App\Models\CourseCompletion;
use App\Models\Enrollment;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $totalCourses = Course::count();
        $totalEnrollments = Enrollment::count();
        $totalCompletions = CourseCompletion::count();
        $totalStudents = \App\Models\User::role('student')->count();
        
        $completionRate = $totalEnrollments > 0 
            ? round(($totalCompletions / $totalEnrollments) * 100, 1) 
            : 0;

        return [
            Stat::make('Total Students', $totalStudents)
                ->description('Registered student users')
                ->descriptionIcon('heroicon-m-user-group')
                ->color('info'),
            Stat::make('Total Courses', $totalCourses)
                ->description('All published and draft courses')
                ->descriptionIcon('heroicon-m-academic-cap')
                ->color('primary'),
            Stat::make('Total Enrollments', $totalEnrollments)
                ->description('Total student enrollments')
                ->descriptionIcon('heroicon-m-users')
                ->color('success'),
            Stat::make('Completion Rate', $completionRate . '%')
                ->description('Courses fully completed vs enrollments')
                ->descriptionIcon('heroicon-m-check-badge')
                ->color('warning'),
        ];
    }
}
