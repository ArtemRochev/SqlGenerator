# PostgreSQL-StatementGenerator
Generate 'CREATE TABLE <table_name> ...' statement for PosqtgreSQL<br>
from yaml file

```sql
Post:
  fields:
    name: varchar(50)
    content: text
```

```php
$g = new StatementGenerator;
$g->generateStatement('schema.yaml');
```

```sql
CREATE TABLE Category (
	id SERIAL, category_name varchar(50),
	category_created TIMESTAMPTZ DEFAULT now(),
	category_updated TIMESTAMPTZ DEFAULT now()
);

CREATE FUNCTION update_timestamp()	
RETURNS TRIGGER AS $$
BEGIN
    NEW.category_updated := now();
    RETURN NEW;	
END;
$$ language 'plpgsql';
CREATE TRIGGER update_timestamp
	BEFORE UPDATE ON Category
	FOR EACH ROW
	EXECUTE PROCEDURE update_timestamp();
```
