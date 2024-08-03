if [ "$#" -ne 2 ]; then
    echo "Usage: $0 <mysql_username> <mysql_password>"
    exit 1
fi

MYSQL_USER=$1
MYSQL_PASSWORD=$2


# Run the SQL files
mysql -u"$MYSQL_USER" -p"$MYSQL_PASSWORD" < "setup.sql"
if [ $? -ne 0 ]; then
    echo "Error running \"setup.sql\""
    exit 1
fi

mysql -u"$MYSQL_USER" -p"$MYSQL_PASSWORD" < "dummyData.sql"
if [ $? -ne 0 ]; then
    echo "Error running \"dummyData.sql\""
    exit 1
fi

echo "Dummy database setup successfully."
