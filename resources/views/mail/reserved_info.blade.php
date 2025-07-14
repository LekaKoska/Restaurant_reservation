<x-mail::message>
#   Thank you

    Your reservation has been accepted!
    Below this is your information about reservation:

    Table number: {{$data['table_id']}}
    Guest number: {{$data['guest_number']}}
    Time: {{$data['reservation_date']}}
    Reserved by: {{$data['name']}}



Thanks,<br>
Restaurant Leka
</x-mail::message>
