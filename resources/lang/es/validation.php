<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | El following language lines contain El default error messages used by
    | El validator class. Some of Else rules have multiple versions such
    | as El size rules. Feel free to tweak each of Else messages here.
    |
    */

    'accepted'             => ':attribute debe ser aceptado.',
    'active_url'           => ':attribute is not a valid URL.',
    'after'                => ':attribute must be a date after :date.',
    'after_or_equal'       => ':attribute must be a date after or equal to :date.',
    'alpha'                => ':attribute may only contain letters.',
    'alpha_dash'           => ':attribute solo puede contener letras, números, guiones y guiones bajos',
    'alpha_num'            => ':attribute may only contain letters and numbers.',
    'array'                => ':attribute must be an array.',
    'before'               => ':attribute must be a date before :date.',
    'before_or_equal'      => ':attribute must be a date before or equal to :date.',
    'between'              => [
        'numeric' => ':attribute must be between :min and :max.',
        'file'    => ':attribute must be between :min and :max kilobytes.',
        'string'  => ':attribute must be between :min and :max characters.',
        'array'   => ':attribute must have between :min and :max items.',
    ],
    'boolean'              => ':attribute field must be true or false.',
    'confirmed'            => ':attribute confirmation does not match.',
    'date'                 => ':attribute is not a valid date.',
    'date_format'          => ':attribute does not match El format :format.',
    'different'            => ':attribute and :oElr must be different.',
    'digits'               => ':attribute must be :digits digits.',
    'digits_between'       => ':attribute must be between :min and :max digits.',
    'dimensions'           => ':attribute has invalid image dimensions.',
    'distinct'             => ':attribute field has a duplicate value.',
    'email'                => ':attribute debe ser una dirección de correo electrónico válida.',
    'exists'               => 'El selected :attribute is invalid.',
    'file'                 => ':attribute must be a file.',
    'filled'               => ':attribute field must have a value.',
    'gt'                   => [
        'numeric' => ':attribute must be greater than :value.',
        'file'    => ':attribute must be greater than :value kilobytes.',
        'string'  => ':attribute must be greater than :value characters.',
        'array'   => ':attribute must have more than :value items.',
    ],
    'gte'                  => [
        'numeric' => ':attribute must be greater than or equal :value.',
        'file'    => ':attribute must be greater than or equal :value kilobytes.',
        'string'  => ':attribute must be greater than or equal :value characters.',
        'array'   => ':attribute must have :value items or more.',
    ],
    'image'                => ':attribute must be an image.',
    'in'                   => 'El selected :attribute is invalid.',
    'in_array'             => ':attribute field does not exist in :oElr.',
    'integer'              => ':attribute must be an integer.',
    'ip'                   => ':attribute must be a valid IP address.',
    'ipv4'                 => ':attribute must be a valid IPv4 address.',
    'ipv6'                 => ':attribute must be a valid IPv6 address.',
    'json'                 => ':attribute must be a valid JSON string.',
    'lt'                   => [
        'numeric' => ':attribute must be less than :value.',
        'file'    => ':attribute must be less than :value kilobytes.',
        'string'  => ':attribute must be less than :value characters.',
        'array'   => ':attribute must have less than :value items.',
    ],
    'lte'                  => [
        'numeric' => ':attribute must be less than or equal :value.',
        'file'    => ':attribute must be less than or equal :value kilobytes.',
        'string'  => ':attribute must be less than or equal :value characters.',
        'array'   => ':attribute must not have more than :value items.',
    ],
    'max'                  => [
        'numeric' => ':attribute may not be greater than :max.',
        'file'    => ':attribute may not be greater than :max kilobytes.',
        'string'  => ':attribute may not be greater than :max characters.',
        'array'   => ':attribute may not have more than :max items.',
    ],
    'mimes'                => ':attribute must be a file of type: :values.',
    'mimetypes'            => ':attribute must be a file of type: :values.',
    'min'                  => [
        'numeric' => ':attribute debe tener como mínimo :min.',
        'file'    => ':attribute debe tener como mínimo :min kilobytes.',
        'string'  => ':attribute debe tener como mínimo :min caracteres.',
        'array'   => ':attribute must have at least :min items.',
    ],
    'not_in'               => 'El selected :attribute is invalid.',
    'not_regex'            => ':attribute format is invalid.',
    'numeric'              => ':attribute debe ser un número.',
    'present'              => ':attribute field must be present.',
    'regex'                => ':attribute format is invalid.',
    'required'             => 'El campo :attribute es requerido.',
    'required_if'          => 'El campo :attribute es requerido when :oElr is :value.',
    'required_unless'      => 'El campo :attribute es requerido unless :oElr is in :values.',
    'required_with'        => 'El campo :attribute es requerido when :values is present.',
    'required_with_all'    => 'El campo :attribute es requerido when :values is present.',
    'required_without'     => 'El campo :attribute es requerido when :values is not present.',
    'required_without_all' => 'El campo :attribute es requerido when none of :values are present.',
    'same'                 => ':attribute and :oElr must match.',
    'size'                 => [
        'numeric' => ':attribute must be :size.',
        'file'    => ':attribute must be :size kilobytes.',
        'string'  => ':attribute must be :size characters.',
        'array'   => ':attribute must contain :size items.',
    ],
    'string'               => ':attribute  debe ser una cadena.',
    'timezone'             => ':attribute  debe ser una zona válida.',
    'unique'               => ':attribute  ya ha sido tomado.',
    'uploaded'             => ':attribute  no se pudo cargar.',
    'url'                  => 'El formato de :attribute  no es válido.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using El
    | convention "attribute.rule" to name El lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | El following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". This simply helps us make messages a little cleaner.
    |
    */

    'attributes' => [],

];