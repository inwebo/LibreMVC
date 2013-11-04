#!/bin/bash
 
clear
while [ 1 ]; do                                 # permet une boucle infinie
echo "#########################################################################"
echo "# Commands                                                              #"
echo "# sites                                                                 #"
echo "# newsite                                                               #"
echo "# deletesite                                                            #"
echo "#########################################################################"
echo -n ""james"@"$HOSTNAME"$ "                    # qui s'arrête avec break
read commande
 
case $commande in

  sites ) #Sites
    bash ./sites.sh;;

  help | hlp )
     echo "A propos de TS --> about"
     echo "ls --> liste les fichiers"
     echo "rm --> détruit un fichier (guidé)"
     echo "rmd --> efface un dossier (guidé)"
     echo "noyau --> version du noyau Linux"
     echo "connect --> savoir qui s'est connecté dernièrement";;
  ls )
     ls -la;;
  rm )
     echo -n "Quel fichier voulez-vous effacer : "
     read eff
     rm -f $eff;;
  rmd | rmdir )
     echo -n "Quel répertoire voulez-vous effacer : "
     read eff
     rm -r $eff;;
  noyau | "uname -r" )
     uname -r;;
  connect )
     last;;
  about | --v | vers )
     echo "Script simple pour l'initiation aux scripts shell";;
  quit | "exit" )
     echo Au revoir!!
     break;;
  * )
    echo "Commande inconnue";;
esac
done
exit 0