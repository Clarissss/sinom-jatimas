<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="@yield('meta_description', 'PT. Sinom Jati Mas - General Contractor & General Trading.')">
    <meta name="theme-color" content="#D33F23">
    <title>@yield('title', 'PT. Sinom Jati Mas')</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer">

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: { DEFAULT: '#D33F23', dark: '#b9351e', light: '#FF812E' },
                        primary: { 50: '#fef2f2', 100: '#fee2e2', 200: '#fecaca', 300: '#fca5a5', 400: '#f87171', 500: '#ef4444', 600: '#dc2626', 700: '#b91c1c', 800: '#991b1b', 900: '#7f1d1d' },
                        secondary: { 50: '#fff7ed', 100: '#ffedd5', 200: '#fed7aa', 300: '#fdba74', 400: '#fb923c', 500: '#f97316', 600: '#ea580c', 700: '#c2410c', 800: '#9a3412', 900: '#7c2d12' }
                    },
                    fontFamily: {
                        sans: ['Inter', 'system-ui', '-apple-system', 'sans-serif'],
                    }
                }
            }
        };
    </script>
    <style>
        html { scroll-behavior: smooth; }
        @stack('styles')
    </style>
</head>
<body class="font-sans antialiased text-gray-900 bg-gray-50">
    @include('partials.public.navbar', ['active' => $activePage ?? ''])

    <main>
        @yield('content')
    </main>

    @unless(isset($hideCta) && $hideCta)
        @include('partials.public.cta-banner', ['ctaClass' => ($activePage ?? '') === 'about' ? 'mt-4' : ''])
    @endunless

    @include('partials.public.footer')

    @include('partials.public.scripts')
    @stack('scripts')
</body>
</html>
