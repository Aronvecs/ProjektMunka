<?php

    require '../sablon/sablon.php';
    use PHPUnit\Framework\TestCase;

    class GamePageTest extends TestCase
    {
        private $TestGame;
        protected function setUp() : void
        {            
            $_GET["GameId"] = 1;
            $this ->TestGame = new GameData();
        }
        
        public function testGetGameName():void
        {
            $TestValue = $this->TestGame->GetGameData("game_name");
            $this->assertEquals("Skyrim",$TestValue);
        }
        public function testGetGameID():void
        {
            $TestValue = $this->TestGame->GetGameData("game_id");
            $this->assertEquals(1,$TestValue);
        }
        public function testCheckIfItsAddedAlready():void
        {
            $TestValue = $this->TestGame->CheckIfItsAddedAlready();
            $this->assertEquals(0,$TestValue);
        }
    }

?>

<!-- "game_name"
C:\xampp\php\php.exe phpunit.phar GamePageTest.php -->