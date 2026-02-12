<x-mail::message>
# Uw offerte is gereed

Beste {{ $quote->customer->name }},

Hartelijk dank voor uw interesse.
Op basis van uw aanvraag hebben wij een offerte voor u opgesteld.

---

### 📄 Offerte-overzicht

<x-mail::table>
    | | |
    |---|---|
    | Offertenummer | {{ $quote->id }} |
    | Bedrag | € {{ number_format($quote->total_amount, 2, ',', '.') }} |
    @if ($quote->valid_until)
        | Geldig tot | {{ $quote->valid_until }} |
    @endif
</x-mail::table>

@if ($quote->url)
    De offerte is als **PDF bijgevoegd** in deze e-mail.
@endif

---

### Wat wilt u doen?

<x-mail::button :url="$approveUrl" color="success">
    Offerte goedkeuren
</x-mail::button>

<x-mail::button :url="$rejectUrl" color="error">
    Offerte afwijzen
</x-mail::button>

---

Met vriendelijke groet,
**Barroc Intens Team**
</x-mail::message>
