-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema mecanica
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema mecanica
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `mecanica` DEFAULT CHARACTER SET utf8 ;
USE `mecanica` ;

-- -----------------------------------------------------
-- Table `mecanica`.`usuario`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mecanica`.`usuario` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(45) NOT NULL,
  `email` VARCHAR(45) NOT NULL,
  `login` VARCHAR(45) NOT NULL,
  `senha` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mecanica`.`material`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mecanica`.`material` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `descricao` VARCHAR(50) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mecanica`.`eletrodo`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mecanica`.`eletrodo` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `descricao` VARCHAR(50) NOT NULL,
  `material_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_eletrodo_material` (`material_id` ASC),
  CONSTRAINT `fk_eletrodo_material`
    FOREIGN KEY (`material_id`)
    REFERENCES `mecanica`.`material` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mecanica`.`operacao`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mecanica`.`operacao` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `descricao` VARCHAR(50) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mecanica`.`ponto`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mecanica`.`ponto` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `valor_corrente` DECIMAL(10,3) NOT NULL,
  `valor_desgaste` DECIMAL(10,3) NOT NULL,
  `valor_remocao` DECIMAL(10,3) NOT NULL,
  `valor_rugosidade` DECIMAL(10,3) NOT NULL,
  `polaridade` INT NOT NULL,
  `eletrodo_id` INT NOT NULL,
  `operacao_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_ponto_eletrodo` (`eletrodo_id` ASC),
  INDEX `fk_ponto_operacao` (`operacao_id` ASC),
  CONSTRAINT `fk_ponto_eletrodo`
    FOREIGN KEY (`eletrodo_id`)
    REFERENCES `mecanica`.`eletrodo` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_ponto_operacao`
    FOREIGN KEY (`operacao_id`)
    REFERENCES `mecanica`.`operacao` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
