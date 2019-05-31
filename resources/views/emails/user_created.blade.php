@component('mail::message')
# Hola {{ $name }},

Se ha creado un usuario para ti en la aplicacion de la herramienta YTT.

Tu usuario es: {{ $email }}

Contraseña: {{ $password }}

@component('mail::button', ['url' => URL::to('/')])
Ir a la app
@endcomponent

Saludos,<br>
{{ config('app.name') }}
@endcomponent
