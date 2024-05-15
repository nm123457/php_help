CREATE TABLE events (
    id INT AUTO_INCREMENT PRIMARY KEY,
    event_name VARCHAR(255) NOT NULL,
    event_date VARCHAR(255) NOT NULL,
    location VARCHAR(255) NOT NULL,
    duration INT NOT NULL
);
