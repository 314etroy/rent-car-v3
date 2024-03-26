<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8" />
    <style>
        {!! $css ?? '' !!}
    </style>
</head>

<body>
    Nume si Prenume: {{ $details['nameSiPrenume'] }}
    <br>
    Email: {{ $details['email'] }}
    <br>
    Telefon: {{ $details['phone'] }}
    <br>
    Subiect: {{ $details['subject'] }}
    <br>
    Mesaj: {{ $details['mesaj'] }}
</body>

</html>
