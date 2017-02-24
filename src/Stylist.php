<?php
    Class Stylist
    {
        private $id;
        private $stylist_last_name;
        private $stylist_first_name;
        private $specialty;

        function __construct($stylist_last_name, $stylist_first_name, $specialty, $id = null)
        {
            $this->stylist_last_name = $stylist_last_name;
            $this->stylist_first_name = $stylist_first_name;
            $this->specialty = $specialty;
            $this->id = $id;
        }

        function getLastName()
        {
            return $this->stylist_last_name;
        }

        function getFirstName()
        {
            return $this->stylist_first_name;
        }

        function getSpecialty()
        {
            return $this->specialty;
        }

    }
?>
