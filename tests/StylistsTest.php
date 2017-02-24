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

    class Stylist extends PHPUnit_Framework_TestCase
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
    }
?>
