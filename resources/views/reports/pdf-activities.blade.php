<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Rapport d'Activités Opérationnelles</title>
    <style>
        @page {
            size: A4 portrait;
            margin: 15mm 12mm 20mm 12mm;
        }

        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            font-size: 11px;
            color: #1e293b;
            line-height: 1.4;
            background-color: #ffffff;
        }

        /* En-tête imprimable */
        .header-table {
            width: 100%;
            border-bottom: 2px solid #0072bc;
            padding-bottom: 10px;
            margin-bottom: 15px;
        }

        .header-title {
            font-size: 18px;
            font-weight: bold;
            color: #0072bc;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .header-subtitle {
            font-size: 11px;
            color: #64748b;
            margin-top: 3px;
        }

        .meta-box {
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 4px;
            padding: 8px 12px;
            margin-bottom: 15px;
        }

        .meta-table {
            width: 100%;
        }

        .meta-table td {
            font-size: 10px;
            color: #334155;
            padding: 2px 5px;
        }

        .meta-label {
            font-weight: bold;
            color: #0072bc;
        }

        /* Cartes de statistiques */
        .stats-table {
            width: 100%;
            margin-bottom: 15px;
        }

        .stat-card {
            background-color: #f1f5f9;
            border-radius: 4px;
            padding: 8px;
            text-align: center;
        }

        .stat-number {
            font-size: 15px;
            font-weight: bold;
            color: #0072bc;
        }

        .stat-label {
            font-size: 9px;
            color: #64748b;
            text-transform: uppercase;
        }

        /* Groupes par secteurs */
        .sector-header {
            background-color: #0072bc;
            color: #ffffff;
            font-size: 12px;
            font-weight: bold;
            padding: 6px 10px;
            border-radius: 3px;
            margin-top: 15px;
            margin-bottom: 8px;
            text-transform: uppercase;
        }

        .activity-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }

        .activity-table th {
            background-color: #f1f5f9;
            color: #475569;
            font-size: 9px;
            font-weight: bold;
            text-transform: uppercase;
            text-align: left;
            padding: 6px;
            border: 1px solid #cbd5e1;
        }

        .activity-table td {
            padding: 6px;
            font-size: 10px;
            border: 1px solid #e2e8f0;
            vertical-align: top;
        }

        .activity-table tr:nth-child(even) {
            background-color: #f8fafc;
        }

        .badge-status {
            display: inline-block;
            padding: 2px 6px;
            font-size: 9px;
            font-weight: bold;
            border-radius: 10px;
            text-transform: capitalize;
        }

        .badge-cloturee {
            background-color: #dcfce7;
            color: #166534;
        }

        .badge-encours {
            background-color: #fef9c3;
            color: #854d0e;
        }

        /* Pied de page fixe pour impression A4 */
        .footer-table {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            width: 100%;
            border-top: 1px solid #cbd5e1;
            padding-top: 5px;
            font-size: 8px;
            color: #94a3b8;
        }

        .page-number:before {
            content: "Page " counter(page);
        }
    </style>
</head>
<body>

    <!-- En-tête -->
    <table class="header-table">
        <tr>
            <td style="width: 70%;">
                <div class="header-title">Portail de Rapportage des Partenaires</div>
                <div class="header-subtitle">Rapport Synthétique des Activités Opérationnelles</div>
            </td>
            <td style="width: 30%; text-align: right;">
                <div style="font-size: 9px; color: #64748b;">Généré le : {{ $exportDate }}</div>
                <div style="font-size: 10px; font-weight: bold; color: #0072bc;">{{ $exporterName }}</div>
            </td>
        </tr>
    </table>

    <!-- Métadonnées d'exportation -->
    <div class="meta-box">
        <table class="meta-table">
            <tr>
                <td style="width: 33%;"><span class="meta-label">Période du rapport :</span> {{ $dateDebut }} au {{ $dateFin }}</td>
                <td style="width: 33%;"><span class="meta-label">Organisation ciblée :</span> {{ $organisationName }}</td>
                <td style="width: 34%;"><span class="meta-label">Nombre d'activités :</span> {{ $totalActivites }}</td>
            </tr>
        </table>
    </div>

    <!-- Statistiques Globales -->
    <table class="stats-table">
        <tr>
            <td style="width: 33%;">
                <div class="stat-card">
                    <div class="stat-number">{{ $totalActivites }}</div>
                    <div class="stat-label">Activités Totales</div>
                </div>
            </td>
            <td style="width: 33%;">
                <div class="stat-card">
                    <div class="stat-number">{{ number_format($totalPersonnes, 0, ',', ' ') }}</div>
                    <div class="stat-label">Personnes Touchées</div>
                </div>
            </td>
            <td style="width: 34%;">
                <div class="stat-card">
                    <div class="stat-number">{{ number_format($totalMenages, 0, ',', ' ') }}</div>
                    <div class="stat-label">Ménages Assistés</div>
                </div>
            </td>
        </tr>
    </table>

    <!-- Activités regroupées par secteur -->
    @forelse($groupedActivites as $secteurNom => $activites)
        <div class="sector-header">
            Secteur : {{ $secteurNom }} ({{ count($activites) }} activité(s))
        </div>

        <table class="activity-table">
            <thead>
                <tr>
                    <th style="width: 12%;">Date</th>
                    <th style="width: 28%;">Intitulé & Description</th>
                    <th style="width: 18%;">Organisation</th>
                    <th style="width: 16%;">Localités</th>
                    <th style="width: 14%;">Bénéficiaires</th>
                    <th style="width: 12%;">Statut</th>
                </tr>
            </thead>
            <tbody>
                @foreach($activites as $act)
                    <tr>
                        <td>{{ $act->date_activite->format('d/m/Y') }}</td>
                        <td>
                            <strong>{{ $act->intitule }}</strong>
                            @if($act->description)
                                <div style="font-size: 8px; color: #64748b; margin-top: 2px;">{{ Str::limit($act->description, 90) }}</div>
                            @endif
                        </td>
                        <td>{{ optional(optional($act->createur)->organisation)->denomination ?? 'N/A' }}</td>
                        <td>{{ $act->localites ?? 'N/A' }}</td>
                        <td>
                            <div><strong>{{ number_format($act->nbre_personnes ?? 0, 0, ',', ' ') }}</strong> pers.</div>
                            <div style="font-size: 8px; color: #64748b;">{{ number_format($act->nbre_menage ?? 0, 0, ',', ' ') }} mén.</div>
                        </td>
                        <td style="text-align: center;">
                            @if($act->statut === 'clôturée')
                                <span class="badge-status badge-cloturee">Clôturée</span>
                            @else
                                <span class="badge-status badge-encours">En cours</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @empty
        <div style="text-align: center; padding: 30px; color: #64748b;">
            Aucune activité enregistrée sur la période sélectionnée.
        </div>
    @endforelse

    <!-- Pied de page -->
    <table class="footer-table">
        <tr>
            <td style="width: 40%;">Portail de Rapportage des Partenaires &bull; Document confidentiel</td>
            <td style="width: 30%; text-align: center;">Exporté par {{ $exporterName }}</td>
            <td style="width: 30%; text-align: right;" class="page-number"></td>
        </tr>
    </table>

</body>
</html>
