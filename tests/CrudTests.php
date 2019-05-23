<?php

use PHPUnit\Framework\TestCase;

use Ray\Crud;

final class CrudTests extends TestCase
{
    private $Crud;

    protected function setUp(): void
    {
        $this->Crud = new Crud;
    }

    public function testArrayParser()
    {
        $array = [
          ["name", "fullName" , "birthday"],
          ["Ray" , "Ray McLovin" , "1997-02-19"],
          ["Bond" , "James Bond" , "1953-01-01"],
          ["Jesus" , "Jesus Christ" , "0000-12-25"]
        ];
        $expectedArray = ["Ray", "Ray McLovin", "1997-02-19", "Bond", "James Bond", "1953-01-01", "Jesus", "Jesus Christ", "0000-12-25"];
        $expectedvString = "(name , fullName , birthday)";
        $expectedvGroups = "(? , ? , ?) , (? , ? , ?) , (? , ? , ?)";

        $parse = $this->Crud->parseInsertArray($array);

        $this->assertEquals($parse->execArray, $expectedArray);
        $this->assertEquals($parse->vString, $expectedvString);
        $this->assertEquals($parse->vGroups, $expectedvGroups);
    }
}
