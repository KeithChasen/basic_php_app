<?php

return [
  'driver' => getenv('NETCE_DB_DRIVER'),
  'host' => getenv('NETCE_DB_HOST'),
  'dbname' => getenv('NETCE_DB_NAME'),
  'port' => getenv('NETCE_DB_PORT'),
  'dbusername' => getenv('NETCE_DB_USER'),
  'dbpassword' => getenv('NETCE_DB_PASSWORD'),
];