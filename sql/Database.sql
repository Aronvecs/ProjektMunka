CREATE DATABASE nagyprojekt DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
CREATE TABLE game (
  game_id int NOT NULL AUTO_INCREMENT,
  game_name varchar(500) NOT NULL,
  game_average_rating double(4, 2) NOT NULL,
  game_number_of_ratings int NOT NULL,
  game_release_date date NOT NULL,
  game_cover_image varchar(500) NOT NULL,
  game_trailer varchar(500) NOT NULL,
  game_description varchar(5000) NOT NULL,
  game_status varchar(30) NOT NULL,
  PRIMARY KEY (game_id)
);

CREATE TABLE game_request (
  game_id int NOT NULL AUTO_INCREMENT,
  game_name varchar(500) NOT NULL,
  game_average_rating double(2, 2) NOT NULL,
  game_number_of_ratings int NOT NULL,
  game_release_date date NOT NULL,
  game_cover_image varchar(500) NOT NULL,
  game_trailer varchar(500) NOT NULL,
  game_description varchar(5000) NOT NULL,
  game_status varchar(30) NOT NULL,
  PRIMARY KEY (game_id)
);

CREATE TABLE voice_actor (
  voice_actor_id int NOT NULL AUTO_INCREMENT,
  voice_actor_name varchar(500) NOT NULL,
  voice_actor_description varchar(5000) NOT NULL,
  voice_actor_picture varchar(500) NOT NULL,
  PRIMARY KEY (voice_actor_id)
);

CREATE TABLE voice_actor_request (
  voice_actor_id int NOT NULL AUTO_INCREMENT,
  voice_actor_name varchar(500) NOT NULL,
  voice_actor_description varchar(5000) NOT NULL,
  voice_actor_picture varchar(500) NOT NULL,
  PRIMARY KEY (voice_actor_id)
);

CREATE TABLE characters(
 character_id int NOT NULL AUTO_INCREMENT,
 character_name varchar(100) NOT NULL,
 character_picture varchar(2000) NOT NULL,
 character_description varchar(2000) NOT NULL,
 PRIMARY KEY (character_id)
);

CREATE TABLE characters_request(
 character_id int NOT NULL AUTO_INCREMENT,
 character_name varchar(100) NOT NULL,
 character_picture varchar(2000) NOT NULL,
 character_description varchar(2000) NOT NULL,
 voice_actor_name varchar(500) NOT NULL,
 PRIMARY KEY (character_id)
);

CREATE TABLE platform(
 platform_name varchar(50) NOT NULL,
 platform_manufacturer varchar(50) NOT NULL,
 position varchar(10),
 PRIMARY KEY (platform_name)
);


CREATE TABLE developer (
  developer_id int NOT NULL AUTO_INCREMENT,
  developer_name varchar(100) NOT NULL,
  developer_logo varchar(2000) NOT NULL,
  developer_description varchar(5000) NOT NULL,
  PRIMARY KEY (developer_id)
);
CREATE TABLE developer_request (
  developer_id int NOT NULL AUTO_INCREMENT,
  developer_name varchar(100) NOT NULL,
  developer_logo varchar(2000) NOT NULL,
  developer_description varchar(5000) NOT NULL,
  PRIMARY KEY (developer_id)
);

CREATE TABLE publisher (
  publisher_id int NOT NULL AUTO_INCREMENT,
  publisher_name varchar(100) NOT NULL,
  publisher_logo varchar(2000) NOT NULL,
  publisher_description varchar(5000) NOT NULL,
  PRIMARY KEY (publisher_id)
);

CREATE TABLE publisher_request (
  publisher_id int NOT NULL AUTO_INCREMENT,
  publisher_name varchar(100) NOT NULL,
  publisher_logo varchar(2000) NOT NULL,
  publisher_description varchar(5000) NOT NULL,
  PRIMARY KEY (publisher_id)
);

CREATE TABLE genre(
  genre_id int NOT NULL AUTO_INCREMENT,
  genre_name varchar(50) NOT NULL,
  PRIMARY KEY (genre_id)
);
CREATE TABLE genre_request(
  genre_id int NOT NULL AUTO_INCREMENT,
  genre_name varchar(50) NOT NULL,
  PRIMARY KEY (genre_id)
);

CREATE TABLE gameandgenre(
 game_id int NOT NULL,
 genre_id int NOT NULL
);

CREATE TABLE gameAndPlatform(
 platform_id int NOT NULL,
 game_id int NOT NULL
);

CREATE TABLE gameAndDeveloper(
 developer_id int NOT NULL,
 game_id int NOT NULL
);

