<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted'             => 'Sie müssen den :attribute zustimmen.',
    'active_url'           => ':attribute ist keine gültige URL.',
    'after'                => ':attribute muss ein Datum nach :date sein.',
    'after_or_equal'       => ':attribute muss ein Datum nach oder gleich :date sein.',
    'alpha'                => ':attribute darf nur Buchstaben enthalten.',
    'alpha_dash'           => ':attribute darf nur Buchstaben, Zahlen und Bindestriche enthalten.',
    'alpha_num'            => ':attribute darf nur Buchstaben und Zahlen enthalten.',
    'array'                => ':attribute muss ein Array sein.',
    'before'               => ':attribute muss ein Datum vor :date sein.',
    'before_or_equal'      => ':attribute muss ein Datum vor und gleich :date sein.',
    'between'              => [
        'numeric' => ':attribute muss zwischen :min und :max sein.',
        'file'    => ':attribute muss zwischen :min und :max kilobytes groß sein.',
        'string'  => ':attribute muss zwischen :min und :max Zeichen lang sein.',
        'array'   => ':attribute muss zwischen :min und :max Elementen haben.',
    ],
    'boolean'              => ':attribute muss wahr oder falsch ein.',
    'confirmed'            => ':attribute stimmt nicht überein.',
    'date'                 => ':attribute ist kein gültiges Datum.',
    'date_format'          => ':attribute stimmt nicht mit der Formatvorgabe :format überein.',
    'different'            => ':attribute und :other müssen sich unterscheiden.',
    'digits'               => ':attribute muss :digits Nummern lang sein.',
    'digits_between'       => ':attribute muss zwischen :min und :max Nummern lang sein.',
    'dimensions'           => ':attribute hat ungültige Dimensionen.',
    'distinct'             => ':attribute enthält einen doppelten Wert.',
    'email'                => ':attribute muss eine gültige E-Mail sein.',
    'exists'               => ':attribute existiert nichit.',
    'file'                 => ':attribute muss eine Datei sein.',
    'filled'               => ':attribute muss ausgefüllt sein.',
    'image'                => ':attribute muss ein Bild sein.',
    'in'                   => ':attribute ist ungültig.',
    'in_array'             => ':attribute existiert nicht in :other.',
    'integer'              => ':attribute muss eine Ganzzahl sein.',
    'ip'                   => ':attribute muss eine gültige IP-Adresse sein.',
    'ipv4'                 => ':attribute muss eine gültige IPv4-Adresse sein.',
    'ipv6'                 => ':attribute muss eine gültige IPv6-Adresse sein.',
    'json'                 => ':attribute muss eine gültige JSON Zeichenkette sein.',
    'max'                  => [
        'numeric' => ':attribute darf nicht größer als :max sein.',
        'file'    => ':attribute darf niciht größer als :max kilobytes sein.',
        'string'  => ':attribute darf nicht länger als :max Zeichen sein.',
        'array'   => ':attribute darf nicht mehr als :max Elemente enthalten.',
    ],
    'mimes'                => ':attribute muss eine :values Datei sein.',
    'mimetypes'            => ':attribute muss eine :values Datei sein.',
    'min'                  => [
        'numeric' => ':attribute muss mindestens :min sein.',
        'file'    => ':attribute muss mindestens :min kilobytes groß sein.',
        'string'  => ':attribute muss mindestens :min Zeichen lang sein.',
        'array'   => ':attribute muss mindestens :min Elemente haben.',
    ],
    'not_in'               => 'Die Auswahl für :attribute ist ungültig.',
    'numeric'              => ':attribute muss eine Nummer sein.',
    'present'              => ':attribute muss präsent sein.',
    'regex'                => 'Das Format für :attribute ist ungültig.',
    'required'             => ':attribute muss ausgefüllt werden.',
    'required_if'          => ':attribute muss ausgefüllt werden, wenn :other den Wert :value enthält.',
    'required_unless'      => ':attribute muss ausgefüllt werden, solange :other in :values enthalten ist.',
    'required_with'        => ':attribute muss ausgefüllt werden, wenn :values präsent ist.',
    'required_with_all'    => ':attribute muss ausgefüllt werden, wenn :values präsent sind.',
    'required_without'     => ':attribute muss ausgefüllt werden, wenn :values nicht präsent ist.',
    'required_without_all' => ':attribute muss ausgefüllt werden, wenn :values nicht präsent sind.',
    'same'                 => ':attribute muss mit :other übereinstimmen.',
    'size'                 => [
        'numeric' => ':attribute muss :size sein.',
        'file'    => ':attribute muss :size kilobytes groß sein.',
        'string'  => ':attribute muss :size Zeichen lang sein.',
        'array'   => ':attribute muss :size enthalten.',
    ],
    'string'               => ':attribute muss eine Zeichenkette sein.',
    'timezone'             => ':attribute muss eine gültige Zeitzone sein.',
    'unique'               => ':attribute muss einzigartig sein.',
    'uploaded'             => ':attribute konnte nicht hochgeladen werden.',
    'url'                  => ':attribute ist keine gültige URL.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
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
    | The following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". This simply helps us make messages a little cleaner.
    |
    */

    'attributes' => [
    	'email' => 'E-Mail Adresse',
	    'phone' => 'Telefon Nummer'
    ],

];
