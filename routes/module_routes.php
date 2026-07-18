<?php

return [
    'customer' => glob(base_path('Modules/*/routes/api_customer.php')),
    'public'   => glob(base_path('Modules/*/routes/api.php')),
];
