<?php
//Chat.php

namespace MyApp;
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;


class Chat extends records implements MessageComponentInterface {
    protected $clients;

    public function __construct() {
        parent::__construct();
        $this->clients = new \SplObjectStorage;
        echo 'Server Started';
    }

    public function onOpen(ConnectionInterface $conn) {
        // Store the new connection to send messages to later
        echo 'Server Started';
        $this->clients->attach($conn);

        echo "New connection! ({$conn->resourceId})\n";
    }

    public function onMessage(ConnectionInterface $from, $msg) {
        $numRecv = count($this->clients) - 1;
        echo sprintf('Connection %d sending message "%s" to %d other connection%s' . "\n"
            , $from->resourceId, $msg, $numRecv, $numRecv == 1 ? '' : 's');

        $data = json_decode($msg, true);
        $this->setUserId($data['userId']);
        $this->setMessage($data['msg']);
        $this->save_chat($data['userId']);      
        $user_data = $this->get_user_data_by_id();
        $user_name = $user_data['user_name'];
        $data['dt'] = date("d-m-Y h:i:s");

        foreach ($this->clients as $client) {
            if($from == $client)            
                $data['from'] = 'Me';            
            else            
                $data['from'] = $user_name;            

            $client->send(json_encode($data));
        }
    }

    public function onClose(ConnectionInterface $conn) {
        // The connection is closed, remove it, as we can no longer send it messages
        $this->clients->detach($conn);
        echo "Connection {$conn->resourceId} has disconnected\n";
    }

    public function onError(ConnectionInterface $conn, \Exception $e) {
        echo "An error has occurred: {$e->getMessage()}\n";
        $conn->close();
    }
}

?>