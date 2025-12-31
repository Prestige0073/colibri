<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Certificat - {{ $certificat->numero_certificat }}</title>
    <style>
        @page {
            margin: 25px;
            size: A4 landscape;
        }

        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            margin: 0;
            padding: 0;
            background: white;
        }

        .certificate {
            width: 95%;
            margin: 0 auto;
            border: 5px solid #198754;
            padding: 15px;
        }

        .inner-border {
            border: 3px solid #ffc107;
            padding: 15px;
            background: white;
        }

        /* En-tête */
        .header {
            text-align: center;
            margin-bottom: 6px;
        }

        .logos {
            width: 100%;
            margin-bottom: 6px;
        }

        .logos table {
            width: 100%;
        }

        .logos td {
            width: 33.33%;
        }

        .logos td:first-child {
            text-align: left;
        }

        .logos td:last-child {
            text-align: right;
        }

        .logo {
            height: 32px;
        }

        /* Titre */
        .title {
            text-align: center;
            margin: 5px 0;
        }

        .title h1 {
            font-size: 30pt;
            color: #198754;
            text-transform: uppercase;
            letter-spacing: 5px;
            font-weight: bold;
            margin: 4px 0;
        }

        .subtitle {
            font-size: 12pt;
            color: #6c757d;
            font-style: italic;
            margin: 4px 0;
        }

        /* Contenu */
        .content {
            text-align: center;
            margin: 10px 0;
            padding: 0 35px;
        }

        .intro {
            font-size: 12pt;
            color: #333;
            margin: 5px 0;
        }

        .recipient-name {
            font-size: 20pt;
            color: #1976d2;
            font-weight: bold;
            margin: 6px 0;
            border-bottom: 3px solid #ffc107;
            display: inline-block;
            padding-bottom: 3px;
        }

        .text {
            font-size: 11pt;
            color: #333;
            margin: 4px 0;
            line-height: 1.4;
        }

        .formation-name {
            font-size: 15pt;
            color: #198754;
            font-weight: bold;
            margin: 6px 0;
            max-width: 85%;
            margin-left: auto;
            margin-right: auto;
            word-wrap: break-word;
        }

        .note-badge {
            display: inline-block;
            background: linear-gradient(135deg, #ffc107 0%, #ff9800 100%);
            color: white;
            padding: 6px 20px;
            border-radius: 16px;
            font-size: 17pt;
            font-weight: bold;
            margin: 6px 0;
        }

        .recognition {
            font-style: italic;
            color: #198754;
            font-size: 10pt;
            margin: 5px 0;
        }

        /* Pied de page */
        .footer {
            margin-top: 8px;
            border-top: 2px solid #dee2e6;
            padding-top: 6px;
        }

        .footer table {
            width: 100%;
        }

        .footer td {
            width: 33.33%;
            vertical-align: top;
            font-size: 9pt;
            color: #666;
            line-height: 1.5;
        }

        .footer td:first-child {
            text-align: left;
        }

        .footer td:nth-child(2) {
            text-align: center;
        }

        .footer td:last-child {
            text-align: right;
        }

        .signature-line {
            width: 80px;
            border-top: 2px solid #333;
            margin: 5px auto;
        }

        .signature-text {
            font-size: 8pt;
            color: #333;
            font-weight: bold;
            line-height: 1.3;
        }

        strong {
            font-weight: bold;
        }

        /* Filigrane */
        .watermark {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-45deg);
            font-size: 55pt;
            color: rgba(25, 135, 84, 0.04);
            font-weight: bold;
            z-index: -1;
        }
    </style>
</head>
<body>
    <div class="watermark">COLIBRI LITTÉRAIRE</div>

    <div class="certificate">
        <div class="inner-border">
            <!-- En-tête avec logos -->
            <div class="header">
                <div class="logos">
                    <table cellpadding="0" cellspacing="0">
                        <tr>
                            <td>
                                <img src="{{ public_path('img/LOGO-COLIBRI-LITTERAIRE.png') }}" alt="Colibri" class="logo">
                            </td>
                            <td></td>
                            <td>
                                <img src="{{ public_path('img/Logo_OIF.png') }}" alt="OIF" class="logo">
                            </td>
                        </tr>
                    </table>
                </div>

                <div class="title">
                    <h1>CERTIFICAT</h1>
                    <div class="subtitle">de Réussite et de Complétion</div>
                </div>
            </div>

            <!-- Contenu principal -->
            <div class="content">
                <div class="intro">Ce certificat atteste que</div>

                <div class="recipient-name">{{ $certificat->nom_manuel ?? $user->name }}</div>

                <div class="text">a suivi avec succès et complété la formation</div>

                <div class="formation-name">{{ $formation->titre }}</div>

                <div class="text">
                    organisée par <strong>Colibri Littéraire</strong><br>
                    avec le soutien de l'<strong>Organisation Internationale de la Francophonie (OIF)</strong><br>
                    dans le cadre du dispositif <strong>FORCE</strong>
                </div>

                <div class="text" style="margin-top: 10px;">et a obtenu la note de</div>

                <div class="note-badge">{{ $certificat->note_obtenue }}/100</div>

                <div class="recognition">En reconnaissance de son engagement et de sa persévérance</div>
            </div>

            <!-- Pied de page -->
            <div class="footer">
                <table cellpadding="0" cellspacing="0">
                    <tr>
                        <td>
                            <strong>Délivré le :</strong><br>
                            {{ $certificat->date_delivrance->format('d/m/Y') }}<br>
                            <br>
                            <strong>Lieu :</strong><br>
                            Cotonou, Bénin
                        </td>
                        <td>
                            <div class="signature-line"></div>
                            <div class="signature-text">
                                Directeur Exécutif<br>
                                Colibri Littéraire
                            </div>
                        </td>
                        <td>
                            <strong>N° {{ $certificat->numero_certificat }}</strong><br>
                            <br>
                            <strong>Vérification :</strong><br>
                            www.colibrilitteraire.org/verify
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
