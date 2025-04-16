<?php

/**
 * database connections
 */
class Database
{
	private static $connections = [];

	public static function getConnection($name) {
		if (!isset(self::$connections[$name])) {
			$config = [
				// "hr" => [
    //                 "host" => "localhost",
    //                 "dbname" => "tngc_hrd2",
    //                 "username" => "root",
    //                 "password" => ""
    //             ],
                "hr" => [
                    "host" => "13.213.190.95",
                    "dbname" => "tngc_hrd2",
                    "username" => "misadmin",
                    "password" => "88224646abxy@"
                ],
                "port" => [
                    "host" => "localhost",
                    "dbname" => "portal_db",
                    "username" => "root",
                    "password" => ""
                ]
            ];

            if(!array_key_exists($name, $config)){
                throw new Exception("Invalid connection name: $name");
            }

			// Additional configurations if needed (e.g., port)
			// self::$connections[$name] = new PDO(
			// 	"mysql:host={$config[$name]['host']};dbname={$config[$name]['dbname']};charset=utf8mb4",
			// 	$config[$name]['username'],
			// 	$config[$name]['password']
			// );
            self::$connections[$name] = new PDO(
                "mysql:host={$config[$name]['host']};dbname={$config[$name]['dbname']};charset=utf8mb4",
                $config[$name]['username'],
                $config[$name]['password'],
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4 COLLATE utf8mb4_unicode_ci"
                ]
            );
			self::$connections[$name]->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			self::$connections[$name]->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
		}
		return self::$connections[$name];
	}
}
