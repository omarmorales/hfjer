@component('mail::message')
# Hola {{ $name }},

Se ha creado un usuario para ti en la aplicacion de la herramienta YTT.

Tu usuario es: {{ $email }}

Contraseña: {{ $password }}

@component('mail::button', ['url' => 'localhost:8000'])
Ir a la app
@endcomponent

Saludos,<br>
{{ config('app.name') }}
@endcomponent
