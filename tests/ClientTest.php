<?php
    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Client.php";
    require_once "src/Client.php";

    $server = 'mysql:host=localhost:8889;dbname=hair_salon_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class ClientTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            Client::deleteAll();
        }

        function test_constructorAndGetters()
        {
          $client_last_name = "Firenze";
          $client_first_name = "Luisa";
          $stylist_id = 2;
          $new_client = new Client($client_last_name, $client_first_name, $stylist_id);

          $result = array();
          array_push($result, $new_client->getStylistId(), $new_client->getLastName(), $new_client->getFirstName());

          $this->assertEquals([$stylist_id, $client_last_name, $client_first_name], $result);
        }

        function test_setters()
        {
            $client_last_name = "Chiznople";
            $client_first_name = "Frederique";
            $stylist_id = 1;
            $new_client = new Client($client_last_name, $client_first_name, $stylist_id);
            $replacement_last_name = "Dorquelin";
            $replacement_first_name = "Panopticus";
            $replacement_stylist_id = 2;

            $new_client->setLastName($replacement_last_name);
            $new_client->setFirstName($replacement_first_name);
            $new_client->setStylistId($replacement_stylist_id);

            $result = array();
            array_push($result, $new_client->getLastName(), $new_client->getFirstName(), $new_client->getStylistId());

            $this->assertEquals([$replacement_last_name, $replacement_first_name, $replacement_stylist_id], $result);
        }

        function test_sanitize()
        {
            $client_last_name = "D'Souza";
            $client_first_name = "L&Broni'que";
            $stylist_id = 1;
            $new_client = new Client($client_last_name, $client_first_name, $stylist_id);

            $new_client->sanitize();
            $result = array();
            array_push($result, $new_client->getLastName(), $new_client->getFirstName());

            $this->assertEquals(["D\'Souza", "L&amp;Broni\'que"], $result);
        }

        function test_desanitize()
        {
            $client_last_name = "D\'Souza";
            $client_first_name = "L&Broni'que";
            $stylist_id = 1;
            $new_client = new Client($client_last_name, $client_first_name, $stylist_id);

            $new_client->desanitize();
            $result = array();
            array_push($result, $new_client->getLastName(), $new_client->getFirstName());

            $this->assertEquals(["D'Souza", "L&Broni'que"], $result);
        }

        function test_validate()
        {
            $client_last_name = "d";
            $client_first_name = "b";
            $stylist_id = null;
            $new_client = new Client($client_last_name, $client_first_name, $stylist_id);

            $result = $new_client->validate();

            $this->assertEquals(false, $result);
        }

        function test_saveAndGetAll()
        {
            $client_last_name = "Bardas";
            $client_first_name = "Phocas";
            $stylist_id = 1;
            $new_client = new Client($client_last_name, $client_first_name, $stylist_id);

            $new_client->save();
            $result = Client::getAll();

            $this->assertEquals([$new_client], $result);
        }

        function test_deleteAll()
        {
            $client_last_name = "Cakehole";
            $client_first_name = "CheezeNozzle";
            $stylist_id = 2;
            $new_client = new Client($client_last_name, $client_first_name, $stylist_id);

            $new_client->save();
            Client::deleteAll();
            $result = Client::getAll();

            $this->assertEquals([], $result);
        }

        function testFindByID()
        {
            $client_last_name = "Bork";
            $client_first_name = "Robert";
            $stylist_id = 1;
            $new_client = new Client($client_last_name, $client_first_name, $stylist_id);
            $new_client->save();
            $search_id = $new_client->getId();

            $another_client_last_name = "Pork";
            $another_client_first_name = "Billy";
            $another_stylist_id = 2;
            $another_new_client = new Client($client_last_name, $client_first_name, $stylist_id);
            $another_new_client->save();

            $result = Client::findById($search_id);

            $this->assertEquals($new_client, $result);
        }

        function test_update()
        {
            $client_last_name = "von Habsburg";
            $client_first_name = "Franz-Ferdinand";
            $stylist_id = 1;
            $new_client = new Client($client_last_name, $client_first_name, $stylist_id);
            $new_client->save();
            $search_id = $new_client->getId();
            $update_last_name = "von Wittlesbach";
            $update_first_name = "Rudolf";
            $update_stylist_id = 2;

            $new_client->update($update_last_name, $update_first_name, $update_stylist_id);
            $result = Client::findById($search_id);

            $this->assertEquals([$search_id, $update_last_name, $update_first_name, $update_stylist_id],[$result->getId(), $result->getLastName(), $result->getFirstName(), $result->getStylistId()]);
        }

        function test_delete()
        {
            $client_last_name = "Saxifrage";
            $client_first_name = "Agneska";
            $stylist_id = 1;
            $new_client = new Client($client_last_name, $client_first_name, $stylist_id);
            $new_client->save();

            $new_client->delete();
            $result = Client::getAll();

            $this->assertEquals([], $result);
        }
    }
?>
