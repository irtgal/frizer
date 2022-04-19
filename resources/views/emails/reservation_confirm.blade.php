<div style="width: 100%; display: grid; text-align: center; background: rgb(210,210,210);padding: 0px 20px; font-family: Arial, sans-serif;">
<h1>Potrditev rezervacije</h1>
<span>Termin</span>
<h3 style="margin-top: 0px;">{{ $pretty_time }}</h3>

<span>Rezerviral</span>
<h3 style="margin-top: 0px;">{{ $name }}</h3>

<span>Storitev</span>
<h3 style="margin-top: 0px;">{{ $type_name }}</h3>

<span>Cena</span>
<h3 style="margin-top: 0px;">{{ $type_price }}€</h3>

<span>Email</span>
<h3 style="margin-top: 0px;">{{ $contact }}</h3>

<br>
<small>Rezervirano {{date('d.m.Y')}} ob {{date('h:i')}}</small>
</div>
