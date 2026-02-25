<aside class="filter-sidebar glass-card animate-fade-in" style="margin: 2rem 0; height: fit-content; position: sticky; top: 90px;">
    <div class="filter-group">
        <h3 class="filter-title">Search</h3>
        <div style="position: relative;">
            <input type="text" id="course-search" placeholder="Search courses..." style="width: 100%; padding: 0.75rem; background: var(--bg-dark); border: 1px solid var(--border-color); border-radius: 0.5rem; color: white;">
        </div>
    </div>

    <div class="filter-group">
        <h3 class="filter-title">Category</h3>
        @foreach(['development', 'design', 'business', 'marketing'] as $category)
            <label class="filter-option">
                <input type="checkbox" name="category" value="{{ $category }}"> {{ ucfirst($category) }}
            </label>
        @endforeach
    </div>

    <div class="filter-group">
        <h3 class="filter-title">Level</h3>
        @foreach(['beginner', 'intermediate', 'advanced'] as $level)
            <label class="filter-option">
                <input type="checkbox" name="level" value="{{ $level }}"> {{ ucfirst($level) }}
            </label>
        @endforeach
    </div>

    <div class="filter-group">
        <h3 class="filter-title">Price</h3>
        <label class="filter-option">
            <input type="radio" name="price" value="free"> Free
        </label>
        <label class="filter-option">
            <input type="radio" name="price" value="paid"> Paid
        </label>
        <label class="filter-option">
            <input type="radio" name="price" value="all" checked> All
        </label>
    </div>

    <button id="apply-filters" class="btn btn-primary" style="width: 100%;">Apply Filters</button>
</aside>
