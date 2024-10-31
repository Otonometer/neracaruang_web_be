# Generator API Scaffold

    php artisan generate:api $MODEL_NAME
    php artisan generate:scaffold $MODEL_NAME
    php artisan generate:api_scaffold $MODEL_NAME

    php artisan generate:api_scaffold Post --skip=routes,migration,model

    php artisan generate:scaffold $MODEL_NAME --views=index,create,edit,show
    php artisan generate:scaffold $MODEL_NAME --save
    php artisan generate:scaffold $MODEL_NAME --tableName=custom_table_name
    php artisan generate:scaffold $MODEL_NAME --fromTable --tableName=$TABLE_NAME
    php artisan generate:scaffold $MODEL_NAME --fromTable --tableName=$TABLE_NAME --connection=connectionName
    php artisan generate:scaffold $MODEL_NAME --primary=custom_name_id
    php artisan generate:scaffold $MODEL_NAME --prefix=v1/admin

    php artisan generate:migration $MODEL_NAME
    php artisan generate:model $MODEL_NAME
    php artisan generate:repository $MODEL_NAME
    php artisan generate.api:controller $MODEL_NAME
    php artisan generate.api:requests $MODEL_NAME
    php artisan generate.api:tests $MODEL_NAME
    php artisan generate.scaffold:controller $MODEL_NAME
    php artisan generate.scaffold:requests $MODEL_NAME
    php artisan generate.scaffold:views $MODEL_NAME

    php artisan generate:publish
    php artisan generate.publish:layout
    php artisan generate.publish:templates

_

# Rollback

Command type from api, scaffold or api_scaffold

    php artisan generate:rollback $MODEL_NAME $COMMAND_TYPE


If you have run migration on database, then better you rollback that migration first and then run generate:rollback command, since it will delete migration file as well. Otherwise laravel can throw error about missing migration files.

    php artisan generate:rollback $MODEL_NAME $COMMAND_TYPE --views=edit,create,index,show

_

# Fields input guide

| Supported HTML Input Types & Formats | Valid Examples |
| ----------- | ----------- |
| text | text |
| textarea | textarea |
| email | email |
| date | date |
| number | number |
| password | password |
| file (partially supported) | file |
| **select** | 
| select,value1,value2,value3 | select,Daily,Weekly,Monthly |
| select,label1:value1,label2:value2,label3:value3 | select,Sunday:0,Monday:1,Tuesday:2 |
| **select from existing table** | 
| selectTable:tableName:column1,column2 | selectTable:users:name,id |
| **Note** : where column1 is Option Label and column2 is Option Value | selectTable:categories:title,id |
| **checkbox** | checkbox |
| checkbox,value | checkbox,yes |
| | checkbox,1 |
| **radio** |
| radio,label1,label2 | radio,Male,Female |
| radio,label1:value1,label2:value2 | radio,Yes:1,No:0 |
| toggle switch	| toggle-switch |

_

# Field Inputs

Now, let's get started with specifying the field. There is some format in which we have to specify field inputs

    name db_type html_type options

Here is what this means,

- name - name of the field (snake_case recommended)

- db_type - database type. e.g.

        string - $table->string('field_name')
        string,25 - $table->string('field_name', 25)
        text - $table->text('field_name')
        For Enum, enum,Sun,Mon,Tue - $table->enum('field_name', ['Sun', 'Mon', 'Tue'])
        integer,false,true - $table->integer('field_name',false,true)
        string:unique - $table->string('field_name')->unique()
        For foreign keys,
        integer:unsigned:foreign,table_name,id - $table->foreign('field_name')->references('id')->on('table_name')
        integer:unsigned:foreign,table_name,id,cascade - $table->foreign('field_name')->references('id')->on('table_name')->onUpdate('cascade')->onDelete('cascade')

- html_type - html field type for forms. e.g.

        text
        textarea
        password

- options - Options to prevent field from being searchable, fillable, display in form & index

    Here are all options by which you can prevent it, these all fields should be passed by comma separated string.

        e.g. s,f,if,ii

        s - specify to make field non-searchable
        f - specify to make field non-fillable
        if - to skip field from being asked in form
        ii - to skip field from being displayed in index view
        iv - to skip field from being displayed in all views

    so here are some examples, how field inputs can be passed together

        title string text
        body text textarea s,ii
        email string:unique email
        writer_id integer:unsigned:foreign,writers,id text s

    Validations

    In second field you can specify validations for fields from any available validations of laravel.

    e.g.

        required
        min:5
        email
        numeric

    You can pass the exact same string as Laravel doc suggests. 
    for e.g. 
    
        required|unique:posts|max:255

    Generator also supports various other commands to generate files individually like generating an only model, repository or controller etc. You can find a full doc here.

### Fiels from file

    php artisan generate:scaffold $MODEL_NAME --fieldsFile=filename_from_model_schema_directory_OR_path_from_base_directory_OR_absolute_file_path

    {
        "name": "title",
        "dbType": "string,50",
        "htmlType": "text",
        "validations": "required",
        "searchable": true,
        "fillable": true,
        "primary": false,
        "inForm": true,
        "inIndex": true
    }

_

# Relationship

    php artisan generate:api_scaffold Post --relations

| Relationship Type	| Valid Examples |
| - | - |
| One to One | 1t1,Phone| 
| | 1t1,Phone,user_id |
| | 1t1,Phone,user_id,id |
| One to Many | 1tm,Comment |
| | 1tm,Comment,post_id |
| | 1tm,Comment,post_id,id |
| Many to One | mt1,Po s
| | mt1,Post,post_id |
| Many to Many	| mtm,Role |
| | mtm,Role,user_roles |
| | mtm,Role,user_roles,user_id,role_id |

    {
        "name": "writer_id",
        "dbType": "integer:unsigned:foreign,writers,id",
        "htmlType": "text",
        "relation": "mt1,Writer,writer_id,id"
    }

Some relationships, like One to Many do not have a local field in current model, but some other model contains its primary key as foreign key. In such cases, you can define relationship by following definition:

    {
        "type": "relation",
        "relation": "1tm,Comment,post_id"
    }

command line :

    relationship_type,model_name,field1,field2,field3

_

# Ignore Fields

While generating from table, if you want to skip certain type of fields like GeoPoint, Last Login time etc. which you do not expect user to insert via CRUD form, then you can use this option to specify those ignored fields.

    php artisan generate:scaffold $MODEL_NAME --ignoreFields=geo_location,last_login

available skip list

    migration
    model
    controllers
    api_controller
    scaffold_controller
    scaffold_requests
    routes
    api_routes
    scaffold_routes
    views
    tests
    menu
    dump-autoload

_

# Config

Repository

    'options' => 'repository_pattern' => true

_

# Addition

Seeder

    php artisan generate:scaffold $MODEL_NAME --seeder

Factory

    php artisan generate:scaffold $MODEL_NAME --factory

Swagger (/api/docs)

    "repositories": [
        {
            "type": "vcs",
            "url":  "git@github.com:InfyOmLabs/swaggervel.git"
        }
    ],
    "require": {
        "appointer/swaggervel": "dev-master",
        "infyomlabs/swagger-generator": "dev-master",
    },

Generate from Table

    "require": {
        "doctrine/dbal": "~2.3"
    }

# Middleware

Sanitazion Input

    ->middleware('sanitazion.input:*')

Note :

    - jika ingin semua inputan maka cukup gunakan * 
    - jika ingin hanya beberapa inputan, maka masukan request yang dikecualikan misalkan
        ->middleware('sanitazion.input:email,fullname')
_

File Upload

    ->middleware('file.upload:doc_ijazah,doc_sertifikat')

Note :
    - masukan input request file yang diinginkan


# Refs

https://fontawesome.com/v4.7.0/icons/

https://astronautweb.co/snippet/font-awesome/

https://adminlte.io/

https://github.com/dandisy/webcore

https://laravelcollective.com/
