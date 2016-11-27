\c blockchain

CREATE TABLE Block(
	hash varchar (35) NOT NULL PRIMARY KEY,
	confirmations INTEGER NOT NULL,
	strippedsize  INTEGER NOT NULL,
	size INTEGER NOT NULL,
	weight INTEGER NOT NULL,
	height INTEGER NOT NULL,
	version INTEGER  NOT NULL,
	versionHex varchar (35) NOT NULL,
	merkleroot varchar (35) NOT NULL,
	time INTEGER NOT NULL,
	mediantime INTEGER NOT NULL,
	nonce INTEGER NOT NULL,
	bits varchar NOT NULL,
	difficulty INTEGER NOT NULL,
	chainwork varchar (35) NOT NULL,
	previousblockhash varchar (35) NOT NULL REFERENCES Block (hash),
	nextblockhash varchar (35) NOT NULL REFERENCES Block (hash)
);

CREATE TABLE Transaction(
	hex varchar (35) NOT NULL,
	txid varchar (35) NOT NULL  PRIMARY KEY,
	hash varchar (35) NOT NULL,
	size INTEGER NOT NULL,
	vsize INTEGER NOT NULL,
	version INTEGER  NOT NULL,
	locktime INTEGER  NOT NULL,
	blockhash varchar (35) NOT NULL  REFERENCES Block(hash),
	confirmations INTEGER NOT NULL,
	time INTEGER  NOT NULL,
	blocktime INTEGER  NOT NULL
);

CREATE TABLE Tx_input(
	txid varchar (35) NOT NULL REFERENCES Transaction(txid),
	vout INTEGER NOT NULL,
	asm varchar (35) NOT NULL,
	hex varchar (35) NOT NULL,
	sequence INTEGER NOT NULL,
	CONSTRAINT txin PRIMARY KEY (txid,vout)
);

CREATE TABLE Tx_output(
	txid varchar (35) NOT NULL REFERENCES Transaction (txid),
	value FLOAT NOT NULL,
	n INTEGER  NOT NULL,
	asm varchar (35) NOT NULL,
	hex varchar (35) NOT NULL,
	reqSigs INTEGER  NOT NULL,
	type varchar (35) NOT NULL,
	addresses varchar (35) NOT NULL,
	CONSTRAINT txout PRIMARY KEY (txid,n)
);
