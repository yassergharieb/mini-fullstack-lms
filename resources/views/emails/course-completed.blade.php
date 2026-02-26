<x-mail::message>
# You Did It, {{ $user->name }}! 🎉

Congratulations on completing the course **{{ $course->name }}**! Your dedication and hard work have paid off. We hope you found the course valuable and that you're ready to apply your new skills.

<x-mail::button :url="route('courses.index')">
View My Courses
</x-mail::button>

Keep up the great momentum!<br>
The {{ config('app.name') }} Team
</x-mail::message>
