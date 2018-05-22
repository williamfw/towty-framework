create database exemplo_framework;

use exemplo_framework;

CREATE TABLE Usuario
(
	Codigo INTEGER NOT NULL auto_increment,	
	NomeCompleto VARCHAR(200) NOT NULL,
	Usuario VARCHAR(50) NOT NULL,
	Senha VARCHAR(32) NOT NULL,
	PRIMARY KEY (Codigo)
);

create database outroexemplo_framework;

use outroexemplo_framework;

CREATE TABLE Livro
(
	Codigo INTEGER NOT NULL auto_increment,	
	Nome VARCHAR(200) NOT NULL,	
	PRIMARY KEY (Codigo)
);