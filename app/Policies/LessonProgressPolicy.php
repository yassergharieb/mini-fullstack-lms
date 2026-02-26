<?php

namespace App\Policies;

use App\Models\LessonProgress;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class LessonProgressPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('view_any_lesson_progress');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, LessonProgress $lessonProgress): bool
    {
        return $user->id === $lessonProgress->user_id || $user->can('view_lesson_progress');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create_lesson_progress');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, LessonProgress $lessonProgress): bool
    {
        return $user->id === $lessonProgress->user_id || $user->can('update_lesson_progress');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, LessonProgress $lessonProgress): bool
    {
        return $user->id === $lessonProgress->user_id || $user->can('delete_lesson_progress');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user): bool
    {
        return $user->can('restore_lesson_progress');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user): bool
    {
        return $user->can('force_delete_lesson_progress');
    }
}
