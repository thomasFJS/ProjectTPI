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
-- Table `dbtravler`.`STATUS`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dbtravler`.`STATUS` (
  `ID` INT NOT NULL,
  `STATUS` VARCHAR(20) NOT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE INDEX `ID_UNIQUE` (`ID` ASC) VISIBLE,
  UNIQUE INDEX `STATUS_UNIQUE` (`STATUS` ASC) VISIBLE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `dbtravler`.`ROLES`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dbtravler`.`ROLES` (
  `ID` INT NOT NULL,
  `ROLE` VARCHAR(20) NOT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE INDEX `ID_UNIQUE` (`ID` ASC) VISIBLE,
  UNIQUE INDEX `ROLE_UNIQUE` (`ROLE` ASC) VISIBLE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `dbtravler`.`USERS`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dbtravler`.`USERS` (
  `ID` INT NOT NULL AUTO_INCREMENT,
  `EMAIL` VARCHAR(45) NOT NULL,
  `NICKNAME` VARCHAR(45) NOT NULL,
  `PASSWORD` VARCHAR(64) NOT NULL,
  `TOKEN` VARCHAR(64) NOT NULL,
  `NAME` VARCHAR(45) NULL,
  `SURNAME` VARCHAR(45) NULL,
  `BIO` VARCHAR(255) NULL,
  `AVATAR` LONGTEXT NULL,
  `STATUS_ID` INT NOT NULL,
  `ROLES_ID` INT NOT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE INDEX `ID_UNIQUE` (`ID` ASC) VISIBLE,
  UNIQUE INDEX `EMAIL_UNIQUE` (`EMAIL` ASC) VISIBLE,
  UNIQUE INDEX `NICKNAME_UNIQUE` (`NICKNAME` ASC) VISIBLE,
  INDEX `fk_USERS_STATUS1_idx` (`STATUS_ID` ASC) VISIBLE,
  INDEX `fk_USERS_ROLES1_idx` (`ROLES_ID` ASC) VISIBLE,
  CONSTRAINT `fk_USERS_STATUS1`
    FOREIGN KEY (`STATUS_ID`)
    REFERENCES `dbtravler`.`STATUS` (`ID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_USERS_ROLES1`
    FOREIGN KEY (`ROLES_ID`)
    REFERENCES `dbtravler`.`ROLES` (`ID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `dbtravler`.`COUNTRIES`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dbtravler`.`COUNTRIES` (
  `ISO2` VARCHAR(2) NOT NULL,
  `NAME` VARCHAR(50) NOT NULL,
  PRIMARY KEY (`ISO2`),
  UNIQUE INDEX `ISO2_UNIQUE` (`ISO2` ASC) VISIBLE,
  UNIQUE INDEX `NAME_UNIQUE` (`NAME` ASC) VISIBLE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `dbtravler`.`ITINERARY`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dbtravler`.`ITINERARY` (
  `ID` INT NOT NULL AUTO_INCREMENT,
  `TITLE` VARCHAR(45) NOT NULL,
  `RATING` INT(2) NOT NULL,
  `DESCRIPTION` VARCHAR(255) NOT NULL,
  `DURATION` TIME NOT NULL,
  `DISTANCE` DECIMAL(4,2) NOT NULL,
  `COUNTRIES_ISO2` VARCHAR(2) NOT NULL,
  `STATUS_ID` INT NOT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE INDEX `ID_UNIQUE` (`ID` ASC) VISIBLE,
  INDEX `fk_ITINERARY_COUNTRIES_idx` (`COUNTRIES_ISO2` ASC) VISIBLE,
  INDEX `fk_ITINERARY_STATUS1_idx` (`STATUS_ID` ASC) VISIBLE,
  CONSTRAINT `fk_ITINERARY_COUNTRIES`
    FOREIGN KEY (`COUNTRIES_ISO2`)
    REFERENCES `dbtravler`.`COUNTRIES` (`ISO2`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_ITINERARY_STATUS1`
    FOREIGN KEY (`STATUS_ID`)
    REFERENCES `dbtravler`.`STATUS` (`ID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `dbtravler`.`WAYPOINTS`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dbtravler`.`WAYPOINTS` (
  `ID` INT NOT NULL AUTO_INCREMENT,
  `PLACEMENTS` INT(3) NOT NULL,
  `ADDRESS` VARCHAR(45) NOT NULL,
  `LONGITUDE` DECIMAL(9,6) NOT NULL,
  `LATITUDE` DECIMAL(9,6) NOT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE INDEX `ID_UNIQUE` (`ID` ASC) VISIBLE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `dbtravler`.`COMMENTS`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dbtravler`.`COMMENTS` (
  `ID` INT NOT NULL AUTO_INCREMENT,
  `COMMENT` VARCHAR(45) NOT NULL,
  `DATE` TIMESTAMP NOT NULL,
  `USERS_ID` INT NOT NULL,
  PRIMARY KEY (`ID`),
  INDEX `fk_COMMENTS_USERS1_idx` (`USERS_ID` ASC) VISIBLE,
  UNIQUE INDEX `ID_UNIQUE` (`ID` ASC) VISIBLE,
  CONSTRAINT `fk_COMMENTS_USERS1`
    FOREIGN KEY (`USERS_ID`)
    REFERENCES `dbtravler`.`USERS` (`ID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `dbtravler`.`RATING`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dbtravler`.`RATING` (
  `ID` INT NOT NULL AUTO_INCREMENT,
  `RATE` INT(2) NOT NULL,
  `ITINERARY_ID` INT NOT NULL,
  `USERS_ID` INT NOT NULL,
  PRIMARY KEY (`ID`),
  INDEX `fk_RATING_ITINERARY1_idx` (`ITINERARY_ID` ASC) VISIBLE,
  INDEX `fk_RATING_USERS1_idx` (`USERS_ID` ASC) VISIBLE,
  UNIQUE INDEX `ID_UNIQUE` (`ID` ASC) VISIBLE,
  CONSTRAINT `fk_RATING_ITINERARY1`
    FOREIGN KEY (`ITINERARY_ID`)
    REFERENCES `dbtravler`.`ITINERARY` (`ID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_RATING_USERS1`
    FOREIGN KEY (`USERS_ID`)
    REFERENCES `dbtravler`.`USERS` (`ID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `dbtravler`.`ITINERARY_HAS_WAYPOINTS`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dbtravler`.`ITINERARY_HAS_WAYPOINTS` (
  `ITINERARY_ID` INT NOT NULL,
  `WAYPOINTS_ID` INT NOT NULL,
  PRIMARY KEY (`ITINERARY_ID`, `WAYPOINTS_ID`),
  INDEX `fk_ITINERARY_has_WAYPOINTS_WAYPOINTS1_idx` (`WAYPOINTS_ID` ASC) VISIBLE,
  INDEX `fk_ITINERARY_has_WAYPOINTS_ITINERARY1_idx` (`ITINERARY_ID` ASC) VISIBLE,
  CONSTRAINT `fk_ITINERARY_has_WAYPOINTS_ITINERARY1`
    FOREIGN KEY (`ITINERARY_ID`)
    REFERENCES `dbtravler`.`ITINERARY` (`ID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_ITINERARY_has_WAYPOINTS_WAYPOINTS1`
    FOREIGN KEY (`WAYPOINTS_ID`)
    REFERENCES `dbtravler`.`WAYPOINTS` (`ID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `dbtravler`.`PHOTOS`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dbtravler`.`PHOTOS` (
  `ID` INT NOT NULL,
  `IMAGE` LONGTEXT NOT NULL,
  `ITINERARY_ID` INT NOT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE INDEX `ID_UNIQUE` (`ID` ASC) VISIBLE,
  INDEX `fk_PHOTOS_ITINERARY1_idx` (`ITINERARY_ID` ASC) VISIBLE,
  CONSTRAINT `fk_PHOTOS_ITINERARY1`
    FOREIGN KEY (`ITINERARY_ID`)
    REFERENCES `dbtravler`.`ITINERARY` (`ID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
