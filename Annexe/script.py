import os #pour lancer des cmd (UNIX)
import re #pour le regex
from bs4 import BeautifulSoup
import sys
import networkx as nx
import matplotlib.pyplot as plt

"""
@author : gouth
requirements :
pip install networkx
pip install bs4

outil pour cibler les failles dans le cadre du projet de synthèse
M2 - SSI 2020/21
"""

DEBUG = True

"""
beautiful soup va chercher plus en profondeur les données formulaires
FILE : nom du fichier 
NUM_LINE : numero de la ligne ou grep a repéré la regexp
TAUPE_PATH : chemin vers le nom du fichier
"""
def get_form_info(FILE, NUM_LINE, TAUPE_PATH):
	try:
		print("\n>>>FILE :"+TAUPE_PATH+FILE)
		fd = open(TAUPE_PATH+FILE, encoding="iso8859-1")
		with open(TAUPE_PATH+FILE, encoding="iso8859-1") as file:
			data = file.read()
			#print(data)
			soup = BeautifulSoup(data, 'html.parser')
			for form in soup.find_all('form'):
				if(DEBUG):
					print("\tmethode:",form.get('method'))
					print("\taction:",form.get('action'))
					fields = form.findAll('input')
					for field in fields:
						print("\t\tchamp:",field)
					print("_________________________\n\n")

		#print("_____________________end")
		fd.close()
		return None
	except Exception as e:
		print(e)
		exit(-1) 


"""
beautiful soup va chercher plus en profondeur les données ajax
FILE : nom du fichier 
NUM_LINE : numero de la ligne ou grep a repéré la regexp
TAUPE_PATH : chemin vers le nom du fichier
"""
def get_ajax_info(FILE, NUM_LINE, TAUPE_PATH):
	try:
		print("\n>>>FILE :"+TAUPE_PATH+FILE)
		fd = open(TAUPE_PATH+FILE, encoding="iso8859-1")
		with open(TAUPE_PATH+FILE, encoding="iso8859-1") as file:
			data = file.read()
			#print(data)
			soup = BeautifulSoup(data, 'html.parser')
			print(soup.prettify())
			exit(1)
			for form in soup.find_all('ajax'):
				print("AJAX : > "+ form)
				if(DEBUG):
					print("\tmethode:",form.get('method'))
					print("\taction:",form.get('action'))
					fields = form.findAll('input')
					for field in fields:
						print("\t\tchamp:",field)
					print("_________________________\n\n")
				
		#print("_____________________end")
		fd.close()
		return None
	except Exception as e:
		print(e)
		exit(-1) 



"""
permet à l'utilisateur de choisir ce qu'il veut faire dans le script
"""
def menuing():
	print("#################################")
	print("# Veuillez choisir une option : #")
	print("#################################")
	print("[1]: recherche des formulaires")
	print("[2]: recherche des requêtes ajax")
	print("[3]: recherche libre")
	print("[4]: généré le sitemap du site")
	print("[5]: exit")
	print("__________________________________")

	try:
		choix = int(input("> "))
		if(not (choix>0 and choix < 6)):
			raise Exception
		else:
			if(choix == 5):
				exit(1)
	except Exception:
		print("Veuillez choisir un numéro contenu dans la liste\nexit...")
		exit(1)
	
	return choix

"""
permet à l'utilisateur selon le choix de 
choix :
[1]: recherche des formulaires
[2]: recherche des requêtes ajax
[3]: recherche libre
"""
def build_cmd(choix):
	if (choix == 1): #recherche de formulaire
		CMD = "\"<form*\""
	if (choix == 2): #recherche de requete ajax
		CMD = "\"ajax*\""
	if (choix == 3): #recherche libre
		print("entrez la chaine que vous voulez chercher") 
		search = input("> ")
		CMD = "\""+search+"*\""
	
	return CMD
	
