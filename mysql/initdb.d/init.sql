-- CREATE TABLE test_db.user (
--     id      INT             NOT NULL,
--     first_name  VARCHAR(14)     NOT NULL,
--     password VARCHAR(100)  NOT NULL;
--     PRIMARY KEY (id)
-- );

-- INSERT INTO `user` VALUES (1, 'sampleuser', 'samplepassword')


CREATE TABLE test_db.users (
    id      INT             NOT NULL,
    first_name  VARCHAR(14)     NOT NULL,
    age         INT,  
    PRIMARY KEY (id)
);

INSERT INTO `users` VALUES (1, 'Fuku', 30)