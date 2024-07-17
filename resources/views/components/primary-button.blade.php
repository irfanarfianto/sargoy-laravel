<button {{ $attributes->merge(['type' => 'submit', 'class' => 'btn btn-primary']) }}>
    <span class="loading loading-spinner spinner-border spinner-border-sm" role="status" aria-hidden="true"
        style="display: none;"></span>
    <span class="btn-text">{{ $slot }}</span>
</button>
