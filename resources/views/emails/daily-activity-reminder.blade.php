<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rappel quotidien - Portail de Rapportage</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            background-color: #f4f6f9;
            margin: 0;
            padding: 0;
            color: #333333;
        }
        .container {
            max-width: 600px;
            margin: 30px auto;
            background: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        }
        .header {
            background-color: #0072bc;
            color: #ffffff;
            padding: 24px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 22px;
            font-weight: 600;
        }
        .header p {
            margin: 5px 0 0 0;
            font-size: 14px;
            opacity: 0.9;
        }
        .content {
            padding: 30px 24px;
            line-height: 1.6;
        }
        .greeting {
            font-size: 18px;
            font-weight: bold;
            color: #0072bc;
            margin-bottom: 15px;
        }
        .card {
            background-color: #f8fafc;
            border-left: 4px solid #0072bc;
            padding: 15px 20px;
            margin: 20px 0;
            border-radius: 4px;
        }
        .button-wrapper {
            text-align: center;
            margin: 30px 0;
        }
        .btn {
            display: inline-block;
            background-color: #0072bc;
            color: #ffffff !important;
            text-decoration: none;
            padding: 12px 28px;
            border-radius: 6px;
            font-weight: bold;
            font-size: 15px;
        }
        .btn:hover {
            background-color: #00568c;
        }
        .footer {
            background-color: #f1f5f9;
            padding: 20px;
            text-align: center;
            font-size: 12px;
            color: #64748b;
            border-top: 1px solid #e2e8f0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Portail de Rapportage des Partenaires</h1>
            <p>Suivi et Coordination des Activités</p>
        </div>
        <div class="content">
            <div class="greeting">Bonjour {{ $user->nom }},</div>
            <p>Ceci est un rappel automatique de fin de journée pour vous inviter à saisir et mettre à jour vos activités réalisées aujourd'hui (<strong>{{ date('d/m/Y') }}</strong>).</p>
            
            <div class="card">
                <strong>Organisation :</strong> {{ optional($user->organisation)->denomination ?? 'N/A' }}<br>
                <strong>Date :</strong> {{ date('d/m/Y') }}
            </div>

            <p>Un rapportage régulier permet d'assurer une meilleure visibilité et coordination de vos interventions sur le terrain.</p>

            <div class="button-wrapper">
                <a href="{{ $dashboardUrl }}" class="btn">Saisir mes activités du jour</a>
            </div>

            <p>Si vous avez déjà complété votre rapportage pour aujourd'hui, vous pouvez ignorer ce message.</p>
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} {{ $appName }}. Tous droits réservés.</p>
            <p>Cet e-mail a été envoyé automatiquement. Veuillez ne pas y répondre directement.</p>
        </div>
    </div>
</body>
</html>
