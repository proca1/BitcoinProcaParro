def groupByTransaction(transazioni):
    precedente = transazioni[0][0]
    lista = [transazioni[0][1]]
    totale = []
    #per tutte le transazioni
    for a in transazioni:
        #essendo ordinate per tx posso controllare quando sono arrivato alla fine
        #in modo da rimanere in O(n)
        if a[0] != precedente:
            totale.append(lista)
            lista = [a[1]]
            precedente = a[0]
        else:
            lista.append(a[1])
    return totale



def leftGroup(input):
    #per tutti i gruppi di transazione
    print "-----------------------------------CLUSTER---------------------------"
    totale = []
    while input != []:
        #pongo l'elemento corrente uguale al gruppo estratto
        elem = input.pop()
        for confronto in input:
            if list(set(elem) & set(confronto))!=[]:
                print "raggruppo : " + str(elem) + " ----> " + str(confronto)
                elem = list(set(elem + confronto))
                input.remove(confronto)
        totale.append(elem)
    print "--------------------------------------------------------------------"
    return totale
                
        
