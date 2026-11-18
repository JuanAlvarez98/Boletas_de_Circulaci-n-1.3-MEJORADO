<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Conexión con el Servicio Web SAP (SOAP / RFC)
    |--------------------------------------------------------------------------
    |
    | Parámetros para la consulta del maestro de vehículos en SAP PM.
    |
    */
    'url' => env('SAP_WS_URL', 'http://ECC-DB-QA.seguridad.gob.hn:8000/sap/bc/srt/rfc/sap/zws_ord_comb/300/zws_ord_comb/zws_ord_comb'),
    'client' => env('SAP_CLIENT', '300'),
    'user' => env('SAP_USER', 'WASAPPM'),
    'password' => env('SAP_PASSWORD', ''),
    'timeout' => (int) env('SAP_TIMEOUT', 15),
];
