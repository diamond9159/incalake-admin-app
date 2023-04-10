-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Table idioma
-- -----------------------------------------------------
DROP TABLE IF EXISTS idioma ;

CREATE TABLE IF NOT EXISTS idioma (
  id_idioma INT(11) NOT NULL AUTO_INCREMENT,
  pais VARCHAR(128) NULL,
  codigo VARCHAR(2) NULL,
  PRIMARY KEY (id_idioma))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table pagina_web
-- -----------------------------------------------------
DROP TABLE IF EXISTS pagina_web ;

CREATE TABLE IF NOT EXISTS pagina_web (
  id_pagina INT(11) NOT NULL AUTO_INCREMENT,
  url_pagina VARCHAR(255) NULL,
  titulo_pagina VARCHAR(255) NULL,
  descripcion_pagina TEXT NULL,
  imagen_principal VARCHAR(255) NULL,
  ver_slider TINYINT NULL,
  miniatura_pagina VARCHAR(255) NULL,
  valoracion_pagina DECIMAL(3,2) NULL,
  reviews_pagina TEXT NULL,
  id_codigo_pagina INT NULL,
  ubicacion_servicio VARCHAR(255) NULL,
  uri_pagina VARCHAR(255) NULL,
  fecha DATETIME NULL,
  id_idioma INT(11) NOT NULL,
  PRIMARY KEY (id_pagina, id_idioma),
  INDEX fk_pagina_web_idioma1_idx (id_idioma ASC),
  CONSTRAINT fk_pagina_web_idioma1
    FOREIGN KEY (id_idioma)
    REFERENCES idioma (id_idioma)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table codigo_bus
-- -----------------------------------------------------
DROP TABLE IF EXISTS codigo_bus ;

CREATE TABLE IF NOT EXISTS codigo_bus (
  id_codigo_bus INT NOT NULL AUTO_INCREMENT,
  codigo_bus VARCHAR(45) NULL,
  PRIMARY KEY (id_codigo_bus))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table empresa
-- -----------------------------------------------------
DROP TABLE IF EXISTS empresa ;

CREATE TABLE IF NOT EXISTS empresa (
  id_empresa INT NOT NULL AUTO_INCREMENT,
  nombre_empresa VARCHAR(200) NULL,
  logo_empresa INT NULL,
  PRIMARY KEY (id_empresa))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table servicio
-- -----------------------------------------------------
DROP TABLE IF EXISTS servicio ;

CREATE TABLE IF NOT EXISTS servicio (
  id_servicio INT NOT NULL AUTO_INCREMENT,
  nombre_servicio VARCHAR(45) NULL,
  descripcion_servicio VARCHAR(45) NULL,
  id_idioma INT(11) NOT NULL,
  PRIMARY KEY (id_servicio, id_idioma),
  INDEX fk_servicio_idioma1_idx (id_idioma ASC),
  CONSTRAINT fk_servicio_idioma1
    FOREIGN KEY (id_idioma)
    REFERENCES idioma (id_idioma)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table bus
-- -----------------------------------------------------
DROP TABLE IF EXISTS bus ;

CREATE TABLE IF NOT EXISTS bus (
  id_bus INT NOT NULL AUTO_INCREMENT,
  titulo_bus VARCHAR(255) NULL,
  subtitulo_bus VARCHAR(255) NULL,
  id_codigo_bus INT NOT NULL,
  estado_bus TINYINT NULL,
  politicas_bus MEDIUMTEXT NULL,
  hora_anticipacion INT NULL,
  requerimiento_datos TINYINT NULL,
  fecha DATETIME NULL,
  tipo_recojo CHAR(9) NULL,
  sub_tipo_recojo CHAR(9) NULL,
  lugar_recojo TEXT NULL,
  requerir_disponibilidad TINYINT NULL,
  tasas_impuestos DECIMAL(5,2) NULL,
  id_pagina INT(11) NOT NULL,
  id_empresa INT NOT NULL,
  id_servicio INT NOT NULL,
  PRIMARY KEY (id_bus, id_codigo_bus, id_pagina, id_empresa, id_servicio),
  INDEX fk_bus_codigo_bus1_idx (id_codigo_bus ASC),
  INDEX fk_bus_pagina_web1_idx (id_pagina ASC),
  INDEX fk_bus_empresa1_idx (id_empresa ASC),
  INDEX fk_bus_servicio1_idx (id_servicio ASC),
  CONSTRAINT fk_bus_codigo_bus1
    FOREIGN KEY (id_codigo_bus)
    REFERENCES codigo_bus (id_codigo_bus)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT fk_bus_pagina_web1
    FOREIGN KEY (id_pagina)
    REFERENCES pagina_web (id_pagina)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT fk_bus_empresa1
    FOREIGN KEY (id_empresa)
    REFERENCES empresa (id_empresa)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT fk_bus_servicio1
    FOREIGN KEY (id_servicio)
    REFERENCES servicio (id_servicio)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table horarios
-- -----------------------------------------------------
DROP TABLE IF EXISTS horarios ;

CREATE TABLE IF NOT EXISTS horarios (
  id_horarios INT NOT NULL AUTO_INCREMENT,
  hora_partida VARCHAR(45) NULL,
  hora_llegada VARCHAR(45) NULL,
  zona_horaria VARCHAR(45) NULL,
  duracion VARCHAR(45) NULL,
  precio_persona DECIMAL(5,2) NULL,
  id_bus INT NOT NULL,
  PRIMARY KEY (id_horarios, id_bus),
  INDEX fk_horarios_bus_idx (id_bus ASC),
  CONSTRAINT fk_horarios_bus
    FOREIGN KEY (id_bus)
    REFERENCES bus (id_bus)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table tab
-- -----------------------------------------------------
DROP TABLE IF EXISTS tab ;

CREATE TABLE IF NOT EXISTS tab (
  id_tab INT NOT NULL AUTO_INCREMENT,
  descripcion_tab TEXT NULL,
  itinerario_tab TEXT NULL,
  incluye_tab TEXT NULL,
  informacion_tab TEXT NULL,
  recomendacion_tab TEXT NULL,
  salida_retorno_tab TEXT NULL,
  id_bus INT NOT NULL,
  PRIMARY KEY (id_tab),
  INDEX fk_tab_bus1_idx (id_bus ASC),
  CONSTRAINT fk_tab_bus1
    FOREIGN KEY (id_bus)
    REFERENCES bus (id_bus)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table tab_adicional
-- -----------------------------------------------------
DROP TABLE IF EXISTS tab_adicional ;

CREATE TABLE IF NOT EXISTS tab_adicional (
  id_tab_adicional INT NOT NULL AUTO_INCREMENT,
  icono_tab_adicional VARCHAR(45) NULL,
  nombre_tab_adicional VARCHAR(128) NULL,
  contenido_tab TEXT NULL,
  id_bus INT NOT NULL,
  PRIMARY KEY (id_tab_adicional),
  INDEX fk_tab_adicional_bus1_idx (id_bus ASC),
  CONSTRAINT fk_tab_adicional_bus1
    FOREIGN KEY (id_bus)
    REFERENCES bus (id_bus)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table bloqueo
-- -----------------------------------------------------
DROP TABLE IF EXISTS bloqueo ;

CREATE TABLE IF NOT EXISTS bloqueo (
  id_bloqueo INT NOT NULL AUTO_INCREMENT,
  descripcion_bloqueo TEXT NULL,
  fecha_inicio DATETIME NULL,
  fecha_fin DATETIME NULL,
  color_bloqueo VARCHAR(45) NULL,
  id_bus INT NOT NULL,
  PRIMARY KEY (id_bloqueo),
  INDEX fk_bloqueo_bus1_idx (id_bus ASC),
  CONSTRAINT fk_bloqueo_bus1
    FOREIGN KEY (id_bus)
    REFERENCES bus (id_bus)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table disponibilidad
-- -----------------------------------------------------
DROP TABLE IF EXISTS disponibilidad ;

CREATE TABLE IF NOT EXISTS disponibilidad (
  id_disponibilidad INT NOT NULL AUTO_INCREMENT,
  descripcion_disponibilidad TEXT NULL,
  fecha_inicio DATETIME NULL,
  fecha_fin DATETIME NULL,
  color_disponibilidad VARCHAR(32) NULL,
  dias_activos VARCHAR(128) NULL,
  dias_no_activos VARCHAR(128) NULL,
  dias_especiales TEXT NULL,
  meses_inactivos TEXT NULL,
  id_bus INT NOT NULL,
  PRIMARY KEY (id_disponibilidad),
  INDEX fk_disponibilidad_bus1_idx (id_bus ASC),
  CONSTRAINT fk_disponibilidad_bus1
    FOREIGN KEY (id_bus)
    REFERENCES bus (id_bus)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table oferta
-- -----------------------------------------------------
DROP TABLE IF EXISTS oferta ;

CREATE TABLE IF NOT EXISTS oferta (
  id_oferta INT NOT NULL AUTO_INCREMENT,
  valor_oferta DECIMAL(7,3) NULL,
  tipo_oferta INT NULL,
  fecha_inicio DATETIME NULL,
  fecha_fin DATETIME NULL,
  color_oferta VARCHAR(22) NULL,
  descripcion_oferta VARCHAR(128) NULL,
  ofertacol VARCHAR(45) NULL,
  id_bus INT NOT NULL,
  PRIMARY KEY (id_oferta),
  INDEX fk_oferta_bus1_idx (id_bus ASC),
  CONSTRAINT fk_oferta_bus1
    FOREIGN KEY (id_bus)
    REFERENCES bus (id_bus)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table servicio_adicional
-- -----------------------------------------------------
DROP TABLE IF EXISTS servicio_adicional ;

CREATE TABLE IF NOT EXISTS servicio_adicional (
  id_servicio_adicional INT NOT NULL AUTO_INCREMENT,
  nombre_servicio_adicional VARCHAR(255) NULL,
  icono_servicio_adicional VARCHAR(45) NULL,
  id_idioma INT(11) NOT NULL,
  PRIMARY KEY (id_servicio_adicional, id_idioma),
  INDEX fk_servicios_adicional_idioma1_idx (id_idioma ASC),
  CONSTRAINT fk_servicios_adicional_idioma1
    FOREIGN KEY (id_idioma)
    REFERENCES idioma (id_idioma)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table bus_has_servicio_adicional
-- -----------------------------------------------------
DROP TABLE IF EXISTS bus_has_servicio_adicional ;

CREATE TABLE IF NOT EXISTS bus_has_servicio_adicional (
  id_bus INT NOT NULL,
  id_servicio_adicional INT NOT NULL,
  PRIMARY KEY (id_bus, id_servicio_adicional),
  INDEX fk_bus_has_servicios_adicional_servicios_adicional1_idx (id_servicio_adicional ASC),
  INDEX fk_bus_has_servicios_adicional_bus1_idx (id_bus ASC),
  CONSTRAINT fk_bus_has_servicios_adicional_bus1
    FOREIGN KEY (id_bus)
    REFERENCES bus (id_bus)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT fk_bus_has_servicios_adicional_servicios_adicional1
    FOREIGN KEY (id_servicio_adicional)
    REFERENCES servicio_adicional (id_servicio_adicional)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table bus_has_galeria
-- -----------------------------------------------------
DROP TABLE IF EXISTS bus_has_galeria ;

CREATE TABLE IF NOT EXISTS bus_has_galeria (
  id_has_galeria INT NOT NULL AUTO_INCREMENT,
  id_galeria INT NULL,
  id_bus INT NOT NULL,
  INDEX fk_bus_has_galeria_bus1_idx (id_bus ASC),
  PRIMARY KEY (id_has_galeria),
  CONSTRAINT fk_bus_has_galeria_bus1
    FOREIGN KEY (id_bus)
    REFERENCES bus (id_bus)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table lugares
-- -----------------------------------------------------
DROP TABLE IF EXISTS lugares ;

CREATE TABLE IF NOT EXISTS lugares (
  id_lugar INT NOT NULL AUTO_INCREMENT,
  nombre_lugar VARCHAR(255) NULL,
  coordenadas VARCHAR(128) NULL,
  tipo_lugar TINYINT NULL,
  id_bus INT NOT NULL,
  orden_lugar INT NULL,
  PRIMARY KEY (id_lugar),
  INDEX fk_lugares_bus1_idx (id_bus ASC),
  CONSTRAINT fk_lugares_bus1
    FOREIGN KEY (id_bus)
    REFERENCES bus (id_bus)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table destinos
-- -----------------------------------------------------
DROP TABLE IF EXISTS destinos ;

CREATE TABLE IF NOT EXISTS destinos (
  id_destinos INT NOT NULL AUTO_INCREMENT,
  partida_destinos VARCHAR(128) NULL,
  llegada_destinos VARCHAR(128) NULL,
  direccion_partida_destinos VARCHAR(128) NULL,
  direccion_llegada_destinos VARCHAR(128) NULL,
  id_bus INT NOT NULL,
  PRIMARY KEY (id_destinos),
  INDEX fk_destinos_bus1_idx (id_bus ASC),
  CONSTRAINT fk_destinos_bus1
    FOREIGN KEY (id_bus)
    REFERENCES bus (id_bus)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
