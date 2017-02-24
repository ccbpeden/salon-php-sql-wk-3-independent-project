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

        function getId()
        {
            return $this->id;
        }

        function setLastName($input_last_name)
        {
            $this->stylist_last_name = $input_last_name;
        }

        function setFirstName($input_first_name)
        {
            $this->stylist_first_name = $input_first_name;
        }

        function setSpecialty($input_specialty)
        {
            $this->specialty = $input_specialty;
        }

        function sanitize()
        {
            $this->stylist_last_name = htmlspecialchars(addslashes(trim($this->stylist_last_name)));
            $this->stylist_first_name = htmlspecialchars(addslashes(trim($this->stylist_first_name)));
        }

        function desanitize()
        {
            $this->stylist_last_name = htmlspecialchars_decode(stripslashes($this->stylist_last_name));
            $this->stylist_first_name = htmlspecialchars_decode(stripslashes($this->stylist_first_name));

        }

        function validate()
        {
            if(empty($this->stylist_last_name)||empty($this->stylist_first_name||empty($this->specialty)))
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
                $GLOBALS['DB']->exec("INSERT INTO stylists (stylist_last_name, stylist_first_name, specialty) VALUES ('{$this->getLastName()}', '{$this->getFirstName()}', '{$this->getSpecialty()}');");
                $this->id = $GLOBALS['DB']->lastInsertId();
            } else {
                return false;
            }
        }

        function update($input_last_name, $input_first_name, $input_specialty)
        {
            $this->setLastName($input_last_name);
            $this->setFirstName($input_first_name);
            $this->setSpecialty($input_specialty);
            if($this->validate())
            {
                $this->sanitize();
                $GLOBALS['DB']->exec("UPDATE stylists SET stylist_last_name = '{$this->getLastName()}', stylist_first_name = '{$this->getFirstName()}', specialty = '{$this->getSpecialty()}' WHERE id = {$this->getId()};");
            }


        }

        static function getAll()
        {
            $returned_stylists = $GLOBALS['DB']->query("SELECT * FROM stylists;");
            $all_stylists = array();
            foreach($returned_stylists as $stylist)
            {
                $stylist_last_name = $stylist['stylist_last_name'];
                $stylist_first_name = $stylist['stylist_first_name'];
                $specialty = $stylist['specialty'];
                $id = $stylist['id'];
                $new_stylist = new Stylist($stylist_last_name, $stylist_first_name, $specialty, $id);
                $new_stylist->desanitize();
                array_push($all_stylists, $new_stylist);
            }
            return $all_stylists;
        }

        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM stylists;");
        }

        static function findById($input_id)
        {
            $found_stylist = null;
            $all_stylists = Stylist::getAll();
            foreach ($all_stylists as $stylist)
            {
                $stylist_id = $stylist->getId();
                if($stylist_id = $input_id)
                {
                    return $stylist;
                }
            }
        }

    }
?>
