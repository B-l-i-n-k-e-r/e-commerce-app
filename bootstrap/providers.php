<?php

// bootstrap/providers.php

return [
    App\Providers\AppServiceProvider::class,
    // Ensure Laravel\Pail\PailServiceProvider::class is NOT here 
    // if you don't want the package installed.
];