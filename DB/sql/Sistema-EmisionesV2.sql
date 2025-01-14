SET FOREIGN_KEY_CHECKS = 0;

-- -----------------------------------------------------
-- Administrador
-- -----------------------------------------------------
DROP TABLE IF EXISTS Administrador;
CREATE TABLE Administrador (
  idAdministrador INT NOT NULL AUTO_INCREMENT,
  Username VARCHAR(45) NOT NULL,
  Password VARCHAR(45) NOT NULL,
  PRIMARY KEY (idAdministrador)
);
ALTER TABLE Administrador AUTO_INCREMENT = 1;

-- -----------------------------------------------------
-- Empresa
-- -----------------------------------------------------
DROP TABLE IF EXISTS Empresa;
CREATE TABLE Empresa (
  idEmpresa INT NOT NULL AUTO_INCREMENT,
  Nombre VARCHAR(45) NULL,
  PRIMARY KEY (idEmpresa)
);
ALTER TABLE Empresa AUTO_INCREMENT = 1;

-- -----------------------------------------------------
-- Dispositivo
-- -----------------------------------------------------
DROP TABLE IF EXISTS Dispositivo;
CREATE TABLE Dispositivo(
  idDispositivo INT NOT NULL AUTO_INCREMENT,
  Codigo VARCHAR(20),
  Usuario_idUsuario INT NOT NULL,
  PRIMARY KEY (idDispositivo),
  FOREIGN KEY (Usuario_idUsuario)
  REFERENCES Usuario(idUsuario)
  ON DELETE CASCADE
);
ALTER TABLE Dispositivo AUTO_INCREMENT=1;

-- -----------------------------------------------------
-- Niveles Emisiones
-- -----------------------------------------------------
DROP TABLE IF EXISTS Estadisticas;
CREATE TABLE Estadisticas(
  idEmisiones INT NOT NULL AUTO_INCREMENT,
  Fecha DATE NOT NULL,
  Hora TIME NOT NULL,
  Humedad FLOAT,
  Latitud FLOAT,
  Longitud FLOAT,
  Temperatura FLOAT,
  Presion FLOAT,
  O2 FLOAT,
  H2 FLOAT,
  CO FLOAT,
  CO2 FLOAT,
  Usuario_idUsuario INT,
  Empresa_idEmpresa INT,
  Dispositivo_idDispositivo INT,
  FOREIGN KEY (Usuario_idUsuario)
  REFERENCES Usuario(idUsuario)
  ON DELETE CASCADE,
  FOREIGN KEY (Empresa_idEmpresa)
  REFERENCES Empresa(idEmpresa)
  ON DELETE CASCADE,
  FOREIGN KEY (Dispositivo_idDispositivo)
  REFERENCES Dispositivo(idDispositivo)
  ON DELETE SET NULL,
  PRIMARY KEY (idEmisiones)
);
ALTER TABLE Estadisticas AUTO_INCREMENT=1;

-- -----------------------------------------------------
-- Usuario
-- -----------------------------------------------------
DROP TABLE IF EXISTS Usuario;
CREATE TABLE Usuario (
  idUsuario INT NOT NULL AUTO_INCREMENT,
  Username VARCHAR(20),
  Password VARCHAR(45),
  Nombre VARCHAR(45) NOT NULL,
  Ciudad VARCHAR(20) NOT NULL,
  Correo VARCHAR(45) NOT NULL,
  Telefono VARCHAR(45) NOT NULL,
  Aprobado VARCHAR(45) NOT NULL DEFAULT 'No Aprobado',
  Empresa_idEmpresa INT,
  FOREIGN KEY (Empresa_idEmpresa)
  REFERENCES Empresa(idEmpresa)
  ON DELETE SET NULL,
  PRIMARY KEY (idUsuario)
);
ALTER TABLE Usuario AUTO_INCREMENT = 1;


SET FOREIGN_KEY_CHECKS = 1;
