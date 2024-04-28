<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8" />
    <style>
        {!! $css ?? '' !!}
    </style>
</head>

<body>
    <b>Checkout Email</b>
    <br>
    Nume si Prenume: {{ $details['nameSiPrenume'] }}
    <br>
    Email: {{ $details['email'] }}
    <br>
    <br>
    S-a anulat rezervarea autovehiculului <b>{{ $details['car_name'] }}</b> cu numarul de înmatriculare
    <b>{{ $details['car_number'] }}</b> și numarul comandă: <b>{{ $details['order_id'] }}</b> în valoare de
    <b>{{ $details['price'] }}</b>
    Lei din perioada
    <b>{{ $details['pick_up_dateTime'] }}</b> /
    <b>{{ $details['return_dateTime'] }}</b>(<b>{{ $details['nr_of_days'] }} 
        {{ (int) $details['nr_of_days'] === 1 ? 'Zi' : 'Zile' }}</b>) ce urma să
    fie realizată din punctul de lucru <b>{{ $details['location'] }}</b>.
    <br>
    <br>
    În cazul în care doriți să faceți altă comandă puteți accesa: <a
        href="https://starentinchirieriauto.ro/"><b>starentinchirieriauto.ro</b></a>.
    <br>
    <br>
    Vă mulțumim.
</body>

</html>