"""
effectue la recherche avec appel system à grep
choix : {1,2,3}
CMD : la commande system
TAUPE_PATH : chemin vers le dossier 
"""
def search(choix, CMD, TAUPE_PATH):
	try:
		print("appel system : " + CMD)
		output = os.system(CMD)
		#os.system("clear")
		with open("out_cmd") as f: #fichier ou le resultat de la commande est stockée
			all_lines = f.readlines()
			for line in all_lines: #lecture du fichier
				line = line.split(":") 
				
				FILE = line[0] #chemin du fichier ou grep trouve qqchose
				NUM_LINE = int(line[1]) #la ligne du fichier ou grep trouve
				if(choix==1):#formulaire
					get_form_info(FILE, NUM_LINE, TAUPE_PATH)

				elif(choix==2):#ajax
					get_ajax_info(FILE, NUM_LINE, TAUPE_PATH)

				else:#choix libre
					pass


	except Exception:
		exit(-1)



def test_graph():
	G = nx.petersen_graph()
	plt.subplot(121)
	nx.draw(G, with_labels=True, font_weight='bold')
	plt.subplot(122)
	nx.draw_shell(G, nlist=[range(5, 10), range(5)], with_labels=True, font_weight='bold')
	plt.show()
	

#construit le dico python pour le graphe des includes seulement
def build_dico():
	CMD = "grep -R --exclude-dir=js --exclude-dir=css --exclude-dir=font-awesome -n -e \"include*\" ../Projet > out_sitemap"
	os.system(CMD)
	DICO = dict()

	with open("out_sitemap") as f: #fichier ou le resultat de la commande est stockée
			all_lines = f.readlines()
			for line in all_lines: #lecture du fichier
				line = line.split(":") 
				
				FILE = line[0].split("../Projet")[-1] #chemin du fichier ou grep trouve qqchose
				NUM_LINE = int(line[1]) #la ligne du fichier ou grep trouve
				INCLUDED = line[2].lstrip("\t").lstrip(" ")
				#je rafine le nom du fichier pour qu'ils soient exact pcq dans un dico l'id est une clé 
				PAGE = INCLUDED.split("include")[1].replace(")", '').replace(";", '').replace("\"", '').replace("'", '')
				PAGE = PAGE.replace("(", '').replace("?", '').replace('>', '')

				if(PAGE[0]=="."):
					PAGE = PAGE[1:len(PAGE)]

				if(PAGE[0]!="/"):
					PAGE = "/"+PAGE

				PAGE = PAGE.replace(" ", "").replace("\n", "").replace("\r", "")


				if(DEBUG):
					print("FILE:",FILE)
					print("NUM_LINE",NUM_LINE)
					print("PAGE", PAGE)
					print("++++++++++++++++++")

				#construction du dico
				if(FILE not in DICO.keys()):#si on a pas déjà un noeud 
					DICO[FILE] = [] #on initialise le noeud avec une liste 

				DICO[FILE].append((FILE, PAGE)) 


	return DICO



def plot_graph(G):
	nx.draw(G, pos=nx.drawing.layout.planar_layout(G), with_labels=True, font_weight='bold')
	plt.show()

"""
la on va procéder a l'établissement du graph et du .xml du sitemap
"""
def generate_sitemap():
	
	#décommenter la ligne pour tester networkx et plot 
	#test_graph()
	
	G = nx.Graph() #creation du graph
	dico = build_dico()
	
	G.add_nodes_from(dico)
	for ptite_liste in dico.values():
		print("add : ", ptite_liste)	
		G.add_edges_from(ptite_liste)

	plot_graph(G)
	#exit(1)



def main():
	while(True):
		choix = menuing()
		if(choix!=4):
			#on renseigne le dossier ou cherche
			
			TAUPE_PATH = os.path.dirname(os.path.realpath(__file__))+"/"

		
			#on récupère la commande
			cmd = build_cmd(choix)
			CMD = "grep -R --exclude-dir=js --exclude-dir=css --exclude-dir=font-awesome -n -e "+cmd+" ../Projet > out_cmd"

			#on envoie la commande 
			search(choix, CMD, TAUPE_PATH)

		else:
			generate_sitemap()





if __name__ == "__main__":
    main()