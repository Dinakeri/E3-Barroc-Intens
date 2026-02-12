<x-mail::message>
# Uw factuur is verzonden

Beste {{ $invoice->customer->name }},

Wij hebben met groot genoegen uw factuur opgesteld. U vindt deze hieronder en als PDF-bijlage in deze e-mail. Gelieve de factuur zorgvuldig door te nemen en op tijd te betalen.

---

### 📋 Factuurgegevens

<x-mail::table>
    | Omschrijving | Details |
    |---|---|
    | **Factuurnummer** | {{ $invoice->id }} |
    | **Factuurdatum** | {{ $invoice->created_at->format('d-m-Y') }} |
    | **Vervaldatum** | {{ $invoice->valid_until }} |
    | **Totaalbedrag** | **€ {{ number_format($invoice->total_amount, 2, ',', '.') }}** |
</x-mail::table>

---

### 👤 Klantgegevens

**{{ $invoice->customer->name }}**
- E-mailadres: {{ $invoice->customer->email }}
- Telefoonnummer: {{ $invoice->customer->phone }}
- Adres: {{ $invoice->customer->street }} {{ $invoice->customer->house_number }}, {{ $invoice->customer->postcode }} {{ $invoice->customer->place }}

---

### 💰 Betaalopdracht

Wij verzoeken u vriendelijk het factuurbedrag van **€ {{ number_format($invoice->total_amount, 2, ',', '.') }}** voor **{{ \Carbon\Carbon::parse($invoice->valid_until)->format('d-m-Y') }}** over te maken naar:

**Rekeninghouder:** Barroc Intens
**IBAN:** NL91 ABNA 0417 1643 00
**Referentie:** Factuur #{{ $invoice->id }}

⚠️ *Gelieve het factuurnummer in de betaalreferentie op te nemen.*

---

### 📄 Bijgevoegde Documenten

- 📊 Factuur PDF ({{ $invoice->id }})

---

### Volgende Stappen

1. ✓ Controleer alle factuurgegeven zorgvuldig
2. ✓ Voer de betaling uit naar het hierboven vermelde rekeningnummer
3. ✓ Gebruik het factuurnummer als betaalreferentie

---

### Nog Vragen?

Mocht u vragen hebben over deze factuur of onze diensten, aarzel dan niet contact met ons op te nemen. Wij helpen u graag verder.

Met vriendelijke groet,

**Barroc Intens Team**
support@barrocintens.nl
+31 (0) 00 000 0000

---

*Dit is een automatisch gegenereerde e-mail. Gelieve niet op deze e-mail te antwoorden.*
</x-mail::message>
