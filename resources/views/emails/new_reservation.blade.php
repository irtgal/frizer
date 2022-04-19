<!DOCTYPE html>
<html>
<head>
</head>
<body>

    <div style="width: 100%; display: grid; text-align: center; background: rgb(210,210,210);padding: 20px 0px; font-family: Arial, sans-serif;">

    <h1 style="color: black">Nova rezervacija</h1>

    <div style="color: black;">Termin</div>
    <h3 style="margin-top: 0px;color: black;">{{ $pretty_time }}</h3>

    <div style="color: black;">Rezerviral</div>
    <h3 style="margin-top: 0px;color: black;">{{ $name }}</h3>

    <div style="color: black;">Storitev</div>
    <h3 style="margin-top: 0px;color: black;">{{ $type_name }}</h3>

    <div style="color: black;">Cena</div>
    <h3 style="margin-top: 0px;color: black;">{{ $type_price }}€</h3>

    <div style="color: black;">Email</div>
    <h3 style="margin-top: 0px;color: black;">{{ $contact }}</h3>

    <br>
    <small>Rezervirano {{date('d.m.Y')}} ob {{date('h:i')}}</small>
    </div>

</body>
</html>
