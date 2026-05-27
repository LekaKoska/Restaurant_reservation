<x-mail::message>
    {{$reservation->user->name}}, your reservation starts in one hour.
    Please be on time.
    Hope to see you soon,

    Regrades,

    Leka Restaurant.

Table number: {{$reservation->table_id}}
Guest number: {{$reservation->guest_number}}
Start: {{$reservation->start_date->format('d.m.Y H:i')}}
End: {{$reservation->end_date->format('d.m.Y H:i')}}
Reserved by: {{$reservation->user->name}}

</x-mail::message>
