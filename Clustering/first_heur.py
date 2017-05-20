# -*- coding: cp1252 -*-

#creo una lista dove ogni elemento sono gli input della stessa transazione
def groupByTransaction(transazioni):
    #inizializzo la transazione precedente e la lista delle transazioni
    precedente = transazioni[0][0]
    lista = []
    totale = []
    #per tutte le transazioni
    for a in transazioni:
        #essendo ordinate per tx posso controllare
        #quando sono arrivato alla fine
        #in modo da rimanere in O(n)
        if a[0] != precedente:
            totale.append(lista)
            lista = [a[1]]
            precedente = a[0]
        else:
            lista.append(a[1])
    totale.append(lista)
    return totale

def member(nodo,lista):
    if (nodo in lista) == True:
        return True
    else:
        return False

def lista_nodi(input):
    nodi = []
    for a in input:
        nodi = nodi + [a[1]]
    nodi = list(set(nodi))
    return nodi

def trova_vicini(nodo,input,visitati):
    vicini = []
    for a in input:
        #print "estraggo elemento " + str(a)
        if ((nodo in a) == True):
            for x in a:
                
                if (member(x,visitati) == False) & (x != nodo):
                    vicini.append(x)
            #print " vicini aggiunti " + str(vicini)
    return vicini


def leftGroup(input):
    #raggruppo per transazione
    #print "1) L'input è il seguente : " + str(input)
    trans = groupByTransaction(input)
    #print "2) Raggruppo per transazioni : " + str(trans)
    #trovo tutti i nodi
    nodi = lista_nodi(input)
    #print "3) Creo la lista dei nodi : " + str(nodi)
    componenti = []
    visitati = []
    #prendo un nodo
    for nodo in nodi:
        #print "4) prendo un nodo : " + str(nodo)
        #se non è visitato lo metto in coda
        if (member(nodo,visitati)) == False:
            #print "5) Il nodo " + str(nodo) + " non è visitato : " + str(visitati)
            comp = []
            coda = []
            coda.append(nodo)
            #print "6) aggiungo il nodo alla coda : " + str(coda)
            #fino a che non svuoto la coda
            while coda != []:
                #print "7) La coda non è vuota : " + str(coda)
                #estraggo un elemento dalla coda
                elemento = coda.pop()
                #print "8) Estraggo " + str(elemento) + " dalla coda " +str(coda)
                #trovo i vicini del nodo
                vicini = trova_vicini(elemento,trans,visitati)
                #print "9) Ha i seguenti vicini : " + str(vicini)
                #per ogni vicino
                for vicino in vicini:
                    #lo aggiungo  alla coda
                    if (member(vicino,coda) == False):
                        coda.append(vicino)
                #print "10) Ho aggiunto i seguenti vicini alla coda : " + str(coda)
                visitati.append(elemento)
                #print "11) aggiungo il nodo ai visitati : " + str(visitati)
                comp.append(elemento)
                #print "1) aggiungo l'elemento alla componente : " + str(comp)
            componenti.append(comp)
    d = 1
    out_file = open("first_heur.csv","w")
    
    for c in componenti:
        for x in c:
            out_file.write('user'+str(d) + ','  + str(x) + '\n')
        d = d + 1
    out_file.close()
                    
    

