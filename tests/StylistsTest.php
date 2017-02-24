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
    }
?>
