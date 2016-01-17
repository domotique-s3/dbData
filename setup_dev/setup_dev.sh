if [ $USER != "postgres" ]
then
    echo "Vous devez etre connecte avec l'utilisateur 'postgres'"
    exit
fi

# Creer la base de donnees postgresql
printf "\033[01;32m"
printf "\nCreation de la base de donnees...\n"
printf "\033[00;00m"

psql -f sql/create_db.sql

# Creer les tables
printf "\033[01;32m"
printf "\nCreation des tables...\n"
printf "\033[00;00m"

psql -d dbcharts -f sql/create_tables.sql

# Creer l'utilisateur
printf "\033[01;32m"
printf "\nCreation de l'utilisateur...\n"
printf "\033[00;00m"

psql -d dbcharts -f sql/create_user.sql

# Donner les droits a l'utilisateur
printf "\033[01;32m"
printf "\nAttribution des droits...\n"
printf "\033[00;00m"

psql -d dbcharts -f sql/set_user_rights.sql

# Inserer les valeurs
printf "\033[01;32m"
printf "\nInsertion des valeurs...\n"
printf "\033[00;00m"

psql -d dbcharts -f sql/insert_values.sql
