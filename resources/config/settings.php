<?php

return [
    'dump_path' => [
        'type'   => 'anomaly.field_type.text',
        'config' => [
            'default_value' => 'dumps',
        ],
    ],
    'dump_format' => [
        'type'   => 'anomaly.field_type.text',
        'config' => [
            'default_value' => 'Y-m-d_H:i:s_',
        ],
    ]
];
