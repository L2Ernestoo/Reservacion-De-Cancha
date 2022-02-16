-- Ernesto Orellana
-- 16-02-2022 15:00

CREATE DATABASE ejercicio2_hml;

use ejercicio2_hml;

CREATE TABLE 'ws_usuario' (
    'id' INT NOT NULL AUTO_INCREMENT,
     'nombre' CHAR(45) NOT NULL,
    'email' CHAR(45) NOT NULL,
    'telefono' CHAR(12) NOT NULL,
    'password' CHAR(45) NOT NULL,
    'add_user' CHAR(20) NULL,
    'add_fecha' TIMESTAMP NULL DEFAULT current_timestamp,
    'mod_user' CHAR(20) NULL,
    'mod_fecha' TIMESTAMP NULL DEFAULT current_timestamp,
    PRIMARY KEY ('id'))



CREATE TABLE 'ws_cancha' (
    'id' INT NOT NULL AUTO_INCREMENT,
    'numero' VARCHAR(45) NULL,
    PRIMARY KEY ('id'))

CREATE TABLE 'ws_reservacion' (
   'id' INT NOT NULL,
    'fecha_reservacion' DATE NULL,
     'hora_reservacion' TIME NULL,
     'ws_cancha_id' INT NOT NULL,
     'ws_usuario_id' INT NOT NULL,
    PRIMARY KEY ('id'),
    INDEX 'fk_ws_reservacion_ws_cancha_idx' ('ws_cancha_id' ASC),
    INDEX 'fk_ws_reservacion_ws_usuario1_idx' ('ws_usuario_id' ASC),
    CONSTRAINT 'fk_ws_reservacion_ws_cancha'
    FOREIGN KEY ('ws_cancha_id')
    REFERENCES 'futeca'.'ws_cancha' ('id')
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
    CONSTRAINT 'fk_ws_reservacion_ws_usuario1'
    FOREIGN KEY ('ws_usuario_id')
    REFERENCES 'futeca'.'ws_usuario' ('id')
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)


CREATE TABLE 'ws_tipo_de_pago' (
     'id' INT NOT NULL AUTO_INCREMENT,
     'tipo_de_pago' VARCHAR(45) NOT NULL,
    PRIMARY KEY ('id'))


CREATE TABLE 'ws_pagos' (
    'id' INT NOT NULL AUTO_INCREMENT,
    'ws_tipo_de_pago_id' INT NOT NULL,
    'ws_reservacion_id' INT NOT NULL,
    PRIMARY KEY ('id'),
    INDEX 'fk_ws_pagos_ws_tipo_de_pago1_idx' ('ws_tipo_de_pago_id' ASC),
    INDEX 'fk_ws_pagos_ws_reservacion1_idx' ('ws_reservacion_id' ASC),
    CONSTRAINT 'fk_ws_pagos_ws_tipo_de_pago1'
    FOREIGN KEY ('ws_tipo_de_pago_id')
    REFERENCES 'futeca'.'ws_tipo_de_pago' ('id')
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
    CONSTRAINT 'fk_ws_pagos_ws_reservacion1'
    FOREIGN KEY ('ws_reservacion_id')
    REFERENCES 'futeca'.'ws_reservacion' ('id')
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)

