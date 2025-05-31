@props([
    'id' => null,
    'name' => null,
    'options' => [],
    'selected' => null,
    'placeholder' => 'Select an option',
    'onchange' => null,
    'size' => 'md', // sm, md, lg
    'color' => 'primary', // primary, secondary
    'class' => '',
])

<div class="styled-select-dropdown {{ $size }} {{ $color }} {{ $class }}">
    <select @if ($id) id="{{ $id }}" @endif
        @if ($name) name="{{ $name }}" @endif
        @if ($onchange) onchange="{{ $onchange }}" @endif class="form-select">
        @if ($placeholder)
            <option value="">{{ $placeholder }}</option>
        @endif

        @foreach ($options as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }}>
                {{ $label }}
            </option>
        @endforeach
    </select>
</div>



<style>
    .styled-select-dropdown {
        position: relative;
        display: inline-block;
        width: 100%;
        margin-bottom: 1rem;
    }

    .styled-select-dropdown select {
        appearance: none;
        -webkit-appearance: none;
        -moz-appearance: none;
        background-color: white;
        border: 1px solid #4723d9;
        color: #4723d9;
        padding: 0.5rem 2rem 0.5rem 1rem;
        border-radius: 0.375rem;
        font-size: 1rem;
        cursor: pointer;
        width: 100%;
        height: 38px;
        transition: all 0.2s ease;
    }

    .styled-select-dropdown::after {
        content: "\F282";
        font-family: "bootstrap-icons";
        position: absolute;
        top: 50%;
        right: 0.75rem;
        transform: translateY(-50%);
        pointer-events: none;
        color: #4723d9;
    }

    .styled-select-dropdown select:focus {
        outline: none;
        box-shadow: 0 0 0 0.25rem rgba(71, 35, 217, 0.25);
        border-color: #4723d9;
    }

    .styled-select-dropdown select:hover {
        background-color: rgba(71, 35, 217, 0.05);
    }

    /* Sizes */
    .styled-select-dropdown.sm select {
        padding: 0.25rem 1.75rem 0.25rem 0.75rem;
        font-size: 0.875rem;
        height: 32px;
    }

    .styled-select-dropdown.lg select {
        padding: 0.5rem 2.25rem 0.5rem 1rem;
        font-size: 1.25rem;
        height: 44px;
    }

    /* Colors */
    .styled-select-dropdown.primary select {
        border-color: #4723d9;
        color: #4723d9;
    }

    .styled-select-dropdown.secondary select {
        border-color: #6c757d;
        color: #6c757d;
    }

    .styled-select-dropdown.primary select:focus {
        box-shadow: 0 0 0 0.25rem rgba(71, 35, 217, 0.25);
    }

    .styled-select-dropdown.secondary select:focus {
        box-shadow: 0 0 0 0.25rem rgba(108, 117, 125, 0.25);
    }
</style>
