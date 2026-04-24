<x-mail::message>
#   Thank you

    Your reservation has been accepted!
    Below this is your information about reservation:

    Table number: {{$reservation->table_id}}
    Guest number: {{$reservation->guest_number}}
    Start: {{$reservation->start_date->format('d.m.Y H:i')}}
    End: {{$reservation->end_date->format('d.m.Y H:i')}}
    Reserved by: {{$reservation->userReservations->name}}



Thanks,<br>
Restaurant ${APP_NAME}
</x-mail::message>
