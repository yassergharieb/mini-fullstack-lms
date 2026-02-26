<x-mail::message>
# Welcome to Premium LMS, {{ $user->name }}!

We're thrilled to have you join our learning community. Get ready to explore high-quality courses and advance your skills with our premium experience.

<x-mail::button :url="config('app.url')">
Explore Courses
</x-mail::button>

Happy learning,<br>
The {{ config('app.name') }} Team
</x-mail::message>
