#! /usr/bin/env python
# -*- coding: utf-8 -*-
#   Gter Copyleft 2018
#   Roberto Marzocchi

import os, sys
import ssl
import urllib.request
import xml.etree.ElementTree as et

import psycopg2
from conn import *

import datetime
import telepot
import json

import config

# Il token è contenuto nel file config.py e non è aggiornato su GitHub per evitare utilizzi impropri
TOKEN = config.TOKEN
TOKENCOC = config.TOKEN_COC

bot = telepot.Bot(TOKEN)
botCOC = telepot.Bot(TOKENCOC)

#per ora solo un test su Simone
#chat_id = config.chat_id


sito_allerta = "https://allertaliguria.regione.liguria.it"
abs_path_bollettini = "/opt/rh/httpd24/root/var/www/html"


def urllibwrapper(url):
    try:
        f = urllib.request.urlopen(url)
    except urllib.error.URLError:
        ctx = ssl.create_default_context()
        ctx.check_hostname = False
        ctx.verify_mode = ssl.CERT_NONE
        f = urllib.request.urlopen(url, context=ctx)

    return f


def scarica_bollettino(tipo, nome, ora):
    if not os.path.isfile("{}/bollettini/{}/{}".format(abs_path_bollettini, tipo, nome)):
        if ora != 'NULL':
            data_read = datetime.datetime.strptime(ora,"%Y%m%d%H%")
            print(data_read)
            
        # f = urllib.request.urlopen("{}/docs/{}".format(sito_allerta,nome))
        f = urllibwrapper("{}/docs/{}".format(sito_allerta, nome))

        data = f.read()

        with open("{}/bollettini/{}/{}".format(abs_path_bollettini, tipo, nome), "wb") as code:
            code.write(data)
        conn = psycopg2.connect(host=ip, dbname=db, user=user, password=pwd, port=port)
        curr = conn.cursor()
        conn.autocommit = True
        if ora != 'NULL':
            query = "INSERT INTO eventi.t_bollettini(tipo, nomefile, data_ora_emissione)VALUES ('{}', '{}', '{}');".format(tipo, nome, data_read)
        else:
            query = "INSERT INTO eventi.t_bollettini(tipo, nomefile)VALUES ('{}', '{}');".format(tipo, nome)

        curr.execute(query)
        
        print("Download of type {} completed...".format(tipo))
        print(datetime.datetime.now())
        
        # Send message with bot 
        if tipo == 'PC':
            print("Bollettino di PC")
            messaggio = "{}/docs/{}".format(sito_allerta, nome)
            
            # ciclo su tutte le chat_id
            query_chat_id = "SELECT telegram_id from users.v_utenti_sistema where telegram_id !='' and telegram_attivo='t' and (id_profilo='1' or id_profilo ='2' or id_profilo ='3');"
            curr.execute(query_chat_id)
            lista_chat_id = curr.fetchall() 

            for row in lista_chat_id:
                chat_id = row[0]
                # print(chat_id)
                try:
                    bot.sendMessage(chat_id, "Nuovo bollettino Protezione civile!\n\n{}".format(messaggio))
                except:
                    print('Problema invio messaggio all\'utente con chat_id={}'.format(chat_id))
                #bot.sendMessage(chat_id, messaggio)
                #time.sleep(1)
            
            query_coc = "SELECT telegram_id from users.utenti_coc;"
            curr.execute(query_coc)
            lista_coc = curr.fetchall() 
            for row_coc in lista_coc:
                chat_id_coc=row_coc[0]
                try:
                    msg_bollettino = os.popen("curl -d '{\"chat_id\":%s, \"text\":\"Nuovo bollettino Protezione civile!\n\n%s\"}' -H \"Content-Type: application/json\" -X POST https://api.telegram.org/bot%s/sendMessage"%(chat_id_coc, messaggio, TOKENCOC)).read()
                    msg_bollettino_j = json.loads(msg_bollettino)
                    if msg_bollettino_j['ok'] == True:
                        os.system("curl -d '{\"chat_id\":%s, \"text\":\"Protezione Civile informa che è stato emanato lo stato di Allerta meteorologica come indicato nel Messaggio allegato. Si prega di dare riscontro al presente messaggio premendo il tasto OK sotto indicato\", \"reply_markup\": {\"inline_keyboard\": [[{\"text\":\"OK\", \"callback_data\": \"ricevuto\"}]]} }' -H \"Content-Type: application/json\" -X POST https://api.telegram.org/bot%s/sendMessage"%(chat_id_coc, TOKENCOC))
                        #query insert DB
                        query_convocazione="INSERT INTO users.t_convocazione(data_invio, id_telegram) VALUES (date_trunc('hour', now()) + date_part('minute', now())::int / 10 * interval '10 min', {});".format(chat_id_coc)
                        curr.execute(query_convocazione)
                except Exception as e:
                    print(e)
                    print('Problema invio messaggio all\'utente del coc con chat_id={}'.format(chat_id_coc))
                
    else:
        print("File of type {} already downloaded".format(tipo)) 


