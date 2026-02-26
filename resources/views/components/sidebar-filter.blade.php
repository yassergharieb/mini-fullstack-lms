<aside class="filter-sidebar glass-card animate-fade-in" style="margin: 2rem 0; height: fit-content; position: sticky; top: 90px;">
    <form action="{{ route('home') }}" method="GET">
        <div class="filter-group">
            <h3 class="filter-title">Search</h3>
            <div style="position: relative;">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search courses..." style="width: 100%; padding: 0.75rem; background: var(--bg-dark); border: 1px solid var(--border-color); border-radius: 0.5rem; color: white;">
            </div>
        </div>

        <div class="filter-group">
            <h3 class="filter-title">Level</h3>
            @foreach($levels as $level)
                <label class="filter-option">
                    <input type="checkbox" name="level[]" value="{{ $level->slug }}" {{ is_array(request('level')) && in_array($level->slug, request('level')) ? 'checked' : '' }}> {{ $level->name }}
                </label>
            @endforeach
        </div>

        <button type="submit" class="btn btn-primary" style="width: 100%;">Apply Filters</button>
        <a href="{{ route('home') }}" class="btn btn-outline" style="width: 100%; margin-top: 0.5rem; text-align: center; text-decoration: none; display: block;">Clear Filters</a>
    </form>
</aside>
