CREATE TRIGGER update_timestamp
	BEFORE UPDATE ON %s
	FOR EACH ROW
	EXECUTE PROCEDURE update_timestamp();
