@component('mail::layout')
{{-- Header --}}
<style>
td.header{background :#1b86e3; }
</style>
@slot('header')
@component('mail::header', ['url' => '{{request()->getHost()}}', 'background' => '#1b86e3'])
 <img width="15%" src="{{request()->getHost()}}/assets/images/logo.png">
@endcomponent
@endslot
{{-- Greeting --}}
@if (! empty($greeting))
# {{ $greeting }}
@else
# Hello!
@endif

{{-- Intro Lines --}}
@isset($introLines)
@foreach ($introLines as $line)
{{ $line }}

@endforeach
@endisset
{{-- Body --}}

@isset($actionText)
@component('mail::button', ['url' => $url])
{{$actionText}}
@endcomponent
@endisset

{{-- Salutation --}}
@isset($salutation)
@if (! empty($salutation))
{{ $salutation }}
@else
Regards,
{{ config('app.name') }}
@endif
@endisset
{{-- Outro Lines --}}
@isset($outroLines)
@foreach ($outroLines as $line)
{{ $line }}

@endforeach
@endisset
{{-- Subcopy --}}
    @isset($subcopy)
        @slot('subcopy')
            @component('mail::subcopy')
                {{ $subcopy }}
            @endcomponent
        @endslot
    @endisset

{{-- Footer --}}
<style>
table.footer{background :#222222;width:100%; }
</style>

    @slot('footer')
        @component('mail::footer')
            Copyright © All Right Reserved {{ date('Y') }}.
        @endcomponent
    @endslot
@endcomponent