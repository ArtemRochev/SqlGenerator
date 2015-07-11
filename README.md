# SqlGenerator
Generate ```'CREATE TABLE <table_name> ...'``` statement for PosqtgreSQL<br>
with triggers that update timestamps<br>
from yaml file<br>

```sql
Post:
   fields:
       title: varchar(50)
       content: text

Category:
   fields:
       name: varchar(50)
```

usage:
```php
$generator = new SqlGenerator;

echo $generator->generateSql('schema.yaml');
```

output:
```sql
CREATE TABLE Post (
	id SERIAL,
	post_title varchar(50),
	post_content text,
	post_created TIMESTAMPTZ DEFAULT now(),
	post_updated TIMESTAMPTZ DEFAULT now()
);

CREATE TABLE Category (
	id SERIAL,
	category_name varchar(50),
	category_created TIMESTAMPTZ DEFAULT now(),
	category_updated TIMESTAMPTZ DEFAULT now()
);

CREATE FUNCTION update_timestamp()	
RETURNS TRIGGER AS $$
BEGIN
    NEW.post_updated := now();
    RETURN NEW;	
END;
$$ language 'plpgsql';

CREATE TRIGGER update_timestamp
	BEFORE UPDATE ON Post
	FOR EACH ROW
	EXECUTE PROCEDURE update_timestamp();

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
