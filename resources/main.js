document.addEventListener('DOMContentLoaded', () => {
    console.log('LMS Theme Loaded');

    // Simple Filter Logic (Simulation)
    const applyFiltersBtn = document.getElementById('apply-filters');
    const searchInput = document.getElementById('course-search');

    if (applyFiltersBtn) {
        applyFiltersBtn.addEventListener('click', () => {
            const searchTerm = searchInput.value.toLowerCase();
            console.log('Applying filters for:', searchTerm);

            // Visual feedback
            applyFiltersBtn.innerText = 'Applying...';
            setTimeout(() => {
                applyFiltersBtn.innerText = 'Apply Filters';
            }, 600);
        });
    }

    // Lesson Navigation (Simulation)
    const lessons = document.querySelectorAll('.sidebar-lesson');
    if (lessons.length > 0) {
        lessons.forEach(lesson => {
            lesson.addEventListener('click', () => {
                lessons.forEach(l => l.classList.remove('active'));
                lesson.classList.add('active');

                // Update lesson title in header
                const title = lesson.querySelector('p').innerText;
                const headerTitle = document.querySelector('h1');
                if (headerTitle) headerTitle.innerText = title;

                console.log('Navigated to lesson:', title);
            });
        });
    }

    // Scroll effect for navbar
    window.addEventListener('scroll', () => {
        const navbar = document.querySelector('.navbar');
        if (navbar) {
            if (window.scrollY > 20) {
                navbar.style.background = 'rgba(15, 23, 42, 0.95)';
                navbar.style.borderBottomColor = 'var(--primary-color)';
            } else {
                navbar.style.background = 'rgba(15, 23, 42, 0.8)';
                navbar.style.borderBottomColor = 'var(--border-color)';
            }
        }
    });
});
