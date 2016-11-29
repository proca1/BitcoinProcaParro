<?php

    //--------------------------------- LIBRERIA EASYBITCOIN ----------------------------------------

    require_once ('easybitcoin.php');

    $bitcoin = new Bitcoin('bitcoinrpc','meC3JFUOE3bAGV9cv5NI43hRBngW9NsGsc0IVZHbxFjXT','10.10.20.119','8332');

    //-----------------------------------------------------------------------------------------------




    //------------------------------- CONNESSIONE AL DATABASE ---------------------------------------

    $host        = "host=127.0.0.1";
    $port        = "port=5432";
    $dbname      = "dbname=blockchain";
    $credentials = "user=postgres password=forzamilan";

    $db_connection = pg_connect("$host $port $dbname $credentials");
    if(!$db_connection){
      echo "Error : Unable to open database<br><br>";
    } else {
      echo "Opened database successfully<br><br>";
    }
    
    //-----------------------------------------------------------------------------------------------


    //CONTROLLO ULTIMO BLOCCO INSERITO NEL DB, INSERISCO L'ALTEZZA NELLA VARIABILE $DBHeight = ...
    //CONTROLLO L'ULTIMO BLOCCO INSERITO NELLA BLOCKCHAIN: attraverso la chiamata -> getblockchaininfo che contiene l'altezza attuale
    //TALE ALTEZZA VIENE SALVATA NELLA VARIABILE $currentHeight = ...
    
    //SE IL DB E' VUOTO ALLORA INSERISCO I DATI DA ALTEZZA 0 A $currentHeight
    //$h = 0;
    //if($DBHeight != 0){
        //$h = $DBHeight;//verificare se deve ossere +1 oppure no
    //}
    //for ($h = 0; $h <= $currentHeight; $h++) {

        //RECUPERO L'HASH AD ALTEZZA $h: attraverso la chiamata -> getblockhash($h)
        $getBlockHash =  $bitcoin->getblockhash($h);
        $arrayGetBlockHash = array("result" => $getBlockHash);
        $jsonGetBlockHash = json_encode($arrayGetBlockHash, true);

        //HASH DEL BLOCCO AD ALTEZZA $h
        $blockHash = $jsonGetBlockHash["result"];

        //RECUPERO TUTTI I DATI DEL BLOCCO $blockHash:  attraverso la chiamata -> getblock($blockHash)
        $getBlock = $bitcoin->getblock($blockHash);
        $arrayGetBlock = array("result" => $getBlock);
        $jsonGetBlock = json_encode($arrayGetBlock, true);
        
        //VENGONO RECUPERATI TUTTI I CAMPI DI OGNI BLOCCO
        $resBlock = $jsonGetBlock["result"];

        $hash = $resBlock["hash"];
		$confirmations = $resBlock["confirmations"];
		$strippedsize = $resBlock["strippedsize"];
		$size = $resBlock["size"];
		$weight = $resBlock["weight"];
		$height = $resBlock["height"];
		$version = $resBlock["version"];
		$versionHex = $resBlock["versionHex"];
		$merkleroot = $resBlock["merkleroot"];
        $time = $resBlock["time"];
		$mediantime = $resBlock["mediantime"];
		$nonce = $resBlock["nonce"];
		$bits = $resBlock["bits"];
		$difficulty = $resBlock["difficulty"];
		$chainwork = $resBlock["chainwork"];
		$previousblockhash = $resBlock["previousblockhash"];
		$nextblockhash = $resBlock["nextblockhash"];



        //INSERIMENTO DEI DATI DEL BLOCCO NEL DB (DA FARE QUI!!!!!)
        //------------------------------------------------------------------------------------------------------------
        $sql_query = "INSERT INTO blockchainSchema.Block VALUES ('".$hash."',".$confirmations.",".$strippedsize.",".$size.",".$weight.",".$height.",".$version.",'".$versionHex."','".$merkleroot."',".$time.",".$mediantime.",".$nonce.",'".$bits."',".$difficulty.",'".$chainwork."','".$previousblockhash."','".$nextblockhash."')";

        /*$ret = pg_query($db_connection, $sql_query); DA ERRORE PERCHE NON CI SONO GLI HASH PRECEDENTI E SUCCESSIVI

        if(!$ret){
            echo pg_last_error($db_connection);
        } else {
            echo "Records created successfully\n";
        }
        PRIMA VIENE INSERITA LA TUPLA CORRENTE CON nextblockhash A NULL, POI AL PASSO SUCCESSIVO DI FA UPDATE DELLA RIGA PREDENTE E SI METTE AL POSTO DEL NULL L'HASH DI QUELLO ATTUALE
        */
   
        //------------------------------------------------------------------------------------------------------------


        echo "BLOCK <br>".$hash."<br>".$confirmations."<br>".$strippedsize."<br>".$size."<br>".$weight."<br>".$height."<br>".$version."<br>".$versionHex."<br>".$merkleroot."<br>".$time."<br>".$mediantime."<br>".$nonce."<br>".$bits."<br>".$difficulty."<br>".$chainwork."<br>".$previousblockhash."<br>".$nextblockhash."<br><br>";

        //CICLO SU TUTTI GLI HASH DELLE TRANSAZIONI
        //for($tr = 0; $tr < sizeof($jsonGetBlock["result"]["tx"]); $tr++){
            
            //RECUPERO L'HASH DELLA TRANSAZIONE
            $tr = 0;//da cencellare!!!
            $transactionHash = $resBlock["tx"][$tr];

            //RECUPERO TUTTI I DATI DELLA TRANSAZIONE $transactionHash:  attraverso la chiamata -> getrawtransaction()
            $getRawTransaction = $bitcoin->getrawtransaction($transactionHash,1);
            $arrayGetRawTransaction = array("result" => $getRawTransaction);
            $jsonGetRawTransaction = json_encode($arrayGetRawTransaction, true);

            //VENGONO RECUPERATI TUTTI I CAMPI DELLA TRANSAZIONE
            $resTr = $jsonGetRawTransaction["result"];//salvo in $res il json relativo a ["result"]

            $hex = $resTr["hex"];
            $txid = $resTr["txid"];
            $hash = $resTr["hash"];
            $size = $resTr["size"];
            $vsize = $resTr["vsize"];
            $version = $resTr["version"];
            $locktime = $resTr["locktime"];
            $blockhash = $resTr["blockhash"];
            $confirmations = $resTr["confirmations"];
            $time = $resTr["time"];
            $blocktime = $resTr["blocktime"];

            echo "TRANSACTION <br>".$hex."<br>".$txid."<br>".$hash."<br>".$size."<br>".$vsize."<br>".$version."<br>".$locktime."<br>".$blockhash."<br>".$confirmations."<br>".$time."<br>".$blocktime."<br><br>";
            
            //INSERIMENTO DEI DATI DELLA TRANSAZIONE NEL DB (DA FARE QUI!!!!!)

            if($tr != 0){//la prima transazione è diversa perchè riguarda il blocco che ha vinto la "proof of work" (NON PRENDO vin)
                
                //VIENE LETTO L'INPUT DELLA TRANSAZIONE
                for($in = 0; $in < sizeof($res["vin"]); $in++){
                    
                    //VENGONO RECUPERATI TUTTI I CAMPI DELL'INPUT DELLA TRANSAZIONE
                    $resVin = $resTr["vin"][$in];//salvo in $resVin il json relativo a ["result"]["vin"]
                    
                    $txid_prev = $resVin["txid"];
                    $vout = $resVin["vout"];
                    $asm = $resVin["scriptSig"]["asm"];
                    $hex = $resVin["scriptSig"]["hex"];
                    $sequence = $resVin["sequence"];
                    
                    //INSERIMENTO DEI DATI DI INPUT DELLA TRANSAZIONE NEL DB (DA FARE QUI!!!!! e questi qui sotto)
                    
                    echo "VIN <br>".$txid_prev."<br>".$txid."<br>".$vout."<br>".$asm."<br>".$hex."<br>".$sequence."<br><br>";
                    
                }
                 
            }

            //VIENE LETTO L'OUTPUT DELLA TRANSAZIONE
            for($out = 0; $out < sizeof($res["vout"]); $out++){
                
                //VENGONO RECUPERATI TUTTI I CAMPI DELL'OUTPUT DELLA TRANSAZIONE
                $resVout = $resTr["vout"][$out];//salvo in $resVout il json relativo a ["result"]["vout"]
                
                $value = $resVout["value"];
				$n = $resVout["n"];
				$asm = $resVout["scriptPubKey"]["asm"];
				$hex = $resVout["scriptPubKey"]["hex"];
                
				if(isset($resVout["scriptPubKey"]["reqSigs"])){//può non essere presente
                    $reqSigs = $resVout["scriptPubKey"]["reqSigs"];
                }
                else{
                    $reqSigs = null;
                }
                
				$type = $resVout["scriptPubKey"]["type"];
				
                if(isset($resVout["scriptPubKey"]["addresses"])){//può non essere presente
                    $addresses = $resVout["scriptPubKey"]["addresses"][0];//sempre se è solo 1 (addresses è ambiguo)
                }
                else{
                    $addresses = null;
                }
                
                //INSERIMENTO DEI DATI DI OUTPUT DELLA TRANSAZIONE NEL DB (DA FARE QUI!!!!! e questi qui sotto)
                
                echo "VOUT <br>".$txid."<br>".$value."<br>".$n."<br>".$asm."<br>".$hex."<br>".$reqSigs."<br>".$type."<br>".$addresses."<br><br>";
                
            }
           
    
        //}
        
        
        
    //}

    pg_close($db_connection);
    
?>