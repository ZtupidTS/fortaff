SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL';

CREATE SCHEMA IF NOT EXISTS `pwjre_jo2012` DEFAULT CHARACTER SET utf8 ;
SHOW WARNINGS;
USE `pwjre_jo2012` ;

-- -----------------------------------------------------
-- Table `eventos`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `eventos` (
  `cod_eventos` INT NOT NULL AUTO_INCREMENT ,
  `designacao` VARCHAR(30) NOT NULL ,
  `descricao` VARCHAR(45) NOT NULL ,
  `data` DATE NOT NULL ,
  `hora` TIME NOT NULL ,
  `duracao_estimada` TIME NOT NULL ,
  `preco` DECIMAL(3,2) NOT NULL ,
  `lugares_total` INT NOT NULL ,
  `lugares_reservados` INT NULL ,
  `classificacao_media` DECIMAL(1,1) NULL ,
  PRIMARY KEY (`cod_eventos`) )
ENGINE = InnoDB;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `classificacao_eventos`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `classificacao_eventos` (
  `cod_eventos` INT NOT NULL ,
  `classificacao` INT NOT NULL ,
  PRIMARY KEY (`cod_eventos`) )
ENGINE = InnoDB;

SHOW WARNINGS;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
