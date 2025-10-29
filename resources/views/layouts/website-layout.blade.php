<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="PlanMaison3D - Trouvez et achetez des plans de maisons 3D modernes et personnalisables" />
        <meta name="author" content="PlanMaison3D" />
        <title>PlanMaison3D - Plans de Maisons 3D Modernes</title>
        <!-- Favicon-->
        <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}" />
        <!-- Bootstrap icons-->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="{{asset('css/style.css')}}" rel="stylesheet" />
        <!-- Custom CSS -->
        <link href="{{asset('css/custom.css')}}" rel="stylesheet" />

        <!-- Pannellum CSS -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/pannellum@2.5.6/build/pannellum.css"/>
        @stack('styles')
    </head>
    <body>
        <!-- Navigation-->
        @include('layouts.includes.header')

        <!--Contenu changeant-->
        @yield('content')
        <!--Fin Contenu changeant-->

        <!-- Footer-->
        @include('layouts.includes.footer')
        
        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        
        <!-- Smooth Scroll -->
        <script>
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function (e) {
                    e.preventDefault();
                    const target = document.querySelector(this.getAttribute('href'));
                    if (target) {
                        target.scrollIntoView({ behavior: 'smooth' });
                    }
                });
            });
        </script>

        <!-- Pannellum JS -->
        <script src="https://cdn.jsdelivr.net/npm/pannellum@2.5.6/build/pannellum.js"></script>
        @stack('scripts')
</html>
