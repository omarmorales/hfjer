@component('mail::message')
# Hola {{ $name }},

Se ha actualizado tu información.

Tu usuario es: {{ $email }}

Contraseña: {{ $password }}

@component('mail::button', ['url' => URL::to('/')])
Ir a la app
@endcomponent

Saludos,<br>
{{ config('app.name') }}
@endcomponent