def main():
    url="{}/xml/allertaliguria.xml".format(sito_allerta);
    # file = urllib.request.urlopen(url)
    file = urllibwrapper(url)

    data = file.read()
    file.close()

    nomefile = "{}/bollettini/allerte.txt".format(abs_path_bollettini)
    log_file_allerte = open(nomefile,"w")

    root = et.fromstring(data)

    # stampo la data di emissione a log
    dataEmissione = datetime.datetime.strptime(root.attrib['dataEmissione'],"%Y%m%d%H%M")
    print("Ultimo aggiornamento: {}".format(dataEmissione))
    log_file_allerte.write("Ultimo aggiornamento: {}\n".format(dataEmissione))
        
    # messaggio PROTEZIONE CIVILE (DA DECOMMENTARE)
    for elem in root.findall('MessaggioProtezioneCivile'):
        bollettino = elem.attrib['nomeFilePDF']
        
        if bollettino:
            scarica_bollettino("PC", bollettino, 'NULL')

   
    # meteo ARPA
    for elem in root.findall('MessaggioMeteoARPAL'):
        bollettino = elem.attrib['nomeFilePDF']
        emissione = elem.attrib['dataEmissione']

        if bollettino:
            scarica_bollettino("Met_A", bollettino, emissione)


    # Idrologico ARPA
    for elem in root.findall('MessaggioIdrologicoARPAL'):
        bollettino=elem.attrib['nomeFilePDF']
        emissione = elem.attrib['dataEmissione']
        
        if bollettino:
            scarica_bollettino("Idr_A", bollettino, emissione)

    # Nivologico ARPA
    for elem in root.findall('MessaggioNivologicoARPAL'):
        bollettino=elem.attrib['nomeFilePDF']
        emissione = elem.attrib['dataEmissione']
        
        if bollettino:
            scarica_bollettino("Niv_A", bollettino, emissione)

    # Leggi allerte
    for elem in root.findall('Zone'):
        for zone in elem.findall('Zona'):
            zona = zone.attrib["id"]
            if zona == 'B':
                for allerte in zone.findall('AllertaIdrogeologica'):
                    log_file_allerte.write('\n<br><b>Allerta Idrogeologica Zona B</b>')
                    log_file_allerte.write("\n<br>PioggeDiffuse={}".format(allerte.attrib['pioggeDiffuse']))
                    log_file_allerte.write("\n<br>Temporali={}".format(allerte.attrib['temporali']))
                    log_file_allerte.write("\n<br>Tendenza={}".format(allerte.attrib['tendenza']))

                for allerte in zone.findall('AllertaNivologica'):
                    log_file_allerte.write('\n<br><b>Allerta Nivologica Zona B</b>')
                    log_file_allerte.write("\n<br>Neve={}".format(allerte.attrib['neve']))
                    log_file_allerte.write("\n<br>tendenza={}".format(allerte.attrib['tendenza']))
                    
            
    log_file_allerte.close


if __name__ == "__main__":  
    # Cerco il percorso al file python
    path = os.path.dirname(os.path.abspath(__file__))

    # redirigo i print su un log message
    old_stdout = sys.stdout
    logfile = "{}/readxml.log".format(path)
    log_file = open(logfile, "w")
    sys.stdout = log_file
    
    print(datetime.datetime.now())
    main()

    # Chiusura file di log
    sys.stdout = old_stdout
    log_file.close()
