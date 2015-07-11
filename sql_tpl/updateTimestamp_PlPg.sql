CREATE FUNCTION update_timestamp()	
    RETURNS TRIGGER AS $$
    BEGIN
        NEW.%s := now();
        RETURN NEW;	
    END;
$$ language 'plpgsql';
