<?php
    Class Client
    {
        private $id;
        private $client_last_name;
        private $client_first_name;
        private $stylist_id;

        function __construct($client_last_name, $client_first_name, $stylist_id, $id = null)
        {
            $this->client_last_name = $client_last_name;
            $this->client_first_name = $client_first_name;
            $this->stylist_id = $stylist_id;
            $this->id = $id;
        }

        function getLastName()
        {
            return $this->client_last_name;
        }

        function getFirstName()
        {
            return $this->client_first_name;
        }

        function getStylistId()
        {
            return $this->stylist_id;
        }

        function getId()
        {
            return $this->id;
        }

        function setLastName($input_last_name)
        {
            $this->client_last_name = $input_last_name;
        }

        function setFirstName($input_first_name)
        {
            $this->client_first_name = $input_first_name;
        }

        function setStylistId($input_stylist_id)
        {
            $this->stylist_id = $input_stylist_id;
        }

        function sanitize()
        {
            $this->client_last_name = htmlspecialchars(addslashes(trim($this->client_last_name)));
            $this->client_first_name = htmlspecialchars(addslashes(trim($this->client_first_name)));
        }

        function desanitize()
        {
            $this->client_last_name = htmlspecialchars_decode(stripslashes($this->client_last_name));
            $this->client_first_name = htmlspecialchars_decode(stripslashes($this->client_first_name));
        }

        function validate()
        {
            if(empty($this->client_last_name)||empty($this->client_first_name)||empty($this->stylist_id))
            {
                return false;
            } else {
                return true;
            }
        }

        function save()
        {
            if($this->validate())
            {
                $this->sanitize();
                $GLOBALS['DB']->exec("INSERT INTO clients (client_last_name, client_first_name, stylist_id) VALUES ('{$this->getLastName()}', '{$this->getFirstName()}', '{$this->getStylistId()}');");
                $this->id = $GLOBALS['DB']->lastInsertId();
                return true;
            } else {
                return false;
            }
        }

        function update($input_last_name, $input_first_name, $input_stylist_id)
        {
            $this->setLastName($input_last_name);
            $this->setFirstName($input_first_name);
            $this->setStylistId($input_stylist_id);
            if($this->validate())
            {
                $this->sanitize();
                $GLOBALS['DB']->exec("UPDATE clients SET client_last_name = '{$this->getLastName()}', client_first_name = '{$this->getFirstName()}', stylist_id = '{$this->getStylistId()}' WHERE id = {$this->getId()};");
                return true;
            } else {
                return false;
            }
        }

        function delete()
        {
            $GLOBALS['DB']->exec("DELETE FROM clients WHERE id = {$this->getId()};");
        }

        static function getAll()
        {
            $returned_clients = $GLOBALS['DB']->query("SELECT * FROM clients;");
            $all_clients = array();
            foreach($returned_clients as $client)
            {
                $client_last_name = $client['client_last_name'];
                $client_first_name = $client['client_first_name'];
                $stylist_id = $client['stylist_id'];
                $id = $client['id'];
                $new_client = new Client($client_last_name, $client_first_name, $stylist_id, $id);
                $new_client->desanitize();
                array_push($all_clients, $new_client);
            }
            return $all_clients;
        }

        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM clients;");
        }

        static function findById($input_id)
        {
            $found_client = null;
            $all_clients = Client::getAll();
            foreach ($all_clients as $individual_client)
            {
                $individual_client_id = $individual_client->getId();
                if($individual_client_id == $input_id)
                {
                    $found_client = $individual_client;
                }
            }
            return $found_client;
        }

        static function findByStylistId($input_id)
        {
            $matching_clients = array();
            $all_clients = Client::getAll();
            foreach($all_clients as $current_client)
            {
                $client_stylist_id = $current_client->getStylistId();
                if ($client_stylist_id == $input_id)
                {
                    array_push($matching_clients, $current_client);
                }
            }
            return $matching_clients;
        }
    }
?>
