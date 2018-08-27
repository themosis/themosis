<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Messages de validation
    |--------------------------------------------------------------------------
    |
    | Les lignes qui suivent contiennent les messages d'erreurs par défaut
    | utilisés par la classe Validator. Certaines de ces règles ont de multiple
    | versions telles que les règles "size". N'hésitez pas à modifier les
    | messages ci-dessous à votre guise.
    |
    */

    'accepted'             => 'Le champs :attribute doit être accepté.',
    'active_url'           => 'Le champs :attribute n\'est pas une URL valide.',
    'after'                => 'Le champs :attribute doit être une date après :date.',
    'after_or_equal'       => 'Le champs :attribute doit être une date équivalente ou après :date.',
    'alpha'                => 'Le champs :attribute doit contenir uniquement des lettres.',
    'alpha_dash'           => 'Le champs :attribute peut contenir uniquement des lettres, des nombres et des traits d\'union.',
    'alpha_num'            => 'Le champs :attribute peut contenir uniquement des lettres et des nombres.',
    'array'                => 'Le champs :attribute doit être un tableau (array).',
    'before'               => 'Le champs :attribute doit être une date avant :date.',
    'before_or_equal'      => 'Le champs :attribute doit être une date équivalente ou avant :date.',
    'between'              => [
        'numeric' => 'Le champs :attribute doit se situer entre :min et :max.',
        'file'    => 'Le champs :attribute doit peser entre :min et :max kilo-octets.',
        'string'  => 'Le champs :attribute doit se situer entre :min et :max caractères.',
        'array'   => 'Le champs :attribute doit contenir entre :min et :max éléments.',
    ],
    'boolean'              => 'Le champs :attribute doit être vrai ou faux.',
    'confirmed'            => 'La confirmation de :attribute ne correspond pas.',
    'date'                 => 'Le champs :attribute n\'est pas une date valide.',
    'date_format'          => 'Le champs :attribute ne correspond pas au format :format.',
    'different'            => 'Le champs :attribute et le :other doivent être différents.',
    'digits'               => 'Le champs :attribute doit être de :digits chiffres.',
    'digits_between'       => 'Le champs :attribute doit être entre :min et :max chiffres.',
    'dimensions'           => 'Le champs :attribute a des dimensions d\'image  has invalid image dimensions.',
    'distinct'             => 'Le champs :attribute a une valeur similaire.',
    'email'                => 'Le champs :attribute doit être une adresse e-mail valide.',
    'exists'               => 'Le champs sélectionné :attribute est invalide.',
    'file'                 => 'Le champs :attribute doit être un fichier.',
    'filled'               => 'Le champs :attribute doit contenir une valeur.',
    'image'                => 'Le champs :attribute doit être une image.',
    'in'                   => 'Le champs sélectionné :attribute est invalide.',
    'in_array'             => 'Le champs :attribute n\'existe pas dans :other.',
    'integer'              => 'Le champs :attribute doit être un nombre entier.',
    'ip'                   => 'Le champs :attribute doit être une adresse IP valide.',
    'ipv4'                 => 'Le champs :attribute doit être une adresse IPv4 valide.',
    'ipv6'                 => 'Le champs :attribute doit être une adresse IPv6 valide.',
    'json'                 => 'Le champs :attribute doit être une chaîne JSON valide.',
    'max'                  => [
        'numeric' => 'Le champs :attribute ne peut pas être plus grand que :max.',
        'file'    => 'Le fichier :attribute ne peut pas peser plus de :max kilo-octets.',
        'string'  => 'La chaîne :attribute ne peut pas contenir plus de :max caractères.',
        'array'   => 'Le tableau :attribute ne peut pas contenir plus de :max éléments.',
    ],
    'mimes'                => 'Le champs :attribute doit être un fichier de type: :values.',
    'mimetypes'            => 'Le champs :attribute doit être un fichier de type: :values.',
    'min'                  => [
        'numeric' => 'Le champs :attribute doit être au moins :min.',
        'file'    => 'Le fichier :attribute doit perser au moins :min kilo-octets.',
        'string'  => 'La chaîne :attribute doit contenir au moins :min caractères.',
        'array'   => 'Le tableau :attribute doit contenir au moins :min éléments.',
    ],
    'not_in'               => 'Le champs sélectionné :attribute est invalide.',
    'numeric'              => 'Le champs :attribute doit être un nombre.',
    'present'              => 'Le champs :attribute doit être présent.',
    'regex'                => 'Le format du champs :attribute est invalide.',
    'required'             => 'Le champs :attribute est requis.',
    'required_if'          => 'Le champs :attribute est requis si le champs :other a une valeur de :value.',
    'required_unless'      => 'Le champs :attribute est requis sauf si le champs :other se trouve dans les valeurs :values.',
    'required_with'        => 'Le champs :attribute est requis lorsque :values est présent.',
    'required_with_all'    => 'Le champs :attribute est requis lorsque :values est présent.',
    'required_without'     => 'Le champs :attribute est requis lorsque :values n\'est pas présent.',
    'required_without_all' => 'Le champs :attribute est requis lorsque aucunes valeurs :values sont présentes.',
    'same'                 => 'Le champs :attribute et :other doivent correspondre.',
    'size'                 => [
        'numeric' => 'Le champs :attribute doit être :size.',
        'file'    => 'Le fichier :attribute doit peser :size kilo-octets.',
        'string'  => 'La chaîne :attribute doit contenir :size caractères.',
        'array'   => 'Le tableau :attribute doit contenir :size éléments.',
    ],
    'string'               => 'Le champs :attribute doit être une chaîne de caractère.',
    'timezone'             => 'Le champs :attribute doit être un fuseau horaire valide.',
    'unique'               => 'Le champs :attribute est déjà utilisé.',
    'uploaded'             => 'Le téléchargement du champs :attribute a échoué.',
    'url'                  => 'Le format du champs :attribute est invalide.',

    /*
    |--------------------------------------------------------------------------
    | Messages de validation personnalisés
    |--------------------------------------------------------------------------
    |
    | Vous pouvez définir des messages de validation personnalisés pour vos
    | attributs en utilisant la convention "attribut.règle" pour les nommer.
    | Cela permet de créer rapidement des messages personnalisés pour un
    | attribut donné.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Attributs de validation personnalisés
    |--------------------------------------------------------------------------
    |
    | Les lignes suivants vous permettent de permuter les valeurs des attributs
    | avec quelque chose de plus "user friendly" à lire comme une "adresse e-mail"
    | au lieu de "email". Cele permet de rendre les messages plus compréhensibles.
    |
    */

    'attributes' => [],

];
