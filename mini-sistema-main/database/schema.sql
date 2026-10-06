-- Banco de dados do Acervo Digital de Partituras Brasileiras

CREATE TABLE usuarios (
    id BIGINT GENERATED ALWAYS AS IDENTITY PRIMARY KEY,
    email VARCHAR(254) NOT NULL UNIQUE,
    senha_hash VARCHAR(255) NOT NULL,
    criado_em TIMESTAMPTZ NOT NULL DEFAULT NOW()
);

CREATE TABLE partituras (
    id BIGINT GENERATED ALWAYS AS IDENTITY PRIMARY KEY,
    titulo VARCHAR(200) NOT NULL,
    compositor VARCHAR(200) NOT NULL,
    ano_composicao SMALLINT,
    genero VARCHAR(100),
    instrumentacao TEXT,
    tonalidade VARCHAR(40),
    descricao TEXT,
    fonte_procedencia TEXT,
    situacao_direitos VARCHAR(40) NOT NULL DEFAULT 'pendente',
    titular_licenca TEXT,
    nome_arquivo_original VARCHAR(255),
    caminho_arquivo VARCHAR(500),
    mime_type VARCHAR(100),
    tamanho_bytes BIGINT,
    visivel BOOLEAN NOT NULL DEFAULT FALSE,
    criado_por BIGINT REFERENCES usuarios(id) ON DELETE SET NULL,
    criado_em TIMESTAMPTZ NOT NULL DEFAULT NOW(),
    atualizado_em TIMESTAMPTZ NOT NULL DEFAULT NOW(),

    CONSTRAINT ck_direitos CHECK (
        situacao_direitos IN (
            'dominio_publico',
            'licenca_autorizada',
            'restrito',
            'pendente',
            'desconhecido'
        )
    ),

    CONSTRAINT ck_ano CHECK (
        ano_composicao IS NULL
        OR ano_composicao BETWEEN 1000 AND 2100
    )
);

CREATE INDEX idx_partituras_titulo
    ON partituras (LOWER(titulo));

CREATE INDEX idx_partituras_compositor
    ON partituras (LOWER(compositor));

CREATE INDEX idx_partituras_genero
    ON partituras (genero);
