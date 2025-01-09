
------------------------------ USERS -----------------------------------

CREATE TABLE users
(
    id                int          NOT NULL auto_increment PRIMARY KEY,
    username          varchar(50)  NOT NULL UNIQUE,
    email             varchar(100) NOT NULL UNIQUE,
    password          varchar(255) NOT NULL,
    gdpr              tinyint(1)            DEFAULT 0,
    card_no           varchar(255)          UNIQUE,
    is_admin          tinyint(1)   NOT NULL DEFAULT 0,
    active            tinyint(1)            DEFAULT 0,
    activation_code   varchar(255) NOT NULL,
    activation_expiry datetime     NOT NULL,
    activated_at      datetime              DEFAULT NULL,
    created_at        timestamp    NOT NULL DEFAULT current_timestamp(),
    updated_at        datetime              DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;



CREATE TABLE password_resets
(
    id                int  NOT NULL auto_increment PRIMARY KEY,
    user_id           int  NOT NULL,
    email             varchar(100) NOT NULL,
    new_password      varchar(255) NOT NULL,
    activation_code   varchar(255) NOT NULL,
    activation_expiry datetime     NOT NULL,
    created_at        timestamp    NOT NULL DEFAULT current_timestamp(),
    CONSTRAINT FK_user_passw FOREIGN KEY (user_id) REFERENCES users(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
ALTER TABLE password_resets
DROP CONSTRAINT FK_user_passw;

ALTER TABLE password_resets
ADD CONSTRAINT FK_user_passw
FOREIGN key (user_id)
REFERENCES users(id)
ON DELETE CASCADE;



------------------------------ BOOKS -----------------------------------

CREATE TABLE authors
(
    id                int          NOT NULL auto_increment PRIMARY KEY,
    first_name        varchar(50)  ,
    last_name         varchar(50)  NOT NULL,
    created_at        timestamp    NOT NULL DEFAULT current_timestamp(),
    updated_at        datetime              DEFAULT current_timestamp() ON UPDATE current_timestamp(),
    CONSTRAINT unique_author UNIQUE (first_name, last_name)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;



CREATE TABLE books
(
    id                int          NOT NULL auto_increment PRIMARY KEY,
    title             varchar(100) NOT NULL,
    edition           varchar(20)  ,
    isbn              varchar(25)  NOT NULL,
    publisher         varchar(255) NOT NULL,   
    publication_year  int          ,
    language          varchar(20)           DEFAULT 'Romana',
    created_at        timestamp    NOT NULL DEFAULT current_timestamp(),
    updated_at        datetime              DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

ALTER TABLE books
ADD CONSTRAINT unique_book UNIQUE (title, isbn);
 
ALTER TABLE books
ADD no_of_copies int after language;



CREATE TABLE author_book
(
    id                int  NOT NULL auto_increment PRIMARY KEY,
    author_id         int,
    book_id           int,
    CONSTRAINT FK_author_book FOREIGN KEY (author_id) REFERENCES authors(id),
    CONSTRAINT FK_book_author FOREIGN KEY (book_id) REFERENCES books(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

ALTER TABLE author_book
DROP CONSTRAINT FK_author_book;

ALTER TABLE author_book
ADD CONSTRAINT FK_author_book
FOREIGN key (author_id)
REFERENCES authors(id)
ON DELETE CASCADE;

ALTER TABLE author_book
DROP CONSTRAINT FK_book_author;

ALTER TABLE author_book
ADD CONSTRAINT FK_book_author
FOREIGN key (book_id)
REFERENCES books(id)
ON DELETE CASCADE;



CREATE TABLE borrowed_books
(
    id                  int                          NOT NULL auto_increment PRIMARY KEY,
    book_id             int                          NOT NULL,
    user_id             int                          NOT NULL,
    status              ENUM('borrowed', 'returned') NOT NULL DEFAULT 'borrowed',
    borrowed_at         timestamp                    NOT NULL DEFAULT current_timestamp(),
    due_date            datetime                     NOT NULL,
    returned_at         timestamp                    NULL,
    CONSTRAINT FK_borrow_book FOREIGN KEY (book_id) REFERENCES books(id) ON DELETE CASCADE,
    CONSTRAINT FK_borrow_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;



------------------------------ FEES -----------------------------------

CREATE TABLE users_fees
(
    id                  int                         NOT NULL auto_increment PRIMARY KEY,
    user_id             int                         NOT NULL,
    book_id             int                         NOT NULL,
    late_fee            decimal(19,4),
    payment_status      ENUM('paid', 'not paid')             DEFAULT 'not paid',
    created_at          timestamp                   NOT NULL DEFAULT current_timestamp(),
    updated_at          timestamp                             DEFAULT current_timestamp() ON UPDATE current_timestamp(),
    CONSTRAINT FK_fee_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    CONSTRAINT FK_fee_book FOREIGN KEY (book_id) REFERENCES books(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;



--------------------------- SITE ANALYTICS ---------------------------

CREATE TABLE analytics (
    id INT AUTO_INCREMENT PRIMARY KEY,
    ip_address VARCHAR(45) NOT NULL, 
    user_agent TEXT NOT NULL,
    page_url VARCHAR(255) NOT NULL,
    book_id INT NULL,
    session_id VARCHAR(255) NOT NULL,
    visit_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT FK_book_analytics FOREIGN KEY (book_id) REFERENCES books(id) ON DELETE CASCADE,
    UNIQUE KEY unique_visit (ip_address, session_id, page_url, book_id) -- Previne duplicatele in aceeasi sesiune
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


