<!DOCTYPE html>
<html>
<head>
</head>
<body>

    <div style="width: 100%; display: grid; text-align: center; background: #d9534f; color: white; padding: 20px 0px; font-family: Arial, sans-serif;">
    <h1 style="margin-bottom:5px; color: white;">Preklic rezervacije</h1>
    <p style="margin-top: 0px; color: white">Gospod frizer je odpovedal Vašo rezervacijo</p>

    <div style="color:rgb(210,210,210)">Termin</div>
    <h3 style="margin-top: 0px;color: white;">{{ $pretty_time }}</h3>

    <div style="color:rgb(210,210,210)">Rezerviral</div>
    <h3 style="margin-top: 0px;color: white;">{{ $name }}</h3>

    <div style="color:rgb(210,210,210)">Storitev</div>
    <h3 style="margin-top: 0px;color: white;">{{ $type_name }}</h3>

    <div style="color:rgb(210,210,210)">Cena</div>
    <h3 style="margin-top: 0px;color: white;">{{ $type_price }}€</h3>

    </div>

</body>
</html>
