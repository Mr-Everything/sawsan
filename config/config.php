<?php

// shortcut
define('DS', DIRECTORY_SEPARATOR);

// app path
define('APP_PATH', __DIR__ . DS . '..' );
define('VIEW_PATH', APP_PATH . DS . 'views');

// Public paths
define('CSS_PATH', '/assets/css/' );
define('JS_PATH',  '/assets/js/');
define('IMAGES_PATH', '/assets/images/');
define('IMAGES_UPLOADED_PATH', '/uploads/images');
define('DOCUMENTS_UPLOADED_PATH', '/uploads/documents');

// shortcut for this page (good performance)
define('NOT_FOUND_PAGE', VIEW_PATH . DS .'notfoundcontroller' . DS . 'notfoundaction.view.php');

// database config file
define('DB_CONFIG', __DIR__ . DS . 'db.config.php');

//session save path const and data
define('SESSION_SAVE_PATH', APP_PATH . DS . 'sessions');
define('SESSION_LIFE_TIME', 3600);


// language path
define('LANG_PATH', APP_PATH . DS . 'languages' . DS );
defined('DEFAULT_LANG') ? null : define('DEFAULT_LANG', 'ar');

//template path
define('TEMPLATE_PATH', APP_PATH . DS . 'templates' . DS);

// check for privileges
defined('CHECK_FOR_PRIVILEGES') ? null : define('CHECK_FOR_PRIVILEGES', 1);


// upload my files
defined('UPLOAD_PATH') ? null : define('UPLOAD_PATH', APP_PATH . DS . 'uploads');
defined('IMAGES_UPLOAD_PATH') ? null : define('IMAGES_UPLOAD_PATH', UPLOAD_PATH . DS . 'images');
defined('DOCUMENTS_UPLOAD_PATH') ? null : define('DOCUMENTS_UPLOAD_PATH', UPLOAD_PATH . DS . 'documents');
defined('MAX_FILE_SIZE_ALLOWED') ? null : define('MAX_FILE_SIZE_ALLOWED', ini_get('upload_max_filesize'));