CREATE TABLE gameAndPublisher(
 publisher_id int NOT NULL,
 game_id int NOT NULL
);

CREATE TABLE gameAndCharacters(
 character_id int NOT NULL,
 game_id int NOT NULL,
 voice_actor_id int NOT NULL
);

CREATE TABLE users (
  username varchar(20) NOT NULL,
  passwords varchar(50) NOT NULL,
  email varchar(40) NOT NULL,
  profile_picture varchar(2000) NOT NULL,
  descriptions varchar(1000) NOT NULL,
  gender bool NOT NULL,
  birth_date date NOT NULL,
  joined_date date NOT NULL,
  permission varchar(10) NOT NULL,
  PRIMARY KEY (email)
);

CREATE TABLE favorite_games (
  email varchar(40) NOT NULL,
  game_id int NOT NULL,
  FOREIGN KEY (email) REFERENCES users(email),
  FOREIGN KEY (game_id) REFERENCES game(game_id)
);

CREATE TABLE favorite_voice_actor (
  voice_actor_id int NOT NULL,
  email varchar(40) NOT NULL,
  FOREIGN KEY (email) REFERENCES users(email),
  FOREIGN KEY (voice_actor_id) REFERENCES voice_actor(voice_actor_id)
);

CREATE TABLE favorite_character (
  character_id int NOT NULL,
  email varchar(40) NOT NULL,
  FOREIGN KEY (character_id) REFERENCES characters(character_id),
  FOREIGN KEY (email) REFERENCES users(email)
);

CREATE TABLE friend (
  username varchar(20) NOT NULL,
  friend_username varchar(20) NOT NULL,
  status int NOT NULL
);

CREATE TABLE gamelist (
  gamelist_id int NOT NULL AUTO_INCREMENT,
  email varchar(40) NOT NULL,
  game_id int NOT NULL,
  rating int(2) NOT NULL,
  status varchar(20) NOT NULL,
  PRIMARY KEY (gamelist_id),
  FOREIGN KEY (game_id) REFERENCES game(game_id),
  FOREIGN KEY (email) REFERENCES users(email)
);

CREATE TABLE userfavgame(
  userfavgame_id int NOT NULL AUTO_INCREMENT,
  email varchar(40) NOT NULL,
  game_id int NOT NULL,
  PRIMARY KEY (userfavgame_id),
  FOREIGN KEY (game_id) REFERENCES game(game_id),
  FOREIGN KEY (email) REFERENCES users(email)
);


INSERT INTO genre(genre_name) VALUES ('Action');
INSERT INTO genre(genre_name) VALUES ('RPG');
INSERT INTO genre(genre_name) VALUES ('Adventure');
INSERT INTO genre(genre_name) VALUES ('Puzzle');
INSERT INTO genre(genre_name) VALUES ('Role-playing');
INSERT INTO genre(genre_name) VALUES ('Simulation');
INSERT INTO genre(genre_name) VALUES ('Strategy');
INSERT INTO genre(genre_name) VALUES ('Sport');


