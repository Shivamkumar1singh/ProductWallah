{{-- 
|--------------------------------------------------------------------------
| Recursive Category Dropdown Menu
|--------------------------------------------------------------------------
| Supports unlimited category nesting
| Example:
| Electronics
|   └ Smartphones
|       └ Oppo
|           └ Reno
|--------------------------------------------------------------------------
| Expected variable:
| $categories (Collection of Category models)
|--------------------------------------------------------------------------
--}}

<li class="dropdown-submenu">
    <a class="dropdown-item {{ isset($selectedCategory) && $selectedCategory->id == $category->id ? 'active text-dark' : '' }}"
       href="{{ route('shop.category', $category->id) }}">
        {{ $category->name }}
        @if($category->children->count())
            <span class="ms-1">›</span>
        @endif
    </a>

    @if($category->children->count())
        <ul class="dropdown-menu">
            @foreach($category->children as $child)
                @include('shop.category', ['category' => $child])
            @endforeach
        </ul>
    @endif
</li>



