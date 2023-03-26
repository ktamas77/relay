<?php

function setRelay($relayNumber, $on, $delaySeconds = 0, $relayHost = '192.168.1.100', $relayPort = 6722) {
    $socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
    $result = socket_connect($socket, $relayHost, $relayPort);
    if ($result === false) {
        die("can't establish connection.");
    };
    $relayValue = $on ? '2' : '1';
    $relayCode = $relayValue . $relayNumber;
    if ($delaySeconds > 0) {
        $relayCode .= ':' . $delaySeconds;
    }
    socket_write($socket, $relayCode, strlen($relayCode));
    $result = socket_read($socket, 8, PHP_BINARY_READ);
    socket_close($socket);
    return $result;
}

// turns on relay 1 fro 30 seconds, then off
setRelay(1, true, 30);


