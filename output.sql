CREATE TABLE Post (
	id SERIAL,
	post_title varchar(50),
	post_content text,
	post_created TIMESTAMPTZ DEFAULT now(),
	post_updated TIMESTAMPTZ DEFAULT now()
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

CREATE TABLE Category (
	id SERIAL,
	category_name varchar(50),
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

