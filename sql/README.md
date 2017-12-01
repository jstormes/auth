# Automated Schema change deployment

This directory houses the database maintenance scripts.  These script provide the CI/CD process
with scripts that can be run alongside code deployments to maintain the database schema.  If 
you view the database schema as code then you should keep your schema changes with your code.

## RULES

You **MUST** follow these rules if you wish to use this database CI/CD process!

* All scripts **MUST** be runnable without damaging an existing database!
* All scripts **MUST** be re-runnable without damaging an existing database!
* Only scripts in `deployment` will be run in the deployed systems like QA, Stage and Production.
* Scripts in `base` are meant to build the base schema for development.  Must still be re-runnable.
* Scripts in `development` are meant to seed the development database.  Must still be re-runnable.
* Script are run in Unix/Linux `sort -V` order.  
* File names should start with 5 digits left padded with '0'.

## Re-runnable DDL Examples

### Creating a table 

```
CREATE TABLE IF NOT EXISTS oauth_scopes (
  type VARCHAR(255) NOT NULL DEFAULT "supported",
  scope VARCHAR(2000),
  client_id VARCHAR (80),
  is_default SMALLINT DEFAULT NULL
);
```

### Altering a table

```
SELECT count(*)
INTO @exist
FROM information_schema.columns
WHERE table_schema = database()
and COLUMN_NAME = 'original_data'
AND table_name = 'mytable';
  set @query = IF(@exist <= 0, 'alter table intent add column mycolumn4 varchar(2048) NULL after mycolumn3',
  'select \'Column Exists\' status');
  prepare stmt from @query;
EXECUTE stmt;
```

## Re-runnable DML Examples

### Inserting new data

When inserting data in a re-runnable script the table **MUST** have a primary key.  By inserting 
with a primary key set you can avoid data duplication.  The `INSERT IGNORE` will not generate
an error if the record already exists.

```
INSERT IGNORE INTO `oauth_users` VALUES ('test','$2y$14$f3qml4G2hG6sxM26VMq.geDYbsS089IBtVJ7DlD05BoViS9PFykE2','test','user');
```

In this example the first column is the primary key.

### Updating data

Using update statements with very specific where clauses will allow update that only affect single 
records.  Using the primary key in the where clause is recommended.

