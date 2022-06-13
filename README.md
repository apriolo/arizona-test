# Arizona Test
Desenvolver uma aplicação em PHP que permita o usuário a visualizar uma tabela de países e siglas (Brasil - BR), 
o usuário pode ordenar a lista por Nome ou Abreviação, o usuário também pode fazer o download da listagem em
um arquivo CSV. É necessário também fazer o import de uma listagem disponibilizada quando rodar a migration da tabela.

Develop an application in PHP that allows the user to view a table of countries and acronyms (Brazil - BR),
user can sort the list by Name or Abbreviation, user can also download the listing at
a CSV file. It is also necessary to import a list available when running the table migration.


# Technologies
Docker
Symfony 5.4
PHP 7.4
MySQL 8
NGINX Server

# Environment
Before install the project you need install docker (need docker install [install here](https://www.github.com/octokatherine))

### Docker Commands
Need up the containers, on the docker-compose.yml path, type:
```bash
  docker-compose up -d --build
```
With the containers upped, you can access it by command

PHP
```bash
  docker exec -ti dev-php bash
```
Mysql
```bash
  docker exec -ti dev-mysql bash
```
### Install project commands
Enter into php console by command docker exec
and execute composer install.
```bash
  composer install
```
Need create the database
```bash
  php bin/console doctrine:database:create
```
Run the migrations
```bash
  php bin/console doctrine:migrations:migrate
```
This command will execute the command to import csv data too.

Now the application is running on 8080 port: http://localhost:8080/

## Additional commands
The application contains a service to import a csv data.
to use it you need to input a csv file in the src/Utils path with the format name,abbreviation rows.
on the terminal you can use the command
```bash
  php bin/console csv:importCountry filename.csv
```
filename.csv is the your file name.
# Application
#### In the index page a list with the countries is showing to user.
![image](https://user-images.githubusercontent.com/77355017/173259611-54f0cfa8-11f0-4c1f-bc09-b30e26780e95.png)
#### You can sort by name or abbreviation and do download of list
![image](https://user-images.githubusercontent.com/77355017/173259817-53052c6a-0ca6-4199-9a36-513cf75cc78e.png)


# API

#### Index
Method to get all countries
```http
  GET /api/countries
```

| Parâmetro   | Tipo       | Descrição                                   |
| :---------- | :--------- | :------------------------------------------ |

Response a list of Country
```
"data": [
        {
            "id": 12,
            "name": "American Samoa",
            "abbreviation": "AS"
        },
        ...
```

#### Create
Method to create a new Country
```http
  POST /api/countries
```

| Parâmetro   | Tipo       | Descrição                                   |
| :---------- | :--------- | :------------------------------------------ |
| `name`      | `string` | **Required**, The Country name |
| `abbreviation`| `string` | **Required**, The Country abbreviation |

Response
```
"status": "200",
"data": "Created"
```

#### Show
Method to show a country by id
```http
  GET /api/countries/{id}
```

| Parâmetro   | Tipo       | Descrição                                   |
| :---------- | :--------- | :------------------------------------------ |
| `{id}`      | `int` | **Required**, The Country ID |

Response
```
"data": {
        "id": 2,
        "name": "United Arab Emirates",
        "abbreviation": "AE"
    }
```

#### Update
Method to update a country by id
```http
  PUT /api/countries/{id}
```

| Parâmetro   | Tipo       | Descrição                                   |
| :---------- | :--------- | :------------------------------------------ |
| `{id}`      | `int` | **Required**, The Country ID |
| `name`      | `string` | The Country name |
| `abbreviation`| `string` | The Country abbreviation |

Response
```
"data": "update success"
```

#### Delete
Method to delete a country by id
```http
  DELETE /api/countries/{id}
```

| Parâmetro   | Tipo       | Descrição                                   |
| :---------- | :--------- | :------------------------------------------ |
| `{id}`      | `int` | **Required**, The Country ID |

Response
```
"data": "delete success"
```

You can see a postman sample [here](https://github.com/apriolo/arizona-test/blob/master/Arizona.postman_collection.json)



