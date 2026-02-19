<?php

$host = 'imap.gmail.com';
$port = 993;
$timeout = 10;
$context = stream_context_create([
    'ssl' => [
        'verify_peer' => false,
        'verify_peer_name' => false,
    ],
]);

echo "Trying to connect to ssl://$host:$port with timeout $timeout seconds...\n";
$socket = stream_socket_client("ssl://$host:$port", $errno, $errstr, $timeout, STREAM_CLIENT_CONNECT, $context);

if (!$socket) {
    echo "ERROR: $errstr ($errno)\n";
    exit(1);
}

echo "SUCCESS: Connected to socket.\n";
stream_set_timeout($socket, $timeout);
echo "Reading input...\n";
echo fread($socket, 1024);
fwrite($socket, "TAG1 CAPABILITY\r\n");
echo "Sent CAPABILITY command.\n";
echo fread($socket, 1024);
fclose($socket);
echo "Done.\n";
