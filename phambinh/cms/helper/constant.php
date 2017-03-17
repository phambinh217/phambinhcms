<?php

if (! defined('DF_NORMAL')) {
    define('DF_NORMAL', 'd-m-Y');
}

if (! defined('DTF_NORMAL_24')) {
    define('DTF_NORMAL_24', DF_NORMAL .'  H:i:s');
}

if (! defined('DTF_NORMAL_12')) {
    define('DTF_NORMAL_12', DF_NORMAL .'  h:i:s');
}

if (! defined('DF_DB')) {
    define('DF_DB', 'Y-m-d');
}

if (! defined('DTF_DB')) {
    define('DTF_DB', DF_DB .' H:i:s');
}
