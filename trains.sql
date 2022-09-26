CREATE TABLE trains (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    train_line VARCHAR(20) NOT NULL,
    route_name VARCHAR(20) NOT NULL,
    run_number VARCHAR(20) NOT NULL,
    operator_id VARCHAR(30) NOT NULL
) ENGINE='InnoDB';