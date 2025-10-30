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
        <main>
            <div class="container pt-4">
                @if(session('success'))
                    <div class="alert alert-success" role="alert">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger" role="alert">
                        {{ session('error') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger" role="alert">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>

            @yield('content')
        </main>
        <!--Fin Contenu changeant-->

        <!-- Footer-->
        @include('layouts.includes.footer')
        
        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        
        <!-- Smooth Scroll -->
        <script>
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function (e) {
                    const href = this.getAttribute('href');
                    if (href === '#' || href === '#!') {
                        e.preventDefault();
                        return;
                    }

                    try {
                        const target = document.querySelector(href);
                        if (target) {
                            e.preventDefault();
                            target.scrollIntoView({ behavior: 'smooth' });
                        }
                    } catch (error) {
                        // Gérer les sélecteurs invalides si nécessaire
                        console.warn('Sélecteur invalide pour le défilement en douceur :', href);
                    }
                });
            });
        </script>

        <!-- Pannellum JS -->
        <script src="https://cdn.jsdelivr.net/npm/pannellum@2.5.6/build/pannellum.js"></script>
        @stack('scripts')
</html>
