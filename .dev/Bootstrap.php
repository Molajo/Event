<?php
/**
 * Standard
 *
 * @package   Molajo
 * @copyright 2013 Amy Stephen. All rights reserved.
 * @license   http://www.opensource.org/licenses/mit-license.html MIT License
 */
define('MOLAJO', 'This is a Molajo Distribution');

if (substr($_SERVER['DOCUMENT_ROOT'], - 1) == '/') {
    define('ROOT_FOLDER', $_SERVER['DOCUMENT_ROOT']);
} else {
    define('ROOT_FOLDER', $_SERVER['DOCUMENT_ROOT'] . '/');
}

$base = substr(__DIR__, 0, strlen(__DIR__) - 5);
define('BASE_FOLDER', $base);

$classMap = array(

    'Molajo\\Standard\\Adapter'                               => BASE_FOLDER . '/Adapter.php',
    'Molajo\\Standard\\Api\\ActionsInterface'             => BASE_FOLDER . '/Api/ActionsInterface.php',
    'Molajo\\Standard\\Api\\AdapterInterface'             => BASE_FOLDER . '/Api/AdapterInterface.php',
    'Molajo\\Standard\\Api\\Fileupload'                   => BASE_FOLDER . '/Api/Fileupload.php',
    'Molajo\\Standard\\Api\\MetadataInterface'            => BASE_FOLDER . '/Api/MetadataInterface.php',
    'Molajo\\Standard\\Api\\SystemInterface'              => BASE_FOLDER . '/Api/SystemInterface.php',
    'Molajo\\Standard\\Exception\\AccessDeniedException'      => BASE_FOLDER . '/Exception/AccessDeniedException.php',
    'Molajo\\Standard\\Exception\\StandardException'          => BASE_FOLDER . '/Exception/StandardException.php',
    'Molajo\\Standard\\Exception\\StandardExceptionInterface' => BASE_FOLDER . '/Exception/StandardExceptionInterface.php',
    'Molajo\\Standard\\Exception\\NotFoundException'          => BASE_FOLDER . '/Exception/NotFoundException.php',
    'Molajo\\Standard\\Type\\Local'                           => BASE_FOLDER . '/Type/Local.php',
    'Molajo\\Standard\\Type\\Ftp'                             => BASE_FOLDER . '/Type/Ftp.php',
    'Molajo\\Standard\\Type\\StandardType'                    => BASE_FOLDER . '/Type/StandardType.php',
    'Ftp\\Data'                                               => BASE_FOLDER . '/.dev/Tests/Ftp/Data.php',
    'Ftp\\FtpCopyTest'                                        => BASE_FOLDER . '/.dev/Tests/Ftp/FtpCopyTest.php',
    'Ftp\\FtpDeleteTest'                                      => BASE_FOLDER . '/.dev/Tests/Ftp/FtpDeleteTest.php',
    'Ftp\\FtpMoveTest'                                        => BASE_FOLDER . '/.dev/Tests/Ftp/FtpMoveTest.php',
    'Ftp\\FtpReadTest'                                        => BASE_FOLDER . '/.dev/Tests/Ftp/FtpReadTest.php',
    'Ftp\\FtpWriteTest'                                       => BASE_FOLDER . '/.dev/Tests/Ftp/FtpWriteTest.php',
    'Ftp\\FtpListTest'                                        => BASE_FOLDER . '/.dev/Tests/Ftp/FtpListTest.php',
    'Local\\Data'                                             => BASE_FOLDER . '/.dev/Tests/Local/Data.php',
    'Local\\LocalCopyTest'                                    => BASE_FOLDER . '/.dev/Tests/Local/LocalCopyTest.php',
    'Local\\LocalDeleteTest'                                  => BASE_FOLDER . '/.dev/Tests/Local/LocalDeleteTest.php',
    'Local\\LocalMoveTest'                                    => BASE_FOLDER . '/.dev/Tests/Local/LocalMoveTest.php',
    'Local\\LocalReadTest'                                    => BASE_FOLDER . '/.dev/Tests/Local/LocalReadTest.php',
    'Local\\LocalWriteTest'                                   => BASE_FOLDER . '/.dev/Tests/Local/LocalWriteTest.php',
    'Local\\LocalListTest'                                    => BASE_FOLDER . '/.dev/Tests/Local/LocalListTest.php'
);

spl_autoload_register(
    function ($class) use ($classMap) {
        if (array_key_exists($class, $classMap)) {
            require_once $classMap[$class];
        }
    }
);