INSERT INTO game (game_name, game_average_rating, game_number_of_ratings, game_release_date, game_cover_image, game_trailer, game_description, game_status)
VALUES('Dying Light', 0.00, 0, '2015-01-27', 'Dying_Light.jpg', 'https://www.youtube.com/embed/CWX6DbAMTR4', 'Dying Light is a 2015 survival horror video game developed by Techland and published by Warner Bros. Interactive Entertainment. The games story follows an undercover agent named Kyle Crane who is sent to infiltrate a quarantine zone in a Middle-eastern city called Harran. It features an enemy-infested, open-world city with a dynamic day–night cycle, in which zombies are slow and clumsy during daytime but become extremely aggressive at night. The gameplay is focused on weapons-based combat and parkour, allowing players to choose fight or flight when presented with dangers. The game also features an asymmetrical multiplayer mode (originally set to be a pre-order bonus), and a four-player co-operative multiplayer mode.', 'Released');
INSERT INTO game (game_name, game_average_rating, game_number_of_ratings, game_release_date, game_cover_image, game_trailer, game_description, game_status)
VALUES('DOOM', 0.00, 0, '2016-05-13', 'Doom.jpg', 'https://www.youtube.com/embed/SgSrpnW0EmU', 'Doom is a 2016 first-person shooter game developed by id Software and published by Bethesda Softworks. It is the first major installment in the Doom series since 2004s Doom 3. Players take the role of an unnamed space marine, known as the "Doom Slayer", as he battles demonic forces from Hell that have been unleashed by the Union Aerospace Corporation within their energy-mining facility on Mars. The gameplay returns to a faster pace with more open-ended levels, closer to the first two games than the slower survival horror approach of Doom 3. It also features environment traversal, character upgrades, and the ability to perform executions known as "glory kills".', 'Released');
INSERT INTO game (game_name, game_average_rating, game_number_of_ratings, game_release_date, game_cover_image, game_trailer, game_description, game_status)
VALUES('Dishonored', 0.00, 0, '2012-10-09', 'Dishonored.jpg', 'https://www.youtube.com/embed/VeIn3WjbVbw', 'Dishonored is a 2012 action-adventure game developed by Arkane Studios and published by Bethesda Softworks. Set in the fictional, plague-ridden industrial city of Dunwall, Dishonored follows the story of Corvo Attano, bodyguard to the Empress of the Isles. He is framed for her murder and forced to become an assassin, seeking revenge on those who conspired against him. Corvo is aided in his quest by the Loyalists—a resistance group fighting to reclaim Dunwall, and the Outsider—a powerful being who imbues Corvo with magical abilities. Several noted actors including Susan Sarandon, Brad Dourif, Carrie Fisher, Michael Madsen, John Slattery, Lena Headey and Chloë Grace Moretz provided voice work for the game.', 'Released');
INSERT INTO game (game_name, game_average_rating, game_number_of_ratings, game_release_date, game_cover_image, game_trailer, game_description, game_status)
VALUES('Dishonored 2', 0.00, 0, '2016-11-11', 'Dishonored2.jpg', 'https://www.youtube.com/embed/l1jyUAtxh-8', 'Dishonored 2 is a 2016 action-adventure video game developed by Arkane Studios and published by Bethesda Softworks for Microsoft Windows, PlayStation 4, and Xbox One. It is the sequel to 2012s Dishonored. After Empress Emily Kaldwin is deposed by the witch Delilah Copperspoon, the player may choose between playing as either Emily or her Royal Protector and father Corvo Attano as they attempt to reclaim the throne. Emily and Corvo employ their own array of supernatural abilities, though the player can alternatively decide to forfeit these abilities altogether. Due to the games nonlinear gameplay, there are a multitude of ways to complete missions, from non-lethal stealth to purposeful violent conflict.', 'Released');
INSERT INTO game (game_name, game_average_rating, game_number_of_ratings, game_release_date, game_cover_image, game_trailer, game_description, game_status)
VALUES('Persona 5', 0.00, 0, '2016-09-15', 'Persona5.jpg', 'https://www.youtube.com/embed/QnDzJ9KzuV4', 'Persona 5 is a 2016 role-playing video game developed by Atlus. It is the sixth installment in the Persona series, which is part of the larger Megami Tensei franchise. It was released for the PlayStation 3 and PlayStation 4 in Japan in September 2016 and worldwide in April 2017, and was published by Atlus in Japan and North America and by Deep Silver in Europe and Australia. An enhanced version featuring new content, Persona 5 Royal, was released for the PlayStation 4 in Japan in October 2019 and worldwide in March 2020, published by Atlus in Japan and North America and by franchise owner Sega in Europe and Australia.', 'Released');
INSERT INTO game (game_name, game_average_rating, game_number_of_ratings, game_release_date, game_cover_image, game_trailer, game_description, game_status)
VALUES('Cities: Skylines', 0.00, 0, '2015-03-10', 'Cities_Skylines.jpg', 'https://www.youtube.com/embed/CpWe03NhXKs', 'Cities: Skylines is a 2015 city-building game developed by Colossal Order and published by Paradox Interactive. The game is a single-player open-ended city-building simulation. Players engage in urban planning by controlling zoning, road placement, taxation, public services, and public transportation of an area. They also work to manage various elements of the city, including its budget, health, employment, and pollution levels. It is also possible to maintain a city in a sandbox mode, which provides more creative freedom for the player.', 'Released');
INSERT INTO game (game_name, game_average_rating, game_number_of_ratings, game_release_date, game_cover_image, game_trailer, game_description, game_status)
VALUES('Payday 2', 0.00, 0, '2013-08-13', 'Payday2.jpg', 'https://www.youtube.com/embed/Z2tmHMIA1sU', 'Payday 2 is a cooperative first-person shooter video game developed by Overkill Software and published by 505 Games. The game is a sequel to 2011s Payday: The Heist. It was released in August 2013 for Windows, PlayStation 3 and Xbox 360. An improved version of the game, subtitled Crimewave Edition, was released for PlayStation 4 and Xbox One in June 2015. A version for the Nintendo Switch was released in February 2018.', 'Released');
INSERT INTO game (game_name, game_average_rating, game_number_of_ratings, game_release_date, game_cover_image, game_trailer, game_description, game_status)
VALUES('Saints Row IV', 0.00, 0, '2013-08-20', 'Saints_Row_IV.jpg', 'https://www.youtube.com/embed/0qhFgMRlgNo', 'Saints Row IV is a 2013 action-adventure game developed by Volition and published by Deep Silver. It is the sequel to 2011s Saints Row: The Third and the fourth installment in the Saints Row series. The game was released in August 2013 for Microsoft Windows, PlayStation 3, and Xbox 360, and was later ported to PlayStation 4, Xbox One, and Linux in 2015. A Nintendo Switch port was released on March 27, 2020 and a Google Stadia port was released on November 1, 2021.', 'Released');
INSERT INTO game (game_name, game_average_rating, game_number_of_ratings, game_release_date, game_cover_image, game_trailer, game_description, game_status)
VALUES('Tom Clancys Rainbow Six Siege', 0.00, 0, '2015-12-1', 'Tom_Clancys_Rainbow_Six_Siege.jpg', 'https://www.youtube.com/embed/6wlvYh0h63k', 'Tom Clancys Rainbow Six Siege is an online tactical shooter video game developed by Ubisoft Montreal and published by Ubisoft. It was released worldwide for Microsoft Windows, PlayStation 4, and Xbox One on December 1, 2015; the game was also released for PlayStation 5 and Xbox Series X and Series S exactly five years later on December 1, 2020. The game puts heavy emphasis on environmental destruction and cooperation between players. Each player assumes control of an attacker or a defender in different gameplay modes such as rescuing a hostage, defusing a bomb, and taking control of an objective within a room. The title has no campaign but features a series of short, offline missions called, "situations" that can be played solo. These missions have a loose narrative, focusing on recruits going through training to prepare them for future encounters with the "White Masks", a terrorist group that threatens the safety of the world.', 'Released');
INSERT INTO game (game_name, game_average_rating, game_number_of_ratings, game_release_date, game_cover_image, game_trailer, game_description, game_status)
VALUES('Thief', 0.00, 0, '2014-02-25', 'Thief.jpg', 'https://www.youtube.com/embed/LA9dgZuSe0w', 'Thief is a 2014 stealth video game developed by Eidos-Montréal and published by Square Enixs European subsidiary in February 2014 for Microsoft Windows, PlayStation 3, PlayStation 4, Xbox 360 and Xbox One video gaming platforms. Feral Interactive brought the game to macOS in November 2015.[10] It is a revival of the cult classic Thief video game series of which it is the fourth installment. Initially announced in 2009 as Thief 4, it was later announced in 2013 that the game is a reboot for the series.', 'Released');



