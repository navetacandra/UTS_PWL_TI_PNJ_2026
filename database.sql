DROP TABLE IF EXISTS accounts;
DROP TABLE IF EXISTS account_type;
DROP TABLE IF EXISTS actions;

CREATE TABLE IF NOT EXISTS account_type (
    id VARCHAR(36) NOT NULL PRIMARY KEY DEFAULT (UUID()),
    name VARCHAR(128) NOT NULL,
    description TEXT NOT NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    deleted_at DATETIME
);

CREATE TABLE IF NOT EXISTS accounts (
    id VARCHAR(36) NOT NULL PRIMARY KEY DEFAULT (UUID()),
    name VARCHAR(128) NOT NULL,
    email VARCHAR(128) NOT NULL,
    password TEXT NOT NULL,
    account_type_id VARCHAR(36),
    status VARCHAR(128),
    identification_number VARCHAR(128) NOT NULL,
    identification_type ENUM('NIM', 'NIP') NOT NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    deleted_at DATETIME,
    INDEX email_hash (email) USING HASH,
    INDEX identification_number_hash (identification_number) USING HASH,
    CONSTRAINT fk_account_type FOREIGN KEY (account_type_id) REFERENCES account_type (id),
    CONSTRAINT unique_account_type UNIQUE (account_type_id)
);

CREATE TABLE IF NOT EXISTS actions (
    id VARCHAR(36) NOT NULL PRIMARY KEY DEFAULT (UUID()),
    name VARCHAR(128) NOT NULL,
    description TEXT NOT NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    deleted_at DATETIME
);

ALTER TABLE accounts DROP FOREIGN KEY fk_account_type;
ALTER TABLE accounts DROP CONSTRAINT unique_account_type;
ALTER TABLE accounts ADD CONSTRAINT fk_account_type FOREIGN KEY (account_type_id) REFERENCES account_type (id);

-- Seeds and Insert
INSERT INTO account_type (name, description) VALUES ('Admin', 'Role untuk admin') RETURNING id, name, description, created_at, updated_at;
INSERT INTO accounts (name, email, password, identification_number, identification_type) VALUES ('Administrator', 'admin@gmail.com', '$2y$12$El3NdniEGAqJasWVFYLK1eB1Xsoem6UrUH2UNPArNv2Dxb1diGiCe', '12345678', 'NIM') RETURNING *;
INSERT INTO actions (name, description) VALUES ('CREATE', 'Operasi menambahkan') RETURNING id, name, description, created_at, updated_at;

-- Delete
UPDATE accounts SET account_type=NULL, deleted_at=CURRENT_TIMESTAMP WHERE deleted_at IS NULL AND id='';
UPDATE account_type SET deleted_at=CURRENT_TIMESTAMP WHERE deleted_at IS NULL AND id='';
UPDATE actions SET deleted_at=CURRENT_TIMESTAMP WHERE deleted_at IS NULL AND id='';

-- Select
SELECT * FROM accounts WHERE deleted_at IS NULL;
SELECT * FROM account_type WHERE deleted_at IS NULL;
SELECT * FROM actions WHERE deleted_at IS NULL;

-- Update
UPDATE accounts SET name='', email='', identification_type='', status='', updated_at=CURRENT_TIMESTAMP WHERE deleted_at IS NULL AND id='';
UPDATE account_type SET name=?, email=?, password=?, account_type_id=?, status=?, identification_number=?, identification_type=?, updated_at=CURRENT_TIMESTAMP WHERE deleted_at IS NULL AND id=?;
UPDATE actions SET name='', description='', updated_at=CURRENT_TIMESTAMP WHERE deleted_at IS NULL AND id='';

-- Update password
UPDATE accounts SET password='', updated_at=CURRENT_TIMESTAMP WHERE id='';
