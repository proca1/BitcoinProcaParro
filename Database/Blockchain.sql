\c blockchain

CREATE TABLE Block(
	block_id varchar (35) NOT NULL PRIMARY KEY,
	hash varchar (35) NOT NULL,
	version varchar (35) NOT NULL,
	prev_block varchar (35) NOT NULL  REFERENCES Block (block_id),
	mrkl_root varchar (35) NOT NULL,
	time varchar (35) NOT NULL,
	bits varchar (35) NOT NULL,
	free varchar (35) NOT NULL,
	nonce varchar (35) NOT NULL,
	n_tx varchar (35) NOT NULL,
	size varchar (35) NOT NULL,
	main_chain varchar (35) NOT NULL,
	height varchar (35) NOT NULL
);

CREATE TABLE Transaction(
	tx_index varchar (35) NOT NULL PRIMARY KEY,
	hash varchar (35) NOT NULL,
	lock_time varchar (35) NOT NULL,
	version varchar (35) NOT NULL,
	size varchar (35) NOT NULL,
	time varchar (35) NOT NULL,
	vin_size varchar (35) NOT NULL,
	vout_size varchar (35) NOT NULL,
	relayed_by varchar (35) NOT NULL,
	block_id varchar (35) NOT NULL REFERENCES Block (block_id)
);

CREATE TABLE Input(
	id_input varchar (35) NOT NULL PRIMARY KEY,
	sequence varchar (35) NOT NULL,
	tx_index varchar (35) NOT NULL REFERENCES Transaction (tx_index),
	spent varchar (35) NOT NULL,
	type varchar (35) NOT NULL,
	addr varchar (35) NOT NULL,
	value varchar (35) NOT NULL,
	n varchar (35) NOT NULL,
	script varchar (35) NOT NULL,
	out_script varchar (35) NOT NULL 
);

CREATE TABLE Output(
	id_output varchar (35) NOT NULL PRIMARY KEY,
	tx_index varchar (35) NOT NULL REFERENCES Transaction (tx_index),
	spent varchar (35) NOT NULL,
	type varchar (35) NOT NULL,
	addr varchar (35) NOT NULL,
	value varchar (35) NOT NULL,
	n varchar (35) NOT NULL,
	out_script varchar (35) NOT NULL 
);
