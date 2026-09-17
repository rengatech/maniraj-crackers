<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Maniraj Crackers - Buy Crackers Online Sivakasi | Wholesale & Retail Fireworks</title>
    <meta name="description" content="Buy crackers online from Sivakasi at wholesale prices. Maniraj Crackers offers 200+ fireworks products with up to 60% discount. Safe green crackers, gift boxes, sparklers, aerial shots & more. All India delivery.">
    <meta name="keywords" content="buy crackers online, sivakasi crackers, diwali crackers, wholesale crackers, fireworks online, green crackers, crackers price list, sivakasi fireworks, crackers gift box, crackers delivery india, maniraj crackers">
    <meta name="author" content="Maniraj Crackers">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="{{ url()->current() }}">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="Maniraj Crackers - Buy Crackers Online Sivakasi | Wholesale & Retail">
    <meta property="og:description" content="Buy crackers online from Sivakasi at wholesale prices. 200+ products, up to 60% discount, all India delivery. Sparklers, aerial shots, gift boxes & more.">
    <meta property="og:image" content="{{ asset('assets/img/maniraj.logo.jpg') }}">
    <meta property="og:site_name" content="Maniraj Crackers">
    <meta property="og:locale" content="en_IN">

    <!-- Twitter / X -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:url" content="{{ url()->current() }}">
    <meta name="twitter:title" content="Maniraj Crackers - Buy Crackers Online Sivakasi">
    <meta name="twitter:description" content="Buy crackers online from Sivakasi at wholesale prices. 200+ products, up to 60% discount, all India delivery.">
    <meta name="twitter:image" content="{{ asset('assets/img/maniraj.logo.jpg') }}">

    <!-- WhatsApp Preview -->
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">

    <!-- Geo Tags -->
    <meta name="geo.region" content="IN-TN">
    <meta name="geo.placename" content="Sivakasi">
    <meta name="geo.position" content="9.371407;77.810753">
    <meta name="ICBM" content="9.371407, 77.810753">

    <!-- Favicon -->
    <link href="/assets/img/maniraj.logo.jpg" rel="icon">
    <link rel="apple-touch-icon" href="/assets/img/maniraj.logo.jpg">

    <!-- JSON-LD Structured Data -->
    @verbatim
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "Store",
        "name": "Maniraj Crackers",
        "description": "Buy crackers online from Sivakasi at wholesale and retail prices. Sparklers, aerial shots, gift boxes, green crackers and more with all India delivery.",
        "url": "https://manirajcrackers.com",
        "logo": "https://manirajcrackers.com/assets/img/maniraj.logo.jpg",
        "image": "https://manirajcrackers.com/assets/img/maniraj.logo.jpg",
        "telephone": "+919976739559. 8248128425",
        "email": "manirajshivani@gmail.com",
        "address": {
            "@type": "PostalAddress",
            "streetAddress": "D.No:4/320, Sivakasi to  kazhugumalai main road naduvappatti",
            "addressLocality": "Sivakasi",
            "addressRegion": "Tamil Nadu",
            "postalCode": "627713",
            "addressCountry": "IN"
        },
        "geo": {
            "@type": "GeoCoordinates",
            "latitude": 9.371407,
            "longitude": 77.810753
        },
        "priceRange": "₹30 - ₹50,000",
        "openingHoursSpecification": {
            "@type": "OpeningHoursSpecification",
            "dayOfWeek": ["Monday","Tuesday","Wednesday","Thursday","Friday","Saturday","Sunday"],
            "opens": "08:00",
            "closes": "21:00"
        },
        "sameAs": [
            "https://wa.link/w3i0ww"
        ]
    }
    </script>

    <!-- Sitelinks Search Box -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "WebSite",
        "name": "Maniraj Crackers",
        "url": "https://manirajcrackers.com",
        "potentialAction": {
            "@type": "SearchAction",
            "target": "https://manirajcrackers.com/?q={search_term_string}",
            "query-input": "required name=search_term_string"
        }
    }
    </script>

    <!-- Breadcrumb / SiteNavigationElement for Sitelinks -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "ItemList",
        "itemListElement": [
            {"@type": "SiteNavigationElement", "position": 1, "name": "Home", "url": "https://manirajcrackers.com/"},
            {"@type": "SiteNavigationElement", "position": 2, "name": "About Us", "url": "https://manirajcrackers.com/about"},
            {"@type": "SiteNavigationElement", "position": 3, "name": "OrderNow", "url": "https://manirajcrackers.com/ordernow"},
            {"@type": "SiteNavigationElement", "position": 4, "name": "Safetytips", "url": "https://manirajcrackers.com/safetytips"},
            {"@type": "SiteNavigationElement", "position": 5, "name": "Contact", "url": "https://manirajcrackers.com/contact"},
            {"@type": "SiteNavigationElement", "position": 6, "name": "Privacy Policy", "url": "https://manirajcrackers.com/privacy-policy"},
            {"@type": "SiteNavigationElement", "position": 7, "name": "Price List", "url": "https://manirajcrackers.com/pricelist"}
        ]
    }
    </script>
    @endverbatim

    @routes
    @vite(['resources/js/app.js'])
    @inertiaHead
  <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@700&family=Playfair+Display:wght@400;600&family=Outfit:wght@500;600;700&display=swap" rel="stylesheet">
</head>
<body class="font-sans antialiased bg-brand-light text-brand-gray">
    @inertia
</body>
</html>