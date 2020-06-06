-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema mydb
-- -----------------------------------------------------
-- -----------------------------------------------------
-- Schema dbtravler
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema dbtravler
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `dbtravler` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci ;
USE `dbtravler` ;

-- -----------------------------------------------------
-- Table `dbtravler`.`countries`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dbtravler`.`countries` (
  `ISO2` VARCHAR(2) NOT NULL,
  `NAME` VARCHAR(50) NOT NULL,
  PRIMARY KEY (`ISO2`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_0900_ai_ci;


-- -----------------------------------------------------
-- Table `dbtravler`.`status`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dbtravler`.`status` (
  `ID` INT NOT NULL,
  `STATUS` VARCHAR(20) NOT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE INDEX `STATUS_UNIQUE` (`STATUS` ASC) VISIBLE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_0900_ai_ci;


-- -----------------------------------------------------
-- Table `dbtravler`.`roles`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dbtravler`.`roles` (
  `ID` INT NOT NULL,
  `ROLE` VARCHAR(20) NOT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE INDEX `ROLE_UNIQUE` (`ROLE` ASC) VISIBLE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_0900_ai_ci;


-- -----------------------------------------------------
-- Table `dbtravler`.`users`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dbtravler`.`users` (
  `ID` INT NOT NULL AUTO_INCREMENT,
  `EMAIL` VARCHAR(45) NOT NULL,
  `NICKNAME` VARCHAR(45) NOT NULL,
  `PASSWORD` VARCHAR(255) NOT NULL,
  `TOKEN` VARCHAR(64) NOT NULL,
  `NAME` VARCHAR(45) NULL DEFAULT NULL,
  `SURNAME` VARCHAR(45) NULL DEFAULT NULL,
  `BIO` MEDIUMTEXT NULL DEFAULT NULL,
  `AVATAR` LONGTEXT NOT NULL,
  `STATUS_ID` INT NOT NULL,
  `ROLES_ID` INT NOT NULL,
  `COUNTRIES_ISO2` VARCHAR(2) NULL DEFAULT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE INDEX `UNIQUE` (`EMAIL` ASC, `NICKNAME` ASC) VISIBLE,
  UNIQUE INDEX `EMAIL_UNIQUE` (`EMAIL` ASC) VISIBLE,
  UNIQUE INDEX `NICKNAME_UNIQUE` (`NICKNAME` ASC) VISIBLE,
  INDEX `STATUS_ID` (`STATUS_ID` ASC) VISIBLE,
  INDEX `ROLES_ID` (`ROLES_ID` ASC) VISIBLE,
  INDEX `fk_USERS_COUNTRIES1_idx` (`COUNTRIES_ISO2` ASC) VISIBLE,
  CONSTRAINT `fk_USERS_COUNTRIES1`
    FOREIGN KEY (`COUNTRIES_ISO2`)
    REFERENCES `dbtravler`.`countries` (`ISO2`),
  CONSTRAINT `fk_USERS_ROLES1`
    FOREIGN KEY (`ROLES_ID`)
    REFERENCES `dbtravler`.`roles` (`ID`),
  CONSTRAINT `fk_USERS_STATUS1`
    FOREIGN KEY (`STATUS_ID`)
    REFERENCES `dbtravler`.`status` (`ID`))
ENGINE = InnoDB
AUTO_INCREMENT = 39
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_0900_ai_ci;


-- -----------------------------------------------------
-- Table `dbtravler`.`itinerary`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dbtravler`.`itinerary` (
  `ID` INT NOT NULL AUTO_INCREMENT,
  `TITLE` VARCHAR(45) NOT NULL,
  `RATING` DOUBLE(2,1) NULL DEFAULT NULL,
  `DESCRIPTION` MEDIUMTEXT NOT NULL,
  `DURATION` TIME NOT NULL,
  `DISTANCE` DECIMAL(6,2) NOT NULL,
  `PREVIEW` LONGTEXT NOT NULL,
  `COUNTRIES_ISO2` VARCHAR(2) NOT NULL,
  `STATUS_ID` INT NOT NULL,
  `USERS_ID` INT NOT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE INDEX `TITLE_UNIQUE` (`TITLE` ASC) VISIBLE,
  INDEX `COUNTRIES_ISO2` (`COUNTRIES_ISO2` ASC) VISIBLE,
  INDEX `STATUS_ID` (`STATUS_ID` ASC) VISIBLE,
  INDEX `USER_ID` (`USERS_ID` ASC) VISIBLE,
  CONSTRAINT `fk_ITINERARY_COUNTRIES`
    FOREIGN KEY (`COUNTRIES_ISO2`)
    REFERENCES `dbtravler`.`countries` (`ISO2`),
  CONSTRAINT `fk_ITINERARY_STATUS1`
    FOREIGN KEY (`STATUS_ID`)
    REFERENCES `dbtravler`.`status` (`ID`),
  CONSTRAINT `fk_ITINERARY_USERS1`
    FOREIGN KEY (`USERS_ID`)
    REFERENCES `dbtravler`.`users` (`ID`))
ENGINE = InnoDB
AUTO_INCREMENT = 16
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_0900_ai_ci;


-- -----------------------------------------------------
-- Table `dbtravler`.`comments`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dbtravler`.`comments` (
  `COMMENT` MEDIUMTEXT NOT NULL,
  `COMMENT_DATE` TIMESTAMP NOT NULL,
  `USERS_ID` INT NOT NULL,
  `ITINERARY_ID` INT NOT NULL,
  PRIMARY KEY (`USERS_ID`, `ITINERARY_ID`),
  UNIQUE INDEX `UNIQUE` (`COMMENT_DATE` ASC, `USERS_ID` ASC) INVISIBLE,
  INDEX `fk_COMMENTS_USERS1_idx` (`USERS_ID` ASC) VISIBLE,
  INDEX `fk_COMMENTS_ITINERARY1_idx` (`ITINERARY_ID` ASC) VISIBLE,
  CONSTRAINT `fk_COMMENTS_ITINERARY1`
    FOREIGN KEY (`ITINERARY_ID`)
    REFERENCES `dbtravler`.`itinerary` (`ID`),
  CONSTRAINT `fk_COMMENTS_USERS1`
    FOREIGN KEY (`USERS_ID`)
    REFERENCES `dbtravler`.`users` (`ID`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_0900_ai_ci;


-- -----------------------------------------------------
-- Table `dbtravler`.`photos`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dbtravler`.`photos` (
  `ID` INT NOT NULL AUTO_INCREMENT,
  `IMAGE` LONGTEXT NOT NULL,
  `ITINERARY_ID` INT NOT NULL,
  PRIMARY KEY (`ID`),
  INDEX `fk_PHOTOS_ITINERARY1_idx` (`ITINERARY_ID` ASC) VISIBLE,
  CONSTRAINT `fk_PHOTOS_ITINERARY1`
    FOREIGN KEY (`ITINERARY_ID`)
    REFERENCES `dbtravler`.`itinerary` (`ID`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_0900_ai_ci;


-- -----------------------------------------------------
-- Table `dbtravler`.`rating`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dbtravler`.`rating` (
  `RATE` INT NOT NULL,
  `ITINERARY_ID` INT NOT NULL,
  `USERS_ID` INT NOT NULL,
  PRIMARY KEY (`USERS_ID`, `ITINERARY_ID`),
  UNIQUE INDEX `UNIQUE` (`ITINERARY_ID` ASC, `USERS_ID` ASC) INVISIBLE,
  INDEX `fk_RATING_ITINERARY1_idx` (`ITINERARY_ID` ASC) VISIBLE,
  INDEX `fk_RATING_USERS1_idx` (`USERS_ID` ASC) VISIBLE,
  CONSTRAINT `fk_RATING_ITINERARY1`
    FOREIGN KEY (`ITINERARY_ID`)
    REFERENCES `dbtravler`.`itinerary` (`ID`),
  CONSTRAINT `fk_RATING_USERS1`
    FOREIGN KEY (`USERS_ID`)
    REFERENCES `dbtravler`.`users` (`ID`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_0900_ai_ci;


-- -----------------------------------------------------
-- Table `dbtravler`.`waypoints`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dbtravler`.`waypoints` (
  `ITINERARY_ID` INT NOT NULL,
  `INDEX` INT NOT NULL,
  `ADDRESS` VARCHAR(100) NOT NULL,
  `LONGITUDE` DECIMAL(9,6) NOT NULL,
  `LATITUDE` DECIMAL(9,6) NOT NULL,
  PRIMARY KEY (`INDEX`, `ITINERARY_ID`),
  UNIQUE INDEX `ID_UNIQUE` (`LONGITUDE` ASC, `LATITUDE` ASC) VISIBLE,
  INDEX `fk_WAYPOINTS_ITINERARY1_idx` (`ITINERARY_ID` ASC) VISIBLE,
  CONSTRAINT `fk_WAYPOINTS_ITINERARY1`
    FOREIGN KEY (`ITINERARY_ID`)
    REFERENCES `dbtravler`.`itinerary` (`ID`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_0900_ai_ci;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
