<?php
 'permission' => [
                    'Name'          => 'Permission',
                    'name'          => 'permission',
                    'table'         => 'permissions',
                    'model'         => 'Lavalite\User\Models\Permission',
                    'permissions'   => ['view', 'create', 'edit', 'delete'],
                    'image'         =>
                        [
                        'xs'        => ['width' =>'60',     'height' =>'45'],
                        'sm'        => ['width' =>'100',    'height' =>'75'],
                        'md'        => ['width' =>'460',    'height' =>'345'],
                        'lg'        => ['width' =>'800',    'height' =>'600'],
                        'xl'        => ['width' =>'1000',   'height' =>'750'],
                        ],
                    'fillable'          =>  ['id', 'name', 'readable_name', 'created_at', 'updated_at'],
                    'listfields'        =>  ['id', 'name', 'readable_name', 'created_at', 'updated_at'],
                    'translatable'      =>  ['id', 'name', 'readable_name', 'created_at', 'updated_at'],
                    'upload-folder'     =>  '/uploads/permissions',
                    'uploadable'        =>  [
                                                'single' => [], 
                                                'multiple' => []
                                            ],

                    ],

