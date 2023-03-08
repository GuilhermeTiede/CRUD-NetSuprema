{\rtf1\ansi\ansicpg1252\cocoartf2707
\cocoatextscaling0\cocoaplatform0{\fonttbl\f0\fswiss\fcharset0 Helvetica;}
{\colortbl;\red255\green255\blue255;}
{\*\expandedcolortbl;;}
\paperw11900\paperh16840\margl1440\margr1440\vieww11520\viewh8400\viewkind0
\pard\tx720\tx1440\tx2160\tx2880\tx3600\tx4320\tx5040\tx5760\tx6480\tx7200\tx7920\tx8640\pardirnatural\partightenfactor0

\f0\fs24 \cf0 CREATE TABLE Pessoa (\
    id SERIAL PRIMARY KEY,\
     nome VARCHAR(100) NOT NULL,\
    cpf VARCHAR(11) UNIQUE NOT NULL,\
    endereco VARCHAR(200) NOT NULL\
);\
\
CREATE TABLE Telefone (\
    id SERIAL PRIMARY KEY,\
    pessoa_id INT NOT NULL,\
    numero VARCHAR(20) NOT NULL,\
    descricao VARCHAR(50) NOT NULL,\
    FOREIGN KEY (pessoa_id) REFERENCES Pessoa(id)\
);\
}