/*
* Cretaed by Emanuele Procacci-Matteo Parroccini
*/


Nel file "getJsonRequest.php" è stato eseguito il parser relativo al json fornito dalle chiamate alla libreria "easybitcoin.php".
Le chiamate eseguite a tale libreria sono:

- getblockchaininfo() // ANCORA NON IMPLEMENTATA
- getblockhash(h)
- getblock(blockHash)
- getrawtransaction(transactionHash,1)

La getblockchaininfo() viene utilizzata per recuperare l'altezza attuale della blockchain e permettere quindi di aggiornare il DB dall'ultimo blocco inserito, che ha un altezza inferiore, all'ultimo della blockchain.

La getblockhash(h), per ogni altezza h dall'ultima inserita nel DB all'ultima della blockchain, recupera l'hash della transazione a tale altezza.

La getblock(blockHash), attraverso l'hash del blocco recuperato precedentemente, ottiene l'intero blocco e quindi tutti gli hash delle transazioni contenute al suo interno.
Da questa chiamate vengono recuperati tutti i campi relativi al blocco e salvati nel DB nella tabella "Block".

La getrawtransaction(transactionHash,1), attraverso L'hash della transazione recuperata dal blocco (vengono recuperate tutte quelle del blocco) e il parametro 1 che indica alla chiamata di eseguire la decodifica del risultato, vengono recuperati tutti i campi della transazione e salvati nel DB nella tabella "Transaction".
Inoltre vengono recuperati i campo relativi alle specifiche di "vin" e "vout" di ogni transazione e salvate nel DB nelle tabelle "Tx_input" e "Tx_output" rispettivamente.