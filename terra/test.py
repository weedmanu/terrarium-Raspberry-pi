#!/usr/bin/env python
# -*- coding: utf-8 -*-
import MySQLdb

db = MySQLdb.connect(host="localhost",    # your host, usually localhost
                     user="manu",         # your username
                     passwd="terra",  # your password
                     db="Terrarium")        # name of the data base

bdd = db.cursor()

# Use all the SQL you like
bdd.execute("SELECT * FROM config")

# print all the first cell of all the rows
for row in bdd.fetchall():
    print "0",row[0] 
    print "1",row[1]
    print "2",row[2]
    print "3",row[3]
    print "4",row[4]
    print "5",row[5]
    print "6",row[6]
    print "7",row[7]
    print "8",row[8]
    print "9",row[9]
    print "10",row[10]
    print "11",row[11]
    print "12",row[12]
    print "13",row[13]
    print "14",row[14] 
    

db.close()
