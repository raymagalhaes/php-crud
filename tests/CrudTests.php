<?php

use PHPUnit\Framework\TestCase;

final class CrudTests extends TestCase
{
    private $Crud;
    // este método roda antes de cada teste
    protected function setUp(): void
    {
        $this->Crud = new Crud;
    }
    public function testaSelect()
    {
        $this->assertTrue(is_array($this->Crud->Select("people")));
    }
}
