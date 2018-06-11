from jinja2 import Template
import yaml

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