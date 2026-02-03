<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Certificat - {{ $certificat->numero_certificat }}</title>
    <style>
        /* ============================================
           CERTIFICAT PREMIUM - COLIBRI LITTÉRAIRE
           Design: Premium avec illustration de fond
           ============================================ */

        @page {
            margin: 0;
            size: A4 landscape;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            width: 297mm;
            height: 210mm;
            position: relative;
            background: linear-gradient(135deg, #FDF9F0 0%, #FFF8E7 25%, #FFFDF5 50%, #FFF8E7 75%, #FDF9F0 100%);
            color: #1a1a1a;
        }

        /* ========== FOND ILLUSTRÉ PREMIUM ========== */

        /* Grande rosace centrale */
        .bg-rosace-main {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 200mm;
            height: 200mm;
            border: 1px solid rgba(201, 162, 39, 0.06);
            border-radius: 50%;
        }

        .bg-rosace-2 {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 180mm;
            height: 180mm;
            border: 1px solid rgba(201, 162, 39, 0.05);
            border-radius: 50%;
        }

        .bg-rosace-3 {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 160mm;
            height: 160mm;
            border: 1px solid rgba(201, 162, 39, 0.06);
            border-radius: 50%;
        }

        .bg-rosace-4 {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 140mm;
            height: 140mm;
            border: 1px solid rgba(201, 162, 39, 0.05);
            border-radius: 50%;
        }

        .bg-rosace-5 {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 120mm;
            height: 120mm;
            border: 1px solid rgba(201, 162, 39, 0.06);
            border-radius: 50%;
        }

        .bg-rosace-6 {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 100mm;
            height: 100mm;
            border: 1px solid rgba(201, 162, 39, 0.05);
            border-radius: 50%;
        }

        /* Motifs guilloché coins */
        .guilloche-corner {
            position: absolute;
            width: 80mm;
            height: 80mm;
            overflow: hidden;
        }

        .guilloche-tl { top: 0; left: 0; }
        .guilloche-tr { top: 0; right: 0; transform: scaleX(-1); }
        .guilloche-bl { bottom: 0; left: 0; transform: scaleY(-1); }
        .guilloche-br { bottom: 0; right: 0; transform: scale(-1, -1); }

        .guilloche-corner .arc {
            position: absolute;
            border: 1px solid rgba(201, 162, 39, 0.08);
            border-radius: 50%;
        }

        .guilloche-corner .arc-1 { width: 160mm; height: 160mm; top: -80mm; left: -80mm; }
        .guilloche-corner .arc-2 { width: 140mm; height: 140mm; top: -70mm; left: -70mm; }
        .guilloche-corner .arc-3 { width: 120mm; height: 120mm; top: -60mm; left: -60mm; }
        .guilloche-corner .arc-4 { width: 100mm; height: 100mm; top: -50mm; left: -50mm; }
        .guilloche-corner .arc-5 { width: 80mm; height: 80mm; top: -40mm; left: -40mm; }
        .guilloche-corner .arc-6 { width: 60mm; height: 60mm; top: -30mm; left: -30mm; }

        /* Lignes décoratives diagonales subtiles */
        .diagonal-lines {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: repeating-linear-gradient(
                45deg,
                transparent,
                transparent 20mm,
                rgba(201, 162, 39, 0.015) 20mm,
                rgba(201, 162, 39, 0.015) 20.5mm
            );
        }

        /* Étoile centrale subtile */
        .star-pattern {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 60mm;
            height: 60mm;
        }

        .star-line {
            position: absolute;
            top: 50%;
            left: 0;
            width: 100%;
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(201, 162, 39, 0.08), transparent);
            transform-origin: center;
        }

        .star-line-1 { transform: translateY(-50%) rotate(0deg); }
        .star-line-2 { transform: translateY(-50%) rotate(30deg); }
        .star-line-3 { transform: translateY(-50%) rotate(60deg); }
        .star-line-4 { transform: translateY(-50%) rotate(90deg); }
        .star-line-5 { transform: translateY(-50%) rotate(120deg); }
        .star-line-6 { transform: translateY(-50%) rotate(150deg); }

        /* ========== BORDURES ÉLÉGANTES ========== */

        .border-outer {
            position: absolute;
            top: 5mm;
            left: 5mm;
            right: 5mm;
            bottom: 5mm;
            border: 3px solid #C9A227;
            z-index: 1;
        }

        .border-inner {
            position: absolute;
            top: 10mm;
            left: 10mm;
            right: 10mm;
            bottom: 10mm;
            border: 2px solid #0A1628;
            z-index: 1;
        }

        /* Coins décoratifs élaborés */
        .corner-design {
            position: absolute;
            width: 30mm;
            height: 30mm;
            z-index: 2;
        }

        .corner-design-tl { top: 10mm; left: 10mm; }
        .corner-design-tr { top: 10mm; right: 10mm; }
        .corner-design-bl { bottom: 10mm; left: 10mm; }
        .corner-design-br { bottom: 10mm; right: 10mm; }

        .corner-design .corner-line-h {
            position: absolute;
            top: 0;
            height: 4px;
            background: #C9A227;
        }

        .corner-design .corner-line-v {
            position: absolute;
            left: 0;
            width: 4px;
            background: #C9A227;
        }

        .corner-design-tl .corner-line-h { left: 0; width: 25mm; }
        .corner-design-tl .corner-line-v { top: 0; height: 25mm; }

        .corner-design-tr .corner-line-h { right: 0; width: 25mm; }
        .corner-design-tr .corner-line-v { right: 0; left: auto; top: 0; height: 25mm; }

        .corner-design-bl .corner-line-h { left: 0; width: 25mm; bottom: 0; top: auto; }
        .corner-design-bl .corner-line-v { bottom: 0; top: auto; height: 25mm; }

        .corner-design-br .corner-line-h { right: 0; width: 25mm; bottom: 0; top: auto; }
        .corner-design-br .corner-line-v { right: 0; left: auto; bottom: 0; top: auto; height: 25mm; }

        /* Points décoratifs aux coins */
        .corner-dot {
            position: absolute;
            width: 6mm;
            height: 6mm;
            background: #C9A227;
            border-radius: 50%;
            z-index: 3;
        }

        .corner-dot-tl { top: 8mm; left: 8mm; }
        .corner-dot-tr { top: 8mm; right: 8mm; }
        .corner-dot-bl { bottom: 8mm; left: 8mm; }
        .corner-dot-br { bottom: 8mm; right: 8mm; }

        .corner-dot-inner {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 3mm;
            height: 3mm;
            background: #FDF9F0;
            border-radius: 50%;
        }

        /* Lignes horizontales décoratives */
        .h-line-top {
            position: absolute;
            top: 14mm;
            left: 45mm;
            right: 45mm;
            height: 1px;
            background: linear-gradient(90deg, transparent, #C9A227 20%, #C9A227 80%, transparent);
            z-index: 2;
        }

        .h-line-bottom {
            position: absolute;
            bottom: 14mm;
            left: 45mm;
            right: 45mm;
            height: 1px;
            background: linear-gradient(90deg, transparent, #C9A227 20%, #C9A227 80%, transparent);
            z-index: 2;
        }

        /* ========== EN-TÊTE ========== */

        .header {
            position: absolute;
            top: 20mm;
            left: 0;
            right: 0;
            text-align: center;
            z-index: 10;
        }

        .logos-wrapper {
            display: inline-block;
        }

        .logo-item {
            display: inline-block;
            vertical-align: middle;
            margin: 0 12mm;
        }

        .logo {
            height: 50px;
            width: auto;
            max-width: 150px;
        }

        .logo-asso {
            height: 60px;
            width: auto;
            max-width: 170px;
        }

        /* ========== TITRE PRINCIPAL ========== */

        .title-section {
            position: absolute;
            top: 48mm;
            left: 0;
            right: 0;
            text-align: center;
            z-index: 10;
        }

        .certificate-title {
            font-size: 28pt;
            font-weight: bold;
            color: #0A1628;
            letter-spacing: 8px;
            text-transform: uppercase;
        }

        .title-underline {
            width: 80mm;
            height: 3px;
            background: linear-gradient(90deg, transparent, #C9A227, transparent);
            margin: 4mm auto 0 auto;
        }

        /* ========== CONTENU PRINCIPAL ========== */

        .content-section {
            position: absolute;
            top: 75mm;
            left: 40mm;
            right: 40mm;
            text-align: justify;
            z-index: 10;
        }

        .content-paragraph {
            font-size: 12pt;
            color: #333;
            line-height: 1.9;
            text-align: justify;
        }

        .recipient-name {
            font-weight: bold;
            color: #0A1628;
        }

        .formation-title {
            font-weight: bold;
            color: #0A1628;
            font-style: italic;
        }

        .score-value {
            font-weight: bold;
            color: #0A1628;
        }

        /* ========== PIED DE PAGE ========== */

        .footer-section {
            position: absolute;
            bottom: 22mm;
            left: 25mm;
            right: 25mm;
            z-index: 10;
        }

        .footer-table {
            width: 100%;
            border-collapse: collapse;
        }

        .footer-table td {
            vertical-align: bottom;
            padding: 0;
        }

        .footer-left {
            width: 50%;
            text-align: left;
        }

        .footer-right {
            width: 50%;
            text-align: right;
        }

        .date-location {
            font-size: 10pt;
            color: #333;
            line-height: 1.5;
        }

        .date-location strong {
            color: #0A1628;
        }

        .stamp-signature-table {
            display: inline-table;
            border-collapse: collapse;
        }

        .stamp-signature-table td {
            vertical-align: bottom;
            padding: 0 8mm;
        }

        .stamp-cell {
            text-align: center;
        }

        .signature-cell {
            text-align: center;
        }

        .stamp-image {
            height: 100px;
            width: auto;
        }

        .signature-image {
            height: 80px;
            width: auto;
        }

        .signature-line {
            width: 55mm;
            height: 1px;
            background: #0A1628;
            margin: 0 auto 3mm auto;
        }

        .signer-title {
            font-size: 10pt;
            font-weight: bold;
            color: #0A1628;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-top: 2mm;
        }

        .signer-name {
            font-size: 11pt;
            color: #333;
            margin-top: 1mm;
        }

    </style>
</head>
<body>
    <!-- ========== FOND ILLUSTRÉ ========== -->

    <!-- Lignes diagonales subtiles -->
    <div class="diagonal-lines"></div>

    <!-- Rosace centrale -->
    <div class="bg-rosace-main"></div>
    <div class="bg-rosace-2"></div>
    <div class="bg-rosace-3"></div>
    <div class="bg-rosace-4"></div>
    <div class="bg-rosace-5"></div>
    <div class="bg-rosace-6"></div>

    <!-- Étoile centrale -->
    <div class="star-pattern">
        <div class="star-line star-line-1"></div>
        <div class="star-line star-line-2"></div>
        <div class="star-line star-line-3"></div>
        <div class="star-line star-line-4"></div>
        <div class="star-line star-line-5"></div>
        <div class="star-line star-line-6"></div>
    </div>

    <!-- Guilloché dans les coins -->
    <div class="guilloche-corner guilloche-tl">
        <div class="arc arc-1"></div>
        <div class="arc arc-2"></div>
        <div class="arc arc-3"></div>
        <div class="arc arc-4"></div>
        <div class="arc arc-5"></div>
        <div class="arc arc-6"></div>
    </div>
    <div class="guilloche-corner guilloche-tr">
        <div class="arc arc-1"></div>
        <div class="arc arc-2"></div>
        <div class="arc arc-3"></div>
        <div class="arc arc-4"></div>
        <div class="arc arc-5"></div>
        <div class="arc arc-6"></div>
    </div>
    <div class="guilloche-corner guilloche-bl">
        <div class="arc arc-1"></div>
        <div class="arc arc-2"></div>
        <div class="arc arc-3"></div>
        <div class="arc arc-4"></div>
        <div class="arc arc-5"></div>
        <div class="arc arc-6"></div>
    </div>
    <div class="guilloche-corner guilloche-br">
        <div class="arc arc-1"></div>
        <div class="arc arc-2"></div>
        <div class="arc arc-3"></div>
        <div class="arc arc-4"></div>
        <div class="arc arc-5"></div>
        <div class="arc arc-6"></div>
    </div>

    <!-- ========== BORDURES ========== -->
    <div class="border-outer"></div>
    <div class="border-inner"></div>

    <!-- Coins décoratifs -->
    <div class="corner-design corner-design-tl">
        <div class="corner-line-h"></div>
        <div class="corner-line-v"></div>
    </div>
    <div class="corner-design corner-design-tr">
        <div class="corner-line-h"></div>
        <div class="corner-line-v"></div>
    </div>
    <div class="corner-design corner-design-bl">
        <div class="corner-line-h"></div>
        <div class="corner-line-v"></div>
    </div>
    <div class="corner-design corner-design-br">
        <div class="corner-line-h"></div>
        <div class="corner-line-v"></div>
    </div>

    <!-- Points dorés aux coins -->
    <div class="corner-dot corner-dot-tl"><div class="corner-dot-inner"></div></div>
    <div class="corner-dot corner-dot-tr"><div class="corner-dot-inner"></div></div>
    <div class="corner-dot corner-dot-bl"><div class="corner-dot-inner"></div></div>
    <div class="corner-dot corner-dot-br"><div class="corner-dot-inner"></div></div>

    <!-- Lignes horizontales -->
    <div class="h-line-top"></div>
    <div class="h-line-bottom"></div>

    <!-- ========== EN-TÊTE ========== -->
    <div class="header">
        <div class="logos-wrapper">
            @php
                $logoAsso = public_path('img/asso.png');
                $logoColibri = public_path('img/LOGO-COLIBRI-LITTERAIRE.png');
                $logoOif = public_path('img/Logo_OIF.png');
            @endphp
            <div class="logo-item">
                @if(file_exists($logoAsso))
                    <img src="{{ $logoAsso }}" alt="ONG Écrivains Humanistes" class="logo-asso">
                @endif
            </div>
            <div class="logo-item">
                @if(file_exists($logoColibri))
                    <img src="{{ $logoColibri }}" alt="Colibri Littéraire" class="logo">
                @endif
            </div>
            <div class="logo-item">
                @if(file_exists($logoOif))
                    <img src="{{ $logoOif }}" alt="OIF" class="logo">
                @endif
            </div>
        </div>
    </div>

    <!-- ========== TITRE ========== -->
    <div class="title-section">
        <div class="certificate-title">Attestation de réussite</div>
        <div class="title-underline"></div>
    </div>

    <!-- ========== CONTENU ========== -->
    <div class="content-section">
        <p class="content-paragraph">
            <span class="recipient-name">{{ $certificat->nom_manuel }}</span> a suivi avec succès et complété la formation <span class="formation-title">« {{ $formation->titre }} »</span> diffusée par l'ONG Écrivains Humanistes à travers la plateforme Colibri Littéraire, avec le soutien de l'Organisation Internationale de la Francophonie (OIF) dans le cadre du dispositif FORCE et a obtenu la note de <span class="score-value">{{ $certificat->note_obtenue }}/100</span>. Ce certificat lui est délivré en reconnaissance de son engagement et de sa persévérance.
        </p>
    </div>

    <!-- ========== PIED DE PAGE ========== -->
    <div class="footer-section">
        <table class="footer-table">
            <tr>
                <td class="footer-left">
                    <div class="date-location">
                        <strong>Fait à {{ $certificat->lieu_delivrance ?? 'Cotonou' }}</strong><br>
                        Le {{ $certificat->date_delivrance ? $certificat->date_delivrance->format('d/m/Y') : now()->format('d/m/Y') }}
                    </div>
                </td>
                <td class="footer-right">
                    <table class="stamp-signature-table">
                        <tr>
                            <td class="stamp-cell">
                                @if(isset($cachetPath) && $cachetPath && file_exists($cachetPath))
                                    <img src="{{ $cachetPath }}" alt="Cachet officiel" class="stamp-image">
                                @endif
                            </td>
                            <td class="signature-cell">
                                @if(isset($signaturePath) && $signaturePath && file_exists($signaturePath))
                                    <img src="{{ $signaturePath }}" alt="Signature" class="signature-image">
                                @else
                                    <div class="signature-line"></div>
                                @endif
                                <div class="signer-title">DIRECTEUR EXÉCUTIF</div>
                                <div class="signer-name">{{ $certificat->signataire_nom ?? 'SEGNIGBINDE A. Camille' }}</div>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </div>
</body>
</html>
