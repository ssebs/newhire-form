#!/usr/bin/python3
import smtplib, sys, os
import yaml
from email.mime.text import MIMEText
from email.mime.multipart import MIMEMultipart
from jinja2 import Template

###
#  newhire-main - Parse yml and send various emails to helpdesk / insert into PeopleDB.
#  - Sebastian Safari (c) 2018
###

##
#   General Structure: 
#   - Function Defs
#   - ToDo's
#   - Global Vars
#   - Main Code Entry
#     - Loop over yml files
#     - Generate emails   
#     - Send Emails 
#     - Move yml files
#     - (Todo...) Start proccess to review before entering into PeopleDB
#     - (Todo...) Insert into PeopleDB 
##
## Function Definitions ##

def readYaml(filename):
    with open(filename, "r") as f:
        yaml_out = yaml.load(f, Loader=yaml.BaseLoader)
    #print(yaml_out)
    return yaml_out
# End readYaml

def renderTemplate(varsIn,templateFile):
    loaded_template = ""
    with open(templateFile) as file:
        for f in file:
            loaded_template += f
    #print(loaded_template)
    template = Template(loaded_template)
    return template.render(varsIn)
# End renderTemplate

def sendEmail(em_to,em_from,subj,body):
        # Send email
        msg = MIMEMultipart() 
        msg['From'] = em_from
        msg['To'] = ','.join(em_to)
        msg['Subject'] = subj
        msg.attach(MIMEText(body, 'plain'))
        text=msg.as_string()

        # Send the message via our SMTP server
        s = smtplib.SMTP('smtp.ssebs.com')
        s.sendmail(em_from,em_to, text)
        s.quit()        
# end sendEmail

#### TODOs ####
# 1) figure out how to import this into the peopledb...
#   1.1) ~~especially the manager part...~~
#   1.2) Create a review process
# 2) look into making Sharepoint form, see what limitations that has


## Variable Definitions ##
__DEBUG = False # Email send or just print
__DEBUG_TO_ME = False # Send the emails to just ssafari@ssebs.com
user = {}  # Data read in from yml file, used to generate content
ymlDir = "./usr-yml/"
templateDir = "./templates/"

##### Main Start Point #####

# Read yml file to send emails
for f in os.listdir(ymlDir):
    if(f.endswith(".yml")):
        #print("yaml file: " + ymlDir + f)
        tmp = readYaml(ymlDir + f)
        user = tmp[0]   # user now has a dictionary with all values in the yml file
        tmp = None

        ## Email vars ##
        _from = user['requestor']
        if __DEBUG_TO_ME:
            _to = ['ssafari@ssebs.com', _from]  # You can send to multiple by adding more fields
        else:
            _to = ['helpdesk@ssebs.com', _from]  # You can send to multiple by adding more fields


        # Render templates to email text from user yml data
        email_acct = renderTemplate(user, templateDir + "account-email.jinja2")
        email_comp = renderTemplate(user, templateDir + "computer-email.jinja2")
        email_phone = renderTemplate(user, templateDir + "phone-email.jinja2")

        #print("Email acct: " + email_acct + "\n")
        #print("Email comp: " + email_comp + "\n")
        #print("Email phone: " + email_phone + "\n")

        ## Account Email
        _subj = "New Account Request for " + user['first_name'] + " " + user['last_name'] + ", starting " + user["start_dt"]
        _body = email_acct
        if __DEBUG:
            print(str(_to) +str(_from) +str(_subj) + str(_body))
        else:
            sendEmail(_to,_from,_subj,_body)
        print("Account Email sent to helpdesk for " + user['first_name'] + " " + user['last_name'])

        ## Phone Email
        if "yes" in user['phone']:    
            _subj = "New Phone Request for " + user['first_name'] + " " + user['last_name'] + ", starting " + user["start_dt"]
            _body = email_phone
            if __DEBUG:
                print(str(_to) +str(_from) +str(_subj) + str(_body))
            else:
                sendEmail(_to,_from,_subj,_body)
            print("Phone Email sent to helpdesk for " + user['first_name'] + " " + user['last_name'])

        ## Computer Email
        if "other" in user['comp']:
            _subj = "New Computer Request for " + user['first_name'] + " " + user['last_name'] + ", starting " + user["start_dt"]
            _body = email_comp
            if __DEBUG:
                print(str(_to) +str(_from) +str(_subj) + str(_body))
            else:
                sendEmail(_to,_from,_subj,_body)
            print("Computer Email sent to helpdesk for " + user['first_name'] + " " + user['last_name'])

        elif "none" in user['comp']:
            pass    # Don't send an email if they put "None" in the computer field
        else:
            _subj = "New " + user['comp'].capitalize() + " Computer Request for " + user['first_name'] + " " + user['last_name'] + ", starting " + user["start_dt"]
            _body = email_comp
            if __DEBUG:
                print(str(_to) +str(_from) +str(_subj) + str(_body))
            else:
                sendEmail(_to,_from,_subj,_body)
            print("Computer Email sent to helpdesk for " + user['first_name'] + " " + user['last_name'])

        # Move these files to the old dir
        if not __DEBUG:
            os.system("mv ./usr-yml/" + f + " ./usr-yml/old/")
