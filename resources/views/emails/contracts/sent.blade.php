<x-mail::message>
# Uw contract en factuur zijn gereed

Beste {{ $contract->customer->name }},

Hartelijk dank voor uw interesse.
Wij hebben uw contract en de bijbehorende factuur opgesteld en voegen deze als bijlagen bij deze e-mail.

---

### 📋 Contract- en factuur-overzicht

<x-mail::table>
    | | |
    |---|---|
    | Contract-/Factuurnummer | {{ $contract->id }} |
    | Totaalbedrag | € {{ number_format($contract->total_amount, 2, ',', '.') }} |
    @if ($contract->valid_until)
        | Geldig tot | {{ $contract->valid_until }} |
    @endif
</x-mail::table>

**Bijgevoegde documenten:**
- 📄 Contract (PDF)
- 📊 Factuur (PDF)

---

### Volgende stappen

1. Leest u beide documenten aandachtig door
2. Ondertekent u het contract
3. Keurt u het contract en de factuur goed of keurt u deze af via onderstaande knoppen

<x-mail::button :url="$approveUrl" color="success">
    ✓ Contract & Factuur Goedkeuren
</x-mail::button>

<x-mail::button :url="$rejectUrl" color="error">
    ✗ Afkeuren
</x-mail::button>

---

Mocht u nog vragen hebben, neem gerust contact met ons op.

Met vriendelijke groet,
**Barroc Intens Team**
</x-mail::message>
