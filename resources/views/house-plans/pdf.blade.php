<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Plan de Maison : {{ $plan->name }}</title>
    <style>
        body { font-family: 'Helvetica', sans-serif; color: #333; }
        .container { width: 90%; margin: 0 auto; }
        h1 { color: #0d6efd; border-bottom: 2px solid #0d6efd; padding-bottom: 10px; }
        .details-table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        .details-table th, .details-table td { border: 1px solid #ddd; padding: 12px; text-align: left; }
        .details-table th { background-color: #f8f9fa; }
        .plan-image { text-align: center; margin-top: 30px; }
        .plan-image img { max-width: 100%; height: auto; border: 1px solid #ddd; padding: 5px; }
        .footer { text-align: center; margin-top: 40px; font-size: 0.9em; color: #777; }
    </style>
</head>
<body>
    <div class="container">
        <h1>{{ $plan->name }}</h1>
        <p>{{ $plan->description }}</p>

        <table class="details-table">
            <tr>
                <th>Superficie</th>
                <td>{{ $plan->surface_area }} m²</td>
            </tr>
            <tr>
                <th>Style</th>
                <td>{{ ucfirst($plan->style) }}</td>
            </tr>
            <tr>
                <th>Chambres</th>
                <td>{{ $plan->bedrooms }}</td>
            </tr>
            <tr>
                <th>Salles de bain</th>
                <td>{{ $plan->bathrooms }}</td>
            </tr>
            <tr>
                <th>Étages</th>
                <td>R+{{ $plan->floors }}</td>
            </tr>
            <tr>
                <th>Prix</th>
                <td>{{ number_format($plan->price, 2, ',', ' ') }} €</td>
            </tr>
        </table>

        @if($plan->plan_2d_path && file_exists(public_path($plan->plan_2d_path)))
            <div class="plan-image">
                <h2>Plan 2D</h2>
                <img src="{{ public_path($plan->plan_2d_path) }}" alt="Plan 2D">
            </div>
        @endif

        <div class="footer">
            PlanMaison3D - Retrouvez plus de plans sur www.planmaison3d.tg
        </div>
    </div>
</body>
</html>
