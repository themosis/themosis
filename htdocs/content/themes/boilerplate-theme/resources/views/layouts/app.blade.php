<!doctype html>
<html @php language_attributes() @endphp>
@include('components.head')

<body @php body_class() @endphp>
@php do_action('wp_body') @endphp

@php do_action('get_header') @endphp

@include('modules.header')

@yield('content')

@php do_action('get_footer') @endphp

@include('modules.footer')
@php wp_footer() @endphp
</body>
</html>
