SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL';

CREATE SCHEMA IF NOT EXISTS `dwallet` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ;
USE `dwallet` ;

-- -----------------------------------------------------
-- Table `dwallet`.`users`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `dwallet`.`users` (
  `id` SMALLINT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `email` VARCHAR(255) NOT NULL COMMENT 'eMail and username' ,
  `password` CHAR(40) NOT NULL COMMENT 'SHA1 password' ,
  `created` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Account expiration date' ,
  PRIMARY KEY (`id`) ,
  UNIQUE INDEX `email_UNIQUE` (`email` ASC) )
ENGINE = InnoDB
COMMENT = 'Apllication Users';


-- -----------------------------------------------------
-- Table `dwallet`.`folders`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `dwallet`.`folders` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `owner` SMALLINT UNSIGNED NOT NULL COMMENT 'The creator' ,
  `created` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ,
  `parent` INT UNSIGNED NULL COMMENT 'Parent folder (if any)' ,
  `name` VARCHAR(45) NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_folders_users1` (`owner` ASC) ,
  INDEX `fk_folders_folders1` (`parent` ASC) ,
  CONSTRAINT `fk_folders_users1`
    FOREIGN KEY (`owner` )
    REFERENCES `dwallet`.`users` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_folders_folders1`
    FOREIGN KEY (`parent` )
    REFERENCES `dwallet`.`folders` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
COMMENT = 'Containers for passwords or other folders';


-- -----------------------------------------------------
-- Table `dwallet`.`passwords`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `dwallet`.`passwords` (
  `id` INT UNSIGNED NULL AUTO_INCREMENT ,
  `owner` SMALLINT UNSIGNED NOT NULL COMMENT 'The user who created this entry' ,
  `created` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ,
  `username` VARCHAR(255) NULL ,
  `url` VARCHAR(255) NULL ,
  `password` TEXT NULL ,
  `note` TEXT NULL ,
  `folder` INT UNSIGNED NULL COMMENT 'Container (if any)' ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_passwords_users` (`owner` ASC) ,
  INDEX `fk_passwords_folders1` (`folder` ASC) ,
  CONSTRAINT `fk_passwords_users`
    FOREIGN KEY (`owner` )
    REFERENCES `dwallet`.`users` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_passwords_folders1`
    FOREIGN KEY (`folder` )
    REFERENCES `dwallet`.`folders` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
COMMENT = 'Passwords';



SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
