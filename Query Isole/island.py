# -*- coding: cp1252 -*-
def member(nodo,lista):
    if (nodo in lista) == True:
        return True
    else:
        return False

def trova_vicini(nodo,visitati,vicini,edges):
    for a in edges:
        if (a[0] == nodo):
            if(member(a[1],visitati)==False):
                vicini.append(a[1])
        if (a[1] == nodo):
            if(member(a[0],visitati)==False):
                vicini.append(a[0])
    return vicini

def lista_nodi(archi):
    nodi = []
    for a in archi:
        nodi = nodi + [a[0]]
        nodi = nodi + [a[1]]
    nodi = list(set(nodi))
    return nodi
def lista_miner(archi):
    miner = []
    for a in archi:
        if miner != None:
            miner = miner + [a[0]]
    miner = list(set(miner))
    return miner
    
def componenti(edges,real_comp):
    componenti = []
    nodi = lista_nodi(edges)
    miner = lista_miner(edges)
    visitati = []
    #print "-----NODI ------" + str(nodi)
    #print "-----MINER ------" + str(miner) 

    #prendo un nodo
    for nodo in nodi:
        #se non è visitato lo inserisco in coda
        if (member(nodo,visitati)) == False:
            comp = []
            coda = []
            coda.append(nodo)
            #fino a che la coda non è vuota
            while coda != []:
                #estraggo un elemento
                elemento = coda.pop()
                #trovo i vicini del nodo
                vicini = []
                trova_vicini(elemento,visitati,vicini,edges)
                #per ogni vicino
                for vicino in vicini:
                    #lo aggiungo alla coda
                    if(member(vicino,coda)==False:
                        coda.append(vicino)
                visitati.append(elemento)
                comp.append(elemento)
            componenti.append(comp)
    for e in componenti:
        real_comp.append(list(set(e).intersection(set(miner))))
    #print "-----REAL COMP ------" + str(real_comp)
    d = 1
    out_file = open("isola.csv","w")
    
    for c in real_comp:
        for x in c:
            out_file.write(str(d) + ','  + str(x) + '\n')
        d = d + 1
    out_file.close()  
