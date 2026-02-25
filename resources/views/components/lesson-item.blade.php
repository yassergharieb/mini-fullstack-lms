<div class="sidebar-lesson {{ $status ?? '' }}">
    <div style="width: 24px; height: 24px; display: flex; align-items: center; justify-content: center; {{ $status === 'completed' ? 'background: var(--secondary-color); color: white;' : ($status === 'active' ? 'background: var(--primary-color);' : 'border: 1px solid var(--border-color);') }} border-radius: 50%; font-size: 0.7rem;">
        {{ $status === 'completed' ? '✓' : $index }}
    </div>
    <div>
        <p style="font-size: 0.9rem; font-weight: 600;">{{ $title }}</p>
        <span style="font-size: 0.75rem; color: var(--text-muted);">{{ $type }} - {{ $duration }}</span>
    </div>
</div>
