<?php

return array(
        'name'          => 'Product',
        'table'         => 'catalogue_products',
        'model'         => 'Lavalite\Catalogue\Models\Product',
        'permissions'   => ['admin' => ['view', 'create', 'edit', 'delete', 'image'],
                            'test' => ['view', 'create', 'edit', 'delete', 'image']],
        'image'         =>
            [
            'xs'        => ['width' =>'60',     'height' =>'45'],
            'sm'        => ['width' =>'160',    'height' =>'75'],
            'md'        => ['width' =>'460',    'height' =>'345'],
            'lg'        => ['width' =>'800',    'height' =>'600'],
            'xl'        => ['width' =>'1000',   'height' =>'750'],
            ],

);
