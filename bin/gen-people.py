import urllib.request
import re
import json
import os
###
#   Purpose of this file is to grab PARC users so the autofill will be populated
##

## Vars
pplFile = "./people.txt"

# Download phonelist for PARC
phoneList = urllib.request.urlopen("http://internal.ssebs.com/phonelist.txt")
list =  str(phoneList.read().decode("utf-8"))

# Split and parse it into just the users
tmp = re.split(r'^OTHER SITES$',list,flags=re.MULTILINE)
tmp2 = [line for line in tmp[0].split("\n") if line.strip() != ""]
tmp = ""
for l in tmp2:
    tmp += l + "\n"
tmp3 = re.split(r'accounts:  name@ssebs.com$',tmp,flags=re.MULTILINE)
peopleList = tmp3[1]

# Cleanup list of people
people = re.sub(r'\d+ ','',peopleList)
people = re.sub(r'\-','',people)
people = re.sub(r'\d+','',people)
people = re.sub(r'\[','(',people)
people = re.sub(r'\]',')',people)
people = re.sub(r'"','',people)

#print(people)
jsonOut = json.dumps(people.splitlines())
#print(jsonOut)
os.system("echo "" > " + pplFile)
with open(pplFile,"w") as f:
    f.write(jsonOut)
