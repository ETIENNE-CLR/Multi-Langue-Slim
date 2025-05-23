#!/bin/bash

# Tester si l'agent de connection est lançé :
eval "$(ssh-agent -s)"

# Obtention du nom de la clé privée
cleSSH="Cle_github"     # Clé de mon PC portable
cleSSH="id_rsa"         # Clé de mon PC gaming
cleSSH="etienneclr_key" # Clé du PC de l'école

# Ajouter votre clef privée à l'agent
ssh-add ~/.ssh/$cleSSH
ssh-add -l
ssh -T git@github.com

# LA COMMANDE A EXECUTER !!!
git push --force
# git pull --force