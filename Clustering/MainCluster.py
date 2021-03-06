import first_heur
import psycopg2
import sys
import pprint
 
def main():
    #CONNESSIONE AL DB
    conn_string = "host='141.250.25.151' dbname='bc' user='bc' password='Pr1nt23'"
    print "Connecting to database\n	->%s" % (conn_string)
    conn = psycopg2.connect(conn_string)
    conn.autocommit = True
    cursor = conn.cursor()

    #QUERY DATI IN INPUT PER LO SCRIPT
    print "Estraggo i dati dal DB"
    cursor.execute("SELECT DISTINCT tx_input.txid,addresses FROM blockchainschema.tx_input JOIN blockchainschema.addresses ON (addresses.txid = tx_input.txid_prev) AND (n = vout) ORDER BY tx_input.txid LIMIT 20000")
    records = cursor.fetchall()
    print "Estrazione completata"
    x = first_heur.leftGroup(records)
    #APRO IL FILE IN CUI HO SCRITTO IN 
    #f = open('firstHeuristic.csv', 'r')
    #print "Inserisco dati all'interno della Tabella"
    #cursor.copy_from(f, 'blockchainschema.isole',',',columns=('id_isola','tx_id'))
    #print "Inserimento completato"
    #f.close()
    #conn.close()
	
if __name__ == "__main__":
    main()
