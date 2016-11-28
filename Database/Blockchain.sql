CREATE DATABASE blockchain;
\c blockchain
CREATE SCHEMA IF NOT EXISTS blockchainSchema;

CREATE TABLE  IF NOT EXISTS blockchainSchema.Block(
	hash varchar NOT NULL PRIMARY KEY,
	confirmations BIGINT NOT NULL,
	strippedsize  BIGINT NOT NULL,
	size BIGINT NOT NULL,
	weight BIGINT NOT NULL,
	height BIGINT NOT NULL,
	version BIGINT  NOT NULL,
	versionHex varchar NOT NULL,
	merkleroot varchar NOT NULL,
	time BIGINT NOT NULL,
	mediantime BIGINT NOT NULL,
	nonce BIGINT NOT NULL,
	bits varchar NOT NULL,
	difficulty NUMERIC NOT NULL,
	chainwork varchar NOT NULL,
	previousblockhash varchar REFERENCES blockchainSchema.Block (hash),
	nextblockhash varchar REFERENCES blockchainSchema.Block (hash)
);

CREATE TABLE  IF NOT EXISTS blockchainSchema.Transaction(
	hex varchar NOT NULL,
	txid varchar NOT NULL  PRIMARY KEY,
	hash varchar NOT NULL,
	size BIGINT NOT NULL,
	vsize BIGINT NOT NULL,
	version BIGINT  NOT NULL,
	locktime BIGINT  NOT NULL,
	blockhash varchar NOT NULL  REFERENCES blockchainSchema.Block(hash),
	confirmations BIGINT NOT NULL,
	time BIGINT  NOT NULL,
	blocktime BIGINT  NOT NULL
);

CREATE TABLE  IF NOT EXISTS blockchainSchema.Tx_input(
	txid_prev varchar  NOT NULL REFERENCES blockchainSchema.Transaction(txid),
	txid varchar  NOT NULL REFERENCES blockchainSchema.Transaction(txid),
	vout BIGINT NOT NULL,
	asm varchar  NOT NULL,
	hex varchar NOT NULL,
	sequence BIGINT NOT NULL,
	CONSTRAINT txin PRIMARY KEY (txid_prev,vout)
);

CREATE TABLE  IF NOT EXISTS blockchainSchema.Tx_output(
	txid varchar NOT NULL REFERENCES blockchainSchema.Transaction (txid),
	value FLOAT NOT NULL,
	n BIGINT  NOT NULL,
	asm varchar NOT NULL,
	hex varchar NOT NULL,
	reqSigs BIGINT  NOT NULL,
	type varchar NOT NULL,
	addresses varchar NOT NULL,
	CONSTRAINT txout PRIMARY KEY (txid,n)
);
