<?php
// class A
// {
//     public array $data = [];
//     private $lol = 'private data';

//     public function getLol()
//     {
//         return $this->lol;
//     }

//     public function getName()
//     {
//         echo 'Aryan';
//     }

//     public function __call($name, $arguments)
//     {
//         print_r($arguments);
//         echo "The $name function does not exits.";
//     }

//     public function __get($name)
//     {
//         return  $this->data[$name] ?? "Property '$name' does not exist!";
//     }

//     public function __set($name, $value)
//     {
//         $this->data[$name] = $value;
//     }
    
//     public function __toString()
//     {
//         return 'This is a object of Class A';
//     }
// }

// $a = new A();
// echo $a->getLol();

class Address
{
    public string $name;

    public function __construct($name)
    {
        $this->name = $name;
    }
}


class Person
{
    public string $name;
    public Address $address;

    public function __construct($name, $addressName)
    {
        $this->name = $name;
        $this->address = new Address($addressName);
    }

    public function __clone()
    {
        $this->address = clone $this->address;
    }

    public function getAddress()
    {
        return $this->address->name;
    }
}

$person1 = new Person('Aryan Malla', 'Koteshwor');

$ser = serialize($person1);
$person2 = unserialize($ser);

var_dump($person1 === $person2);