# PostgreSQL-StatementGenerator
Generate ```'CREATE TABLE <table_name> ...'``` statement for PosqtgreSQL<br>
with triggers that update timestamps<br>
from yaml file<br>

```sql
Post:
  fields:
    name: varchar(50)
    content: text
```

usage:
```php
$g = new StatementGenerator;

echo $g->generateStatements('schema.yaml')[0] . "\n" .
     $g->generateStatements('schema.yaml')[1] . "\n";
```

output:
```sql
CREATE TABLE Post (
	id SERIAL, post_name varchar(50), post_content text,
	post_created TIMESTAMPTZ DEFAULT now(),
	post_updated TIMESTAMPTZ DEFAULT now()
);

CREATE FUNCTION update_timestamp()	
RETURNS TRIGGER AS $$
BEGIN
    NEW.category_updated := now();
    RETURN NEW;	
END;
$$ language 'plpgsql';
CREATE TRIGGER update_timestamp
	BEFORE UPDATE ON Post
	FOR EACH ROW
	EXECUTE PROCEDURE update_timestamp();
```
