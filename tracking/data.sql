CREATE TABLE chef_data (
    chef_id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(255),
    last_name VARCHAR(255),
    email VARCHAR(255),
    gender VARCHAR(50),
    c_address VARCHAR(255),
    city VARCHAR(255),
    nationality VARCHAR(100),       
    years_of_experience INT,                         
    date_added TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


CREATE TABLE user_accounts (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255),
    first_name VARCHAR(255),
    last_name VARCHAR(255),
    password VARCHAR(255),
    date_added TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


CREATE TABLE activity_logs (
    activity_log_id INT AUTO_INCREMENT PRIMARY KEY,
    operation VARCHAR(255),
    chef_id INT,
    first_name VARCHAR(255),
    last_name VARCHAR(255),
    email VARCHAR(255),
    gender VARCHAR(50),
    c_address VARCHAR(255),
    city VARCHAR(255),
    nationality VARCHAR(100),       
    years_of_experience INT,                         
    date_added TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);