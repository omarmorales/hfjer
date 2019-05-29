@component('mail::message')
# Hay una duda sobre la app!

Usuario: {{ $user->name }} ({{ $user->email }})


Titulo: {{ $title }}

Descripcion: {{ $description }}

@component('mail::button', ['url' => 'http://localhost:8000'])
Ir a la app
@endcomponent

Saludos,<br>
{{ config('app.name') }}
@endcomponent
