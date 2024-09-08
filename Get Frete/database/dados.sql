DROP DATABASE IF EXISTS getfrete;
CREATE DATABASE getfrete;

DROP TABLE IF EXISTS historico;
DROP TABLE IF EXISTS proposta;
DROP TABLE IF EXISTS pedido;
DROP TABLE IF EXISTS categoria_pedido;
DROP TABLE IF EXISTS veiculo;
DROP TABLE IF EXISTS tipo_veiculo;
DROP TABLE IF EXISTS cnh;
DROP TABLE IF EXISTS cliente;
DROP TABLE IF EXISTS motorista;

CREATE TABLE cliente(
    nome VARCHAR (255) NOT NULL,
    sobrenome VARCHAR (255) NOT NULL,
    email VARCHAR (255) NOT NULL,
    senha VARCHAR (255) NOT NULL,
    cpf TEXT(255) NOT NULL,
    telefone TEXT(255),
    uf VARCHAR(255),
    cidade VARCHAR(255),
    imagem VARCHAR(255),
    recuperar_senha VARCHAR(255),
    PRIMARY KEY (email)
);

CREATE TABLE motorista(
    nome VARCHAR (255) NOT NULL,
    sobrenome VARCHAR (255) NOT NULL,
    email VARCHAR (255) NOT NULL,
    senha VARCHAR (255) NOT NULL,
    cpf TEXT(255) NOT NULL,
    telefone TEXT(255),
    uf VARCHAR(255),
    cidade VARCHAR(255),
    pagamentos VARCHAR(255),
    avaliacao VARCHAR(255),
    viagens VARCHAR(255),
    imagem VARCHAR(255),
    recuperar_senha VARCHAR(255),
    PRIMARY KEY (email)
);

CREATE TABLE cnh(
    numero TEXT(255) NOT NULL,
    validade DATE NOT NULL,
    email VARCHAR(255),
    imagem VARCHAR(255),
    PRIMARY KEY (numero(255)),
    FOREIGN KEY (email) REFERENCES motorista(email)
);

CREATE TABLE tipo_veiculo(
    id_tv INT AUTO_INCREMENT,
    nome VARCHAR(255) NOT NULL,
    PRIMARY KEY (id_tv)
);
INSERT INTO tipo_veiculo (nome) VALUES
 ("Carro"),
 ("Carretinha"),
 ("Van compacta"),
 ("Caminhonete"),
 ("Furgão/Van"),
 ("Caminhão 3/4"),
 ("Caminhão toco"),
 ("Caminhão truck");

CREATE TABLE veiculo(
    renavam VARCHAR(255) NOT NULL,
    tipo  INT NOT NULL,
    marca VARCHAR(255) NOT NULL,
    modelo VARCHAR(255) NOT NULL,
    placa VARCHAR(255) NOT NULL,
    ano INT NOT NULL,
    cor VARCHAR(255) NOT NULL,
    email VARCHAR(255),
    PRIMARY KEY (renavam(255)),
    FOREIGN KEY (email) REFERENCES motorista(email),
    FOREIGN KEY (tipo) REFERENCES tipo_veiculo(id_tv)
);

CREATE TABLE categoria_pedido(
    id_cp INT AUTO_INCREMENT,
    nome VARCHAR(255) NOT NULL,
    PRIMARY KEY (id_cp)
);

INSERT INTO categoria_pedido (nome) VALUES
 ("Entulho"),
 ("Matéria-prima"),
 ("Objeto pequeno"),
 ("Mudança comercial"),
 ("Mudança residencial"),
 ("Móvel ou Eletrodoméstico"),
 ("Transporte especializado ou frágil"),
 ("Outro");

CREATE TABLE pedido(
    id_p INT AUTO_INCREMENT,
    cliente VARCHAR(255) NOT NULL,
    motorista VARCHAR(255),
    veiculo VARCHAR(255),
    ajudante VARCHAR(255) NOT NULL,
    descricao VARCHAR(255),
    origem VARCHAR(255) NOT NULL,
    destino VARCHAR(255) NOT NULL,
    categoria INT NOT NULL,
    horario TIME NOT NULL,
    data_entrega DATE NOT NULL,
    data_pedido TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    valor DECIMAL(10,2),
    status VARCHAR(255),
    finalizado VARCHAR(255),
    PRIMARY KEY (id_p),
    FOREIGN KEY (cliente) REFERENCES cliente(email),
    FOREIGN KEY (motorista) REFERENCES motorista(email),
    FOREIGN KEY (veiculo) REFERENCES veiculo(renavam),
    FOREIGN KEY (categoria) REFERENCES categoria_pedido(id_cp)
);

