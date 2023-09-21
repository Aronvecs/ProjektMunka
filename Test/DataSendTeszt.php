<?php
require '../sablon/sablon.php';
use PHPUnit\Framework\TestCase;

class DataSendTeszt extends TestCase
{
    private $get;
    protected function setUp(): void{
        $this ->get = new UAccData();
    }
    public function testGetCharacterName():void{
        $result = $this->get->GetAll("characters_request")[0]["character_name"];
        $this->assertEquals('asd', $result);
    }
    public function testGetCharactersVoiceActor():void{
        $result = $this->get->GetAll("characters_request")[1]["voice_actor_name"];
        $this->assertEquals('Kevin_Conroy', $result);
    }
    public function testGetGameName():void{
        $result = $this->get->GetAll("game_request")[0]["game_name"];
        $this->assertEquals('ads', $result);
    }
}
?>