CREATE TABLE produtos (
                          id INT AUTO_INCREMENT PRIMARY KEY,
                          nome VARCHAR(255),
                          preco DECIMAL(10,2)
);

CREATE TABLE variacoes (
                           id INT AUTO_INCREMENT PRIMARY KEY,
                           produto_id INT,
                           nome VARCHAR(255),
                           FOREIGN KEY (produto_id) REFERENCES produtos(id) ON DELETE CASCADE
);

CREATE TABLE estoques (
                          id INT AUTO_INCREMENT PRIMARY KEY,
                          variacao_id INT,
                          quantidade INT,
                          FOREIGN KEY (variacao_id) REFERENCES variacoes(id) ON DELETE CASCADE
);

CREATE TABLE cupons (
                        id INT AUTO_INCREMENT PRIMARY KEY,
                        codigo VARCHAR(50),
                        desconto DECIMAL(10,2),
                        minimo DECIMAL(10,2),
                        validade DATE
);

CREATE TABLE pedidos (
                         id INT AUTO_INCREMENT PRIMARY KEY,
                         subtotal DECIMAL(10,2),
                         frete DECIMAL(10,2),
                         total DECIMAL(10,2),
                         status VARCHAR(20),
                         endereco TEXT,
                         criado_em DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE pedido_itens (
                              id INT AUTO_INCREMENT PRIMARY KEY,
                              pedido_id INT,
                              variacao_id INT,
                              quantidade INT,
                              preco_unitario DECIMAL(10,2),
                              FOREIGN KEY (pedido_id) REFERENCES pedidos(id) ON DELETE CASCADE
);
