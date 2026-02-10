<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <title>Contract #{{ $contract->id ?? ($quote->id ?? '') }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #2c3e50;
            line-height: 1.6;
            padding: 0;
            background: #f8f9fa;
        }

        .page {
            width: 210mm;
            height: 297mm;
            margin: 0 auto;
            padding: 30px 40px;
            background: white;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            page-break-after: always;
        }

        /* Header Section */
        .header-section {
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 3px solid #000;
        }

        .header-title {
            text-align: center;
            margin-bottom: 15px;
        }

        .header-title h1 {
            font-size: 28px;
            font-weight: 700;
            color: #000;
            letter-spacing: 1px;
            margin-bottom: 5px;
        }

        .contract-number {
            text-align: center;
            font-size: 12px;
            color: #666;
            margin-top: 8px;
        }

        .header-meta {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-top: 12px;
            font-size: 12px;
        }

        .meta-item {
            display: flex;
            justify-content: space-between;
        }

        .meta-label {
            font-weight: 600;
            color: #000;
            min-width: 100px;
        }

        .meta-value {
            color: #333;
        }

        /* Parties Section */
        .parties-section {
            margin-bottom: 25px;
            page-break-inside: avoid;
        }

        .section-title {
            font-size: 12px;
            font-weight: 700;
            color: white;
            background-color: #000;
            padding: 8px 12px;
            margin-bottom: 12px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .parties-container {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .party {
            background: #fff;
            padding: 15px;
            border-radius: 2px;
            border-left: 4px solid #FFD700;
            border: 1px solid #eee;
            border-left: 4px solid #FFD700;
        }

        .party-title {
            font-weight: 700;
            color: #000;
            font-size: 12px;
            margin-bottom: 10px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #FFD700;
        }

        .party-details {
            font-size: 11px;
            line-height: 1.6;
            color: #333;
        }

        .party-details p {
            margin: 0;
        }

        /* Items Table */
        .items-section {
            margin-bottom: 25px;
            page-break-inside: avoid;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 12px;
            font-size: 11px;
        }

        table thead {
            background-color: #000;
            color: white;
        }

        table th {
            padding: 10px;
            text-align: left;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-size: 10px;
        }

        table td {
            padding: 10px;
            border-bottom: 1px solid #eee;
        }

        table tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .text-right {
            text-align: right;
        }

        .total-row {
            background-color: #FFD700 !important;
            color: #000;
            font-weight: 600;
        }

        .total-row td {
            padding: 12px 10px;
            border: none;
        }

        /* Terms Section */
        .terms-section {
            margin-bottom: 25px;
            page-break-inside: avoid;
        }

        .terms-content {
            font-size: 11px;
            line-height: 1.6;
            color: #333;
            background: #f9f9f9;
            padding: 15px;
            border-radius: 2px;
            border-left: 4px solid #FFD700;
        }

        .terms-content p {
            margin-bottom: 8px;
        }

        .terms-content p:last-child {
            margin-bottom: 0;
        }

        /* Signature Section */
        .signature-section {
            margin-top: 30px;
            page-break-inside: avoid;
        }

        .signature-title {
            font-size: 12px;
            font-weight: 700;
            color: #000;
            margin-bottom: 20px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .signatures {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
        }

        .signature-block {
            text-align: center;
        }

        .signature-line {
            border-top: 2px solid #000;
            padding-top: 8px;
            margin-top: 40px;
            font-size: 11px;
            font-weight: 600;
            color: #000;
        }

        .signature-date {
            margin-top: 10px;
            font-size: 10px;
            color: #666;
        }

        /* Footer */
        footer {
            margin-top: 25px;
            padding-top: 15px;
            border-top: 2px solid #FFD700;
            text-align: center;
            font-size: 10px;
            color: #666;
        }

        .footer-text {
            margin: 3px 0;
        }

        @media print {
            body {
                background: white;
            }

            .page {
                box-shadow: none;
                width: 80%;
                margin: 0 auto;
                padding: 40px 50px;
            }
        }
    </style>
</head>

<body>
    <div class="page">
        <!-- Header Section -->
        <div class="header-section">
            <div class="header-title">
                <h1>DIENSTEN OVEREENKOMST</h1>
                <div class="contract-number">Contract #{{ $contract->id ?? ($quote->id ?? '') }}</div>
            </div>
            <div class="header-meta">
                <div class="meta-item">
                    <span class="meta-label">Datum:</span>
                    <span
                        class="meta-value">{{ optional($contract->created_at ?? $quote->created_at)->format('d-m-Y') }}</span>
                </div>
                <div class="meta-item">
                    <span class="meta-label">Status:</span>
                    <span class="meta-value">{{ ucfirst($contract->status ?? ($quote->status ?? 'pending')) }}</span>
                </div>
                <div class="meta-item">
                    <span class="meta-label">Startdatum:</span>
                    <span class="meta-value">{{ optional($contract->start_date)->format('d-m-Y') ?? '-' }}</span>
                </div>
                <div class="meta-item">
                    <span class="meta-label">Einddatum:</span>
                    <span class="meta-value">{{ optional($contract->end_date)->format('d-m-Y') ?? '-' }}</span>
                </div>
            </div>
        </div>

        <!-- Parties Section -->
        <div class="parties-section">
            <div class="section-title">Contractpartijen</div>
            <div class="parties-container">
                <div class="party">
                    <div class="party-title">Aanbieder</div>
                    <div class="party-details">
                        <p><strong>{{ config('app.name', 'Bedrijf') }}</strong></p>
                        <p>{{ config('app.address', 'Adres niet ingesteld') }}</p>
                        <p>{{ config('app.phone', 'Telefoonnummer niet ingesteld') }}</p>
                        <p>{{ config('app.email', 'E-mail niet ingesteld') }}</p>
                    </div>
                </div>

                @php
                    $c = $contract->customer ?? ($quote->customer ?? ($customer ?? null));
                @endphp

                <div class="party">
                    <div class="party-title">Klant</div>
                    <div class="party-details">
                        @if ($c)
                            <p><strong>{{ $c->name ?? ($c->company_name ?? '-') }}</strong></p>
                            <p>{{ $c->email ?? '-' }}</p>
                            <p>{{ $c->phone ?? '-' }}</p>
                            <p>
                                @php
                                    $addr = trim(
                                        ($c->street ?? '') . ' ' . ($c->house_number ?? '') . ', ' . ($c->place ?? ''),
                                    );
                                @endphp
                                {{ $addr ?: '-' }}
                            </p>
                        @else
                            <p>-</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Terms Section -->
        <div class="terms-section">
            <div class="section-title">Algemene Voorwaarden</div>
            <div class="terms-content">
                <p><strong>1. Betaling:</strong> Betaling dient plaats te vinden binnen 30 dagen na factuurdatum, tenzij
                    anders overeengekomen.</p>
                <p><strong>2. Levering:</strong> De diensten worden geleverd conform de afgesproken voorwaarden en
                    tijdstip.</p>
                <p><strong>3. Aansprakelijkheid:</strong> Aanbieder is niet aansprakelijk voor indirecte schade of
                    gevolgschade.</p>
                <p><strong>4. Intellectueel Eigendom:</strong> Alle rechten op het geleverde werk behoren toe aan
                    Aanbieder, tenzij anders schriftelijk overeengekomen.</p>
                <p><strong>5. Wijzigingen:</strong> Wijzigingen aan dit contract dienen schriftelijk overeengekomen en
                    ondertekend te worden.</p>
                <p><strong>6. Looptijd:</strong> Dit contract loopt van
                    {{ optional($contract->start_date)->format('d-m-Y') ?? '-' }} tot
                    {{ optional($contract->end_date)->format('d-m-Y') ?? '-' }}.</p>
            </div>
        </div>

        <!-- Items Section -->
        <div class="items-section">
            <div class="section-title">Diensten & Producten</div>
            @if ($quote->order->orderItems->count() > 0)
                <table>
                    <thead>
                        <tr>
                            <th style="width: 45%;">Beschrijving</th>
                            <th style="width: 15%; text-align: center;">Hoeveelheid</th>
                            <th style="width: 20%; text-align: right;">Eenheidsprijs</th>
                            <th style="width: 20%; text-align: right;">Totaal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($quote->order->orderItems as $item)
                            <tr>
                                <td>{{ $item->description ?? ($item->product->name ?? ($item->name ?? '-')) }}</td>
                                <td style="text-align: center;">{{ $item->quantity ?? 1 }}</td>
                                <td class="text-right">
                                    €{{ number_format($item->unit_price ?? ($item->price ?? 0), 2, ',', '.') }}</td>
                                <td class="text-right">
                                    €{{ number_format(($item->quantity ?? 1) * ($item->unit_price ?? ($item->price ?? 0)), 2, ',', '.') }}
                                </td>
                            </tr>
                        @endforeach
                        <tr class="total-row">
                            <td colspan="3">TOTAAL:</td>
                            <td class="text-right">€{{ number_format($quote->total_amount, 2, ',', '.') }}</td>
                        </tr>
                    </tbody>
                </table>
            @else
                <p style="color: #7f8c8d; font-style: italic;">Geen items gekoppeld aan dit contract.</p>
            @endif
        </div>

        <!-- Additional Services Section -->
        <div class="terms-section">
            <div class="section-title">Aanvullende Diensten</div>
            <div class="terms-content">
                <p><strong>Aanvullende Koffiemachines:</strong> Mocht de klant gedurende de looptijd van dit contract besluiten om aanvullende koffiemachines te bestellen, zal deze order rechtstreeks onder het huidige contract vallen. Dit betekent dat de aanvullende apparaten dezelfde contractlooptijd volgen als het originele contract en zullen eindigen op {{ optional($contract->end_date)->format('d-m-Y') ?? '-' }}.</p>
            </div>
        </div>

        <!-- Signature Section -->
        <div class="signature-section">
            <div class="signature-title">Handtekeningen</div>
            <div class="signatures">
                <div class="signature-block">
                    <div class="signature-line">_______________________</div>
                    <div class="signature-date">Aanbieder<br>Datum: _______________</div>
                </div>
                <div class="signature-block">
                    <div class="signature-line">_______________________</div>
                    <div class="signature-date">Klant<br>Datum: _______________</div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <footer>
            <div class="footer-text">Dank u wel voor het aangaan van deze overeenkomst met ons.</div>
            <div class="footer-text">Voor vragen of opmerkingen kunt u ons bereiken via support@company.example</div>
            <div class="footer-text">© {{ date('Y') }} - Alle rechten voorbehouden</div>
        </footer>
    </div>
</body>

</html>
