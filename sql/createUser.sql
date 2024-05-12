CREATE USER 'admin'@'localhost' IDENTIFIED BY 'admin';
GRANT ALL PRIVILEGES ON blog.* TO 'admin'@'localhost';
FLUSH PRIVILEGES;

ALTER USER 'admin'@'localhost' IDENTIFIED BY 'admin';