CREATE TABLE proposta(
    id_pr INT AUTO_INCREMENT,
    pedido INT,
    valor DECIMAL(10,2),
    motorista VARCHAR(255),
    veiculo VARCHAR(255),
    PRIMARY KEY (id_pr),
    FOREIGN KEY (pedido) REFERENCES pedido(id_p),
    FOREIGN KEY (motorista) REFERENCES motorista(email),
    FOREIGN KEY (veiculo) REFERENCES veiculo(renavam)
);

CREATE TABLE notificacao(
    id_n INT AUTO_INCREMENT,
    pedido INT,
    usuario VARCHAR(255),
    msg VARCHAR(255),
    status BOOLEAN,
    PRIMARY KEY (id_n)
);

CREATE TABLE historico(
    id_h INT AUTO_INCREMENT,
    id_pedido INT,
    data_pedido VARCHAR(255),
    finalizado VARCHAR(255),
    descricao VARCHAR(255),
    origem VARCHAR(255),
    destino VARCHAR(255),
    data_entrega VARCHAR(255),
    horario VARCHAR(255),
    valor VARCHAR(255),
    cliente VARCHAR(255),
    cpf_c VARCHAR(255),
    email_c VARCHAR(255),
    tel_c VARCHAR(255),
    motorista VARCHAR(255),
    cpf_m VARCHAR(255),
    email_m VARCHAR(255),
    tel_m VARCHAR(255),
    veiculo VARCHAR(255),
    ajudante VARCHAR(255),
    avaliacao INT,
    PRIMARY KEY(id_h)
);

INSERT INTO cliente (nome, sobrenome, email, senha, cpf, telefone, uf, cidade, imagem)
VALUES ("Lívia","Galli","livgalli2@gmail.com","25d55ad283aa400af464c76d713c07ad","504.761.048-90","(16) 99740-5596","SP","Araraquara","../assets/arquivos/semfoto.png");
INSERT INTO cliente (nome, sobrenome, email, senha, cpf, telefone, uf, cidade, imagem)
VALUES ("Bruna","Hamada","b.hamada@gmail.com","25d55ad283aa400af464c76d713c07ad","222.222.222-22","(16) 99992-2922","SP","Araraquara","../assets/arquivos/semfoto.png");
INSERT INTO motorista (nome, sobrenome, email, senha, cpf, telefone, uf, cidade, pagamentos, avaliacao, imagem)
VALUES ("Gabriel","Albino","gabrielalbino28@gmail.com","25d55ad283aa400af464c76d713c07ad","450.143.078-84","(16) 99614-2354","SP","Araraquara","Dinheiro, Pix","Novato","../assets/arquivos/semfoto.png");
INSERT INTO cnh (numero, validade, email, imagem)
VALUES ("555.555.555-55","2030-05-05","gabrielalbino28@gmail.com","../assets/arquivos/motoristas/cnh/cnh_gabrielalbino28@gmail.com.jpg");
INSERT INTO veiculo (renavam, tipo, marca, modelo, placa, ano, cor, email)
VALUES ("55555555555","1","Honda","CRV","EDD9995","2008","Preto","gabrielalbino28@gmail.com");
INSERT INTO veiculo (renavam, tipo, marca, modelo, placa, ano, cor, email)
VALUES ("66666666666","4","Chevrolet","Caminhonete","BLX2896","1998","Branco","gabrielalbino28@gmail.com");
INSERT INTO motorista (nome, sobrenome, email, senha, cpf, telefone, uf, cidade, pagamentos, avaliacao, imagem)
VALUES ("Renato","Silva","r.silva@gmail.com","25d55ad283aa400af464c76d713c07ad","111.111.111-11","(16) 99991-1991","SP","Araraquara","Dinheiro, Pix","Novato","../assets/arquivos/semfoto.png");
INSERT INTO cnh (numero, validade, email, imagem)
VALUES ("111.111.111-11","2030-05-05","r.silva@gmail.com","../assets/arquivos/motoristas/cnh/cnh_r.silva@gmail.com.jpg");


SELECT pedido.id_p, pedido.descricao, pedido.origem, pedido.destino,
pedido.horario, pedido.data_entrega, pedido.valor, pedido.status, 
motorista.nome AS nome_motorista, veiculo.marca, veiculo.modelo, veiculo.placa,
cliente.nome AS nome_cliente, categoria_pedido.nome AS nome_categoria
FROM pedido
INNER JOIN motorista ON pedido.motorista = motorista.email
INNER JOIN veiculo ON pedido.veiculo = veiculo.renavam
INNER JOIN cliente ON pedido.cliente = cliente.email
INNER JOIN categoria_pedido ON pedido.categoria = categoria_pedido.id_cp;