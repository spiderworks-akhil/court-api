@isset($breadcrumbs)
<div class="container">
    <ol class="breadcrumb breadcrumb-alt">
        @isset($breadcrumbs_inner)
            {{ Breadcrumbs::render($breadcrumbs,$breadcrumbs_inner) }}
        @else
            {{ Breadcrumbs::render($breadcrumbs) }}
        @endisset
    </ol>
</div>
@endisset