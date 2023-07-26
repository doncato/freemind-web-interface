# Freemind Web-Interface

# xFree - eXtensible Freely Resolvable Event Emerger

Is a part of a project dedicated to provide a freely extensible Management tool
to organize your calendar, todos and so much more. It is simply build around
XML to organize your everyday life.

## SQL Setup instructions
These Instructions where designed with Mariadb in mind.
If you use a different Database Commands may differ.
### Set up Database
In this example the newly created database is called `freemind`, this database name
can be changed according to your needs, in which case you need to replace it with
the appropriate name

1. ```CREATE DATABASE freemind;```
2. ```USE freemind;```
3. ```CREATE TABLE logins (username varchar(255) NOT NULL UNIQUE, password varchar(255) NOT NULL, token varchar(255) NOT NULL UNIQUE, id int, PRIMARY KEY (id));```
4. ```CREATE TABLE sessions (session varchar(255), expires varchar(255) NOT NULL, id int NOT NULL, PRIMARY KEY(session));```

### Set up Database User
In this example the newly created user is called `freeadmin`, the password will be
`admind`. You'll most likely want to change those values in which case you need to
replace the words accordingly.

1. ```CREATE USER 'freeadmin'@'localhost' IDENTIFIED BY 'admind';```
2. ```GRANT ALL PRIVILEGES ON freemind.* TO 'freeadmin'@'localhost';```
