<div class="course-card glass-card animate-fade-in" style="{{ $style ?? '' }}">
    <a href="{{route('courses.show' , $slug)}}">
        <img  src="{{ $cover_image }}"  class="course-img">
    </a>

    <div class="course-content">
        <span class="course-badge">{{ $level }}</span>
        <h3 class="course-title">{{ $name }}</h3>
        <p style="color: var(--text-muted); font-size: 0.85rem;">{{ $description }}</p>
        <div class="course-info">
            <span class="course-price">{{ $price }}</span>
            @if($price === 'Enrolled')
                <a href="{{ route('courses.play', $slug) }}" class="btn btn-primary" style="padding: 0.4rem 1rem; font-size: 0.8rem;">Continue Learning</a>
            @else
                <form action="{{ route('courses.enroll', $slug) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-primary" style="padding: 0.4rem 1rem; font-size: 0.8rem;">Enroll</button>
                </form>
            @endif
        </div>
    </div>
</div>



