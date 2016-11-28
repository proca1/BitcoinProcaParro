#!/usr/bin/env python3

from bitcoin_functions import *
from sys import exit
import urllib
import csv, re, os

try:
	html = urllib.urlopen('http://blockchain.info/tags?filter=4').read().decode('utf-8')
except urllib.URLError as e:
	print(e.reason)
	exit(1)

results = re.findall(r"<span class=\"tag\" id=\"(\b1[123456789ABCDEFGHJKLMNPQRSTUVWXYZabcdefghijkmnopqrstuvwxyz]{20,40}\b)\">([^\"]+)</span>", html)

with open('bitcoinotc.csv', 'a') as f:
	writer = csv.writer(f, delimiter=',',
                            quotechar='"', quoting=csv.QUOTE_MINIMAL)

	for result in results:
		address, username = result
		print("Adding user %s with address %s..." % (username, address))
		writer.writerow([address, username])
		if not isBTCAddress(address):
			continue

		

#os.system("cp ../Lists/bitcoinotc.csv ./tmp/temp-bitcoinotc.csv")
#os.system("cat ./tmp/temp-bitcoinotc.csv | sort | uniq > ../Lists/bitcoinotc.csv")
#os.system("rm -f ./tmp/temp-bitcoinotc.csv")
