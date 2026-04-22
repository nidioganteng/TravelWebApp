<x-mail::message>

# Payment Confirmed! 🎉

Hi **{{ $booking->user->name }}**,

Your booking has been confirmed and your payment was successfully processed. Below are your booking details.

---

## Booking Reference
**{{ $booking->booking_reference }}**
Booked on {{ $booking->created_at->format('d M Y, H:i') }}

---

## Tour Details

| | |
|---|---|
| **Tour** | {{ $booking->product->product_name }} |
| **Departure Date** | {{ \Carbon\Carbon::parse($booking->product->departure_date)->format('d M Y, H:i') }} |
@if($booking->product->departure_locations)
| **Departure Location** | {{ $booking->product->departure_locations }} |
@endif
| **Tickets** | {{ $booking->quantity }} ticket{{ $booking->quantity > 1 ? 's' : '' }} |

---

## Passenger List

| # | Name | Category |
|---|------|----------|
@foreach($booking->participants as $i => $participant)
| {{ $i + 1 }} | {{ $participant->name }} | {{ $participant->category }} |
@endforeach

---

## Payment Summary

| | |
|---|---|
| **Price per ticket** | € {{ number_format($booking->total_price / $booking->quantity, 2) }} |
| **Quantity** | {{ $booking->quantity }} ticket{{ $booking->quantity > 1 ? 's' : '' }} |
| **Total Paid** | **€ {{ number_format($booking->total_price, 2) }}** |

---

## Contact Information

- **Email:** {{ $booking->contact_email }}
- **Phone:** {{ $booking->contact_phone }}

<x-mail::button :url="route('profile.booking')" color="primary">
View My E-Ticket
</x-mail::button>

If you have any questions, feel free to contact us.

Thanks,
**Mijn Amor Travel**

</x-mail::message>
