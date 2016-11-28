#!/usr/bin/env python3

from sys import exit
from time import sleep
from bitcoin_functions import *
import urllib
import csv, re, os

try:
	with open('../Lists/bitcointalk.csv') as f:
		reader = csv.reader(f)
		min_userid = max(int(row[2]) for row in reader) + 1
except:
	min_userid = 1

try:
	html = urllib.urlopen('https://bitcointalk.org/index.php?action=stats').read().decode('ISO-8859-1')
except urllib.URLError as e:
	print(e.reason)
	exit(1)

result = re.search(r";u=([0-9]+)", html)
max_userid = int(result.group(1))

with open('bitcointalk.csv', 'a') as f:
	writer = csv.writer(f)

	for userid in range(min_userid, max_userid+1):
		# Anti DDoS
		sleep(1)
		print("Now scraping user %d..." % userid)
		try:
			html = urllib.urlopen('https://bitcointalk.org/index.php?action=profile;u=%d' % userid).read().decode('ISO-8859-1')
		except urllib.URLError as e:
			f.flush()
			f.close()
			print(e.reason)
			exit(1)

		try:
			result = re.search(r"<div class=\"signature\">.*(\b1[123456789ABCDEFGHJKLMNPQRSTUVWXYZabcdefghijkmnopqrstuvwxyz]{20,40}\b).*</div>", html)
			address = result.group(1)

			result = re.search(r"<title>View the profile of ([^<]+)</title>", html)
			user = result.group(1)

			print(address, user, userid)

		except:
			continue
		writer.writerow([address, user, userid])
		f.flush()
		if not isBTCAddress(address):
			continue



os.system("cp bitcointalk.csv ./tmp/temp-bitcointalk.csv")
os.system("cat ./tmp/temp-bitcointalk.csv | sort | uniq > bitcointalk.csv")
os.system("rm -f ./tmp/temp-bitcointalk.csv")
