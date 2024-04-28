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
    Telefon: {{ $details['phone'] }}
    <br>
    <br>
    <b>Numar rezervare:</b> {{ $details['order_id'] }}
    <br>
    <b>Autovehicul rezervat:</b> {{ $details['car_name'] }}
    <br>
    <b>Numar de inmatriculare:</b> {{ $details['car_number'] }}
    <br>
    <b>Start rezervare:</b> {{ $details['pick_up_dateTime'] }}
    <br>
    <b>Final rezervare:</b> {{ $details['return_dateTime'] }}
    <br>
    <b>Numar de zile rezervate:</b> {{ $details['nr_of_days'] }}
    <br>
    <b>Locatie ridicare / predare autovehicol:</b> {{ $details['location'] }}
    <br>
    <br>
    <b>Detalii comandă închiriere:</b>
    <table style="width:100%">
        @foreach ($details['buyOptions'] ?? [] as $key => $value)
            @if (isset($value['showPriceDetails']) && $value['showPriceDetails'])
                <tr>
                    <td>{{ $value['nume'] }}</td>
                    <td>{{ $details['nr_of_days'] }} {{ $details['nr_of_days'] === 1 ? 'Zi' : 'Zile' }} x
                        {{ $value['pret'] }} Lei / Zi = <b>{{ $details['nr_of_days'] * (float) $value['pret'] }} Lei</b></td>
                </tr>
            @else
                <tr>
                    <td>{{ $value['nume'] }}</td>
                    <td><b>{{ (float) $value['pret'] }} Lei</b></td>
                </tr>
            @endif
        @endforeach
        <tr>
            <td>Total</td>
            <td><b>{{ $details['price'] }} Lei</b></td>
        </tr>
    </table>
    <br>
    Puteti anula comanda din panoul de comanda pana la data de: <b>{{ $details['pick_up_dateTime'] }}</b>.
    <br>
    Link catre panoul de comanda: <a href="https://starentinchirieriauto.ro/dashboard">Link</a>.
    <br>
    <br>
    Vă mulțumim.
</body>

</html>
