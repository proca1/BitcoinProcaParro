CREATE DATABASE blockchain;
\c blockchain
CREATE SCHEMA IF NOT EXISTS blockchainSchema;

CREATE TABLE  IF NOT EXISTS blockchainSchema.Block(
	hash varchar NOT NULL PRIMARY KEY,
	confirmations INTEGER NOT NULL,
	strippedsize  INTEGER NOT NULL,
	size INTEGER NOT NULL,
	weight INTEGER NOT NULL,
	height INTEGER NOT NULL,
	version INTEGER  NOT NULL,
	versionHex varchar NOT NULL,
	merkleroot varchar NOT NULL,
	time INTEGER NOT NULL,
	mediantime INTEGER NOT NULL,
	nonce INTEGER NOT NULL,
	bits varchar NOT NULL,
	difficulty INTEGER NOT NULL,
	chainwork varchar NOT NULL,
	previousblockhash varchar NOT NULL REFERENCES blockchainSchema.Block (hash),
	nextblockhash varchar NOT NULL REFERENCES blockchainSchema.Block (hash)
);

CREATE TABLE  IF NOT EXISTS blockchainSchema.Transaction(
	hex varchar NOT NULL,
	txid varchar NOT NULL  PRIMARY KEY,
	hash varchar NOT NULL,
	size INTEGER NOT NULL,
	vsize INTEGER NOT NULL,
	version INTEGER  NOT NULL,
	locktime INTEGER  NOT NULL,
	blockhash varchar NOT NULL  REFERENCES blockchainSchema.Block(hash),
	confirmations INTEGER NOT NULL,
	time INTEGER  NOT NULL,
	blocktime INTEGER  NOT NULL
);

CREATE TABLE  IF NOT EXISTS blockchainSchema.Tx_input(
	txid_prev varchar  NOT NULL REFERENCES blockchainSchema.Transaction(txid),
	txid varchar  NOT NULL REFERENCES blockchainSchema.Transaction(txid),
	vout INTEGER NOT NULL,
	asm varchar  NOT NULL,
	hex varchar NOT NULL,
	sequence INTEGER NOT NULL,
	CONSTRAINT txin PRIMARY KEY (txid_prev,vout)
);

CREATE TABLE  IF NOT EXISTS blockchainSchema.Tx_output(
	txid varchar NOT NULL REFERENCES blockchainSchema.Transaction (txid),
	value FLOAT NOT NULL,
	n INTEGER  NOT NULL,
	asm varchar NOT NULL,
	hex varchar NOT NULL,
	reqSigs INTEGER  NOT NULL,
	type varchar (35) NOT NULL,
	addresses varchar (35) NOT NULL,
	CONSTRAINT txout PRIMARY KEY (txid,n)
);
