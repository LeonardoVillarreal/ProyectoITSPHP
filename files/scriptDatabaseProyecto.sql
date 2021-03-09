-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema mydb
-- -----------------------------------------------------
-- -----------------------------------------------------
-- Schema dbsistema
-- -----------------------------------------------------
DROP SCHEMA IF EXISTS `dbsistema` ;

-- -----------------------------------------------------
-- Schema dbsistema
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `dbsistema` DEFAULT CHARACTER SET utf8 ;
USE `dbsistema` ;

-- -----------------------------------------------------
-- Table `dbsistema`.`categoria`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dbsistema`.`categoria` (
  `idcategoria` INT NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(50) NOT NULL,
  `descripcion` VARCHAR(256) NULL DEFAULT NULL,
  `condicion` TINYINT(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`idcategoria`),
  UNIQUE INDEX `nombre_UNIQUE` (`nombre` ASC) VISIBLE)
ENGINE = InnoDB
AUTO_INCREMENT = 5
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `dbsistema`.`articulo`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dbsistema`.`articulo` (
  `idarticulo` INT NOT NULL AUTO_INCREMENT,
  `idcategoria` INT NOT NULL,
  `codigo` VARCHAR(50) NULL DEFAULT NULL,
  `nombre` VARCHAR(100) NOT NULL,
  `stock` INT NOT NULL,
  `descripcion` VARCHAR(256) NULL DEFAULT NULL,
  `imagen` VARCHAR(50) NULL DEFAULT NULL,
  `condicion` TINYINT(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`idarticulo`),
  UNIQUE INDEX `nombre_UNIQUE` (`nombre` ASC) VISIBLE,
  INDEX `fk_articulo_categoria_idx` (`idcategoria` ASC) VISIBLE,
  CONSTRAINT `fk_articulo_categoria`
    FOREIGN KEY (`idcategoria`)
    REFERENCES `dbsistema`.`categoria` (`idcategoria`))
ENGINE = InnoDB
AUTO_INCREMENT = 4
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `dbsistema`.`persona`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dbsistema`.`persona` (
  `idpersona` INT NOT NULL AUTO_INCREMENT,
  `tipo_persona` VARCHAR(20) NOT NULL,
  `nombre` VARCHAR(100) NOT NULL,
  `tipo_documento` VARCHAR(20) NULL DEFAULT NULL,
  `num_documento` VARCHAR(20) NULL DEFAULT NULL,
  `direccion` VARCHAR(70) NULL DEFAULT NULL,
  `telefono` VARCHAR(20) NULL DEFAULT NULL,
  `email` VARCHAR(50) NULL DEFAULT NULL,
  `condicion` TINYINT(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`idpersona`))
ENGINE = InnoDB
AUTO_INCREMENT = 6
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `dbsistema`.`usuario`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dbsistema`.`usuario` (
  `idusuario` INT NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(100) NOT NULL,
  `tipo_documento` VARCHAR(20) NOT NULL,
  `num_documento` VARCHAR(20) NOT NULL,
  `direccion` VARCHAR(70) NULL DEFAULT NULL,
  `telefono` VARCHAR(20) NULL DEFAULT NULL,
  `email` VARCHAR(50) NULL DEFAULT NULL,
  `cargo` VARCHAR(20) NULL DEFAULT NULL,
  `login` VARCHAR(20) NOT NULL,
  `clave` VARCHAR(64) NOT NULL,
  `imagen` VARCHAR(50) NULL DEFAULT NULL,
  `condicion` TINYINT(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`idusuario`),
  UNIQUE INDEX `login_UNIQUE` (`login` ASC) VISIBLE)
ENGINE = InnoDB
AUTO_INCREMENT = 5
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `dbsistema`.`ingreso`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dbsistema`.`ingreso` (
  `idingreso` INT NOT NULL AUTO_INCREMENT,
  `idproveedor` INT NOT NULL,
  `idusuario` INT NOT NULL,
  `tipo_comprobante` VARCHAR(20) NOT NULL,
  `serie_comprobante` VARCHAR(7) NULL DEFAULT NULL,
  `num_comprobante` VARCHAR(10) NOT NULL,
  `fecha_hora` DATETIME NOT NULL,
  `impuesto` DECIMAL(4,2) NOT NULL,
  `total_compra` DECIMAL(11,2) NOT NULL,
  `estado` VARCHAR(25) NOT NULL,
  PRIMARY KEY (`idingreso`),
  INDEX `fk_ingreso_persona_idx` (`idproveedor` ASC) VISIBLE,
  INDEX `fk_ingreso_usuario_idx` (`idusuario` ASC) VISIBLE,
  CONSTRAINT `fk_ingreso_persona`
    FOREIGN KEY (`idproveedor`)
    REFERENCES `dbsistema`.`persona` (`idpersona`),
  CONSTRAINT `fk_ingreso_usuario`
    FOREIGN KEY (`idusuario`)
    REFERENCES `dbsistema`.`usuario` (`idusuario`))
ENGINE = InnoDB
AUTO_INCREMENT = 6
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `dbsistema`.`detalle_ingreso`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dbsistema`.`detalle_ingreso` (
  `iddetalle_ingreso` INT NOT NULL AUTO_INCREMENT,
  `idingreso` INT NOT NULL,
  `idarticulo` INT NOT NULL,
  `cantidad` INT NOT NULL,
  `precio_compra` DECIMAL(11,2) NOT NULL,
  `precio_venta` DECIMAL(11,2) NOT NULL,
  `condicion` TINYINT(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`iddetalle_ingreso`),
  INDEX `fk_detalle_ingreso_ingreso_idx` (`idingreso` ASC) VISIBLE,
  INDEX `fk_detalle_ingreso_articulo_idx` (`idarticulo` ASC) VISIBLE,
  CONSTRAINT `fk_detalle_ingreso_articulo`
    FOREIGN KEY (`idarticulo`)
    REFERENCES `dbsistema`.`articulo` (`idarticulo`),
  CONSTRAINT `fk_detalle_ingreso_ingreso`
    FOREIGN KEY (`idingreso`)
    REFERENCES `dbsistema`.`ingreso` (`idingreso`))
ENGINE = InnoDB
AUTO_INCREMENT = 3
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `dbsistema`.`venta`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dbsistema`.`venta` (
  `idventa` INT NOT NULL AUTO_INCREMENT,
  `idcliente` INT NOT NULL,
  `idusuario` INT NOT NULL,
  `tipo_comprobante` VARCHAR(20) NOT NULL,
  `serie_comprobante` VARCHAR(7) NULL DEFAULT NULL,
  `num_comprobante` VARCHAR(10) NOT NULL,
  `fecha_hora` DATETIME NOT NULL,
  `impuesto` DECIMAL(4,2) NOT NULL,
  `total_venta` DECIMAL(11,2) NOT NULL,
  `condicion` TINYINT(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`idventa`),
  INDEX `fk_venta_persona_idx` (`idcliente` ASC) VISIBLE,
  INDEX `fk_venta_usuario_idx` (`idusuario` ASC) VISIBLE,
  CONSTRAINT `fk_venta_persona`
    FOREIGN KEY (`idcliente`)
    REFERENCES `dbsistema`.`persona` (`idpersona`),
  CONSTRAINT `fk_venta_usuario`
    FOREIGN KEY (`idusuario`)
    REFERENCES `dbsistema`.`usuario` (`idusuario`))
ENGINE = InnoDB
AUTO_INCREMENT = 3
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `dbsistema`.`detalle_venta`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dbsistema`.`detalle_venta` (
  `iddetalle_venta` INT NOT NULL AUTO_INCREMENT,
  `idventa` INT NOT NULL,
  `idarticulo` INT NOT NULL,
  `cantidad` INT NOT NULL,
  `precio_venta` DECIMAL(11,2) NOT NULL,
  `descuento` DECIMAL(11,2) NOT NULL,
  `condicion` TINYINT(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`iddetalle_venta`),
  INDEX `fk_detalle_venta_venta_idx` (`idventa` ASC) VISIBLE,
  INDEX `fk_detalle_venta_articulo_idx` (`idarticulo` ASC) VISIBLE,
  CONSTRAINT `fk_detalle_venta_articulo`
    FOREIGN KEY (`idarticulo`)
    REFERENCES `dbsistema`.`articulo` (`idarticulo`),
  CONSTRAINT `fk_detalle_venta_venta`
    FOREIGN KEY (`idventa`)
    REFERENCES `dbsistema`.`venta` (`idventa`))
ENGINE = InnoDB
AUTO_INCREMENT = 3
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `dbsistema`.`permiso`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dbsistema`.`permiso` (
  `idpermiso` INT NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(30) NOT NULL,
  PRIMARY KEY (`idpermiso`))
ENGINE = InnoDB
AUTO_INCREMENT = 8
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `dbsistema`.`usuario_permiso`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dbsistema`.`usuario_permiso` (
  `idusuario_permiso` INT NOT NULL AUTO_INCREMENT,
  `idusuario` INT NOT NULL,
  `idpermiso` INT NOT NULL,
  PRIMARY KEY (`idusuario_permiso`),
  INDEX `fk_usuario_permiso_permiso_idx` (`idpermiso` ASC) VISIBLE,
  INDEX `fk_usuario_permiso_usuario_idx` (`idusuario` ASC) VISIBLE,
  CONSTRAINT `fk_usuario_permiso_permiso`
    FOREIGN KEY (`idpermiso`)
    REFERENCES `dbsistema`.`permiso` (`idpermiso`),
  CONSTRAINT `fk_usuario_permiso_usuario`
    FOREIGN KEY (`idusuario`)
    REFERENCES `dbsistema`.`usuario` (`idusuario`))
ENGINE = InnoDB
AUTO_INCREMENT = 5
DEFAULT CHARACTER SET = utf8;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
