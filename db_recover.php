<?php
    require_once __DIR__.'/vendor/autoload.php';

    use Dotenv\Dotenv;
    use Utility\helperClass;

    $dotenv = new Dotenv(__DIR__);
    $dotenv->load(); //.envが無いとエラーになる

    //for monolog
    use Monolog\Logger;
    use Monolog\Handler\StreamHandler;

    /* prepaer helper */
    $util = new helperClass;

    /* prepaer monolog instance */
    $log = new Logger('MARIADB_LOG');
    //ログレベルをDEBUG（最も低い）に設定
    $handler = new StreamHandler(getenv("RECOVER_LOG"),Logger::DEBUG);
    $log->pushHandler($handler);

    /**
      - Check the status of the database
      - Restart DB
      - Get DB status
    */

    if ($util->parseStatus($util->statustMariaDB()))
    {
        /* nothing */
    } else {
        /* Get memory informaion */
        $mems= $util->getFreeMemory();
        $log->addInfo('=========================');
        $log->addInfo('free: '.$mems["free"]);
        $log->addInfo('available: '.$mems["available"]);

        /* Trouble! restart DB */
        $res_restart = $util->restartMariaDB();
        $log->addError('MariaDB is inactive (dead). Now restart MariaDB.');

        /* Information */
        $to = getenv("TO_MAIL");
        $title = getenv("MAIL_TITLE");
        $content = <<< EOM
free: {$mems["free"]} {$mems["available"]}
available: {$mems["available"]}
MariaDB is inactive (dead). Now restart MariaDB.
EOM;
        $util->sendmail($to, $title, $content);
        $log->addInfo('Send mail to user@example.com　about this trouble.');


        $log->addInfo('See /var/log/mariadb/mariadb.log');

        $util->restartMariaDB();
    }