CREATE TRIGGER UpdateGameAvgRatingAfterUpdate AFTER UPDATE ON gamelist
 FOR EACH ROW UPDATE game SET game_average_rating = (SELECT AVG(rating) FROM gamelist WHERE gamelist.game_id = game.game_id AND gamelist.rating != 0);

CREATE TRIGGER UpdateGameAvgRatingAfterInsert AFTER INSERT ON gamelist
 FOR EACH ROW UPDATE game SET game_average_rating = (SELECT AVG(gamelist.rating) FROM gamelist WHERE gamelist.game_id = game.game_id AND gamelist.rating != 0);

CREATE TRIGGER UpdateGameNumRatingAfterUpdate AFTER UPDATE ON gamelist
 FOR EACH ROW UPDATE game SET game_number_of_ratings = (SELECT COUNT(email) FROM gamelist WHERE gamelist.game_id = game.game_id AND gamelist.rating != 0);

CREATE TRIGGER UpdateGameNumRatingAfterInsert AFTER INSERT ON gamelist
 FOR EACH ROW UPDATE game SET game_number_of_ratings = (SELECT COUNT(gamelist.rating) FROM gamelist WHERE gamelist.game_id = game.game_id AND gamelist.rating != 0);

CREATE TRIGGER UpdateGameAvgRatingAfterDelete AFTER DELETE ON gamelist
 FOR EACH ROW UPDATE game SET game_average_rating = (SELECT AVG(gamelist.rating) FROM gamelist WHERE gamelist.game_id = game.game_id AND gamelist.rating != 0);

CREATE TRIGGER UpdateGameNumRatingAfterDelete AFTER DELETE ON gamelist
 FOR EACH ROW UPDATE game SET game_number_of_ratings = (SELECT COUNT(gamelist.rating) FROM gamelist WHERE gamelist.game_id = game.game_id AND gamelist.rating != 0);