<?php

require __DIR__ . '/src/FlowClient.php';
require __DIR__ . '/src/FlowException.php';

// API Operations
require __DIR__ . '/src/ApiOperations/All.php';
require __DIR__ . '/src/ApiOperations/Create.php';
require __DIR__ . '/src/ApiOperations/Delete.php';
require __DIR__ . '/src/ApiOperations/Retrieve.php';
require __DIR__ . '/src/ApiOperations/Update.php';

// Services
require __DIR__ . '/src/Service/AbstractService.php';
require __DIR__ . '/src/Service/AbstractServiceFactory.php';
require __DIR__ . '/src/Service/CoreServiceFactory.php';
require __DIR__ . '/src/Service/CustomerGroupService.php';
require __DIR__ . '/src/Service/DataSchemaService.php';
require __DIR__ . '/src/Service/DataSchemaVersionService.php';