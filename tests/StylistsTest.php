<?php
    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Client.php";
    require_once "src/Stylist.php";

    $server = 'mysql:host=localhost:8889;dbname=hair_salon_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class StylistTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            Stylist::deleteAll();
        }

        function test_constructorAndGetters()
        {
          $stylist_last_name = "Firenze";
          $stylist_first_name = "Luisa";
          $specialty = "mani/pedi";
          $new_stylist = new Stylist($stylist_last_name, $stylist_first_name, $specialty);

          $result = array();
          array_push($result, $new_stylist->getSpecialty(), $new_stylist->getLastName(), $new_stylist->getFirstName());

          $this->assertEquals([$specialty, $stylist_last_name, $stylist_first_name], $result);
        }

        function test_setters()
        {
            $stylist_last_name = "Chiznople";
            $stylist_first_name = "Frederique";
            $specialty = "facial";
            $new_stylist = new Stylist($stylist_last_name, $stylist_first_name, $specialty);
            $replacement_last_name = "Dorquelin";
            $replacement_first_name = "Panopticus";
            $replacement_specialty = "weaves";

            $new_stylist->setLastName($replacement_last_name);
            $new_stylist->setFirstName($replacement_first_name);
            $new_stylist->setSpecialty($replacement_specialty);

            $result = array();
            array_push($result, $new_stylist->getLastName(), $new_stylist->getFirstName(), $new_stylist->getSpecialty());

            $this->assertEquals([$replacement_last_name, $replacement_first_name, $replacement_specialty], $result);
        }

        function test_sanitize()
        {
            $stylist_last_name = "D'Souza";
            $stylist_first_name = "L&Broni'que";
            $specialty = "straightening, perms, dying";
            $new_stylist = new Stylist($stylist_last_name, $stylist_first_name, $specialty);

            $new_stylist->sanitize();
            $result = array();
            array_push($result, $new_stylist->getLastName(), $new_stylist->getFirstName());

            $this->assertEquals(["D\'Souza", "L&amp;Broni\'que"], $result);
        }

        function test_desanitize()
        {
            $stylist_last_name = "D\'Souza";
            $stylist_first_name = "L&Broni'que";
            $specialty = "straightening, perms, dying";
            $new_stylist = new Stylist($stylist_last_name, $stylist_first_name, $specialty);

            $new_stylist->desanitize();
            $result = array();
            array_push($result, $new_stylist->getLastName(), $new_stylist->getFirstName());

            $this->assertEquals(["D'Souza", "L&Broni'que"], $result);
        }

        function test_validate()
        {
            $stylist_last_name = "d";
            $stylist_first_name = "b";
            $specialty = "";
            $new_stylist = new Stylist($stylist_last_name, $stylist_first_name, $specialty);

            $result = $new_stylist->validate();

            $this->assertEquals(false, $result);
        }

        function test_saveAndGetAll()
        {
            $stylist_last_name = "Bardas";
            $stylist_first_name = "Phocas";
            $specialty = "weaves";
            $new_stylist = new Stylist($stylist_last_name, $stylist_first_name, $specialty);

            $new_stylist->save();
            $result = Stylist::getAll();

            $this->assertEquals([$new_stylist], $result);
        }

        function test_deleteAll()
        {
            $stylist_last_name = "Cakehole";
            $stylist_first_name = "CheezeNozzle";
            $specialty = "mani/pedi";
            $new_stylist = new Stylist($stylist_last_name, $stylist_first_name, $specialty);

            $new_stylist->save();
            Stylist::deleteAll();
            $result = Stylist::getAll();

            $this->assertEquals([], $result);
        }

        function testFindByID()
        {
            $stylist_last_name = "Bork";
            $stylist_first_name = "Robert";
            $specialty = "weaves";
            $new_stylist = new Stylist($stylist_last_name, $stylist_first_name, $specialty);
            $new_stylist->save();
            $search_id = $new_stylist->getId();

            $another_stylist_last_name = "Pork";
            $another_stylist_first_name = "Billy";
            $another_specialty = "facials";
            $another_new_stylist = new Stylist($stylist_last_name, $stylist_first_name, $specialty);
            $another_new_stylist->save();

            $result = Stylist::findById($search_id);

            $this->assertEquals($new_stylist, $result);
        }

        function test_update()
        {
            $stylist_last_name = "von Habsburg";
            $stylist_first_name = "Franz-Ferdinand";
            $specialty = "facial";
            $new_stylist = new Stylist($stylist_last_name, $stylist_first_name, $specialty);
            $new_stylist->save();
            $search_id = $new_stylist->getId();
            $update_last_name = "von Wittlesbach";
            $update_first_name = "Rudolf";
            $update_specialty = "weaves";

            $new_stylist->update($update_last_name, $update_first_name, $update_specialty);
            $result = Stylist::findById($search_id);

            $this->assertEquals([$search_id, $update_last_name, $update_first_name, $update_specialty],[$result->getId(), $result->getLastName(), $result->getFirstName(), $result->getSpecialty()]);
        }

        function test_delete()
        {
            $stylist_last_name = "Saxifrage";
            $stylist_first_name = "Agneska";
            $specialty = "weaves";
            $new_stylist = new Stylist($stylist_last_name, $stylist_first_name, $specialty);
            $new_stylist->save();

            $new_stylist->delete();
            $result = Stylist::getAll();

            $this->assertEquals([], $result);
        }
    }
?>
