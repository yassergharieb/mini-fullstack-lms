<?php

namespace App\Filament\Widgets;

use App\Models\Course;
use Filament\Widgets\ChartWidget;

class PopularCoursesChart extends ChartWidget
{
    protected static ?string $heading = 'Popular Courses';

    protected function getData(): array
    {
        $popularCourses = Course::withCount('enrollments')
            ->orderByDesc('enrollments_count')
            ->limit(5)
            ->get();

        return [
            'datasets' => [
                [
                    'label' => 'Students',
                    'data' => $popularCourses->pluck('enrollments_count')->toArray(),
                    'backgroundColor' => '#f59e0b',
                ],
            ],
            'labels' => $popularCourses->pluck('name')->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
