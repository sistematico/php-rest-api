DROP TABLE IF EXISTS 'sessions';
DROP TABLE IF EXISTS 'users';
DROP TABLE IF EXISTS 'tasks';

CREATE TABLE IF NOT EXISTS 'sessions' (
  'id' INTEGER NOT NULL PRIMARY KEY,
  'userid' INTEGER NOT NULL,
  'accesstoken' TEXT NOT NULL UNIQUE,
  'accesstokenexpiry' INTEGER NOT NULL,
  'refreshtoken' TEXT NOT NULL UNIQUE,
  'refreshtokenexpiry' INTEGER NOT NULL,
  FOREIGN KEY(userid) REFERENCES users(id)
);

CREATE TABLE IF NOT EXISTS 'users' (
  'id' INTEGER NOT NULL PRIMARY KEY,
  'fullname' TEXT NOT NULL,
  'username' TEXT NOT NULL UNIQUE,
  'email' TEXT NOT NULL UNIQUE,
  'password' TEXT NOT NULL,
  'secret' TEXT NOT NULL UNIQUE,
  'active' TEXT NOT NULL DEFAULT 'Y',
  'loginattempts' INTEGER NOT NULL DEFAULT '0'
);

-- CREATE TABLE IF NOT EXISTS 'tasks' (
--   'id' INTEGER NOT NULL PRIMARY KEY,
--   'userid' INTEGER NOT NULL,
--   'title' TEXT NOT NULL,
--   'description' TEXT,
--   'deadline' datetime DEFAULT NULL ,
--   'completed' TEXT NOT NULL DEFAULT 'N',
--   FOREIGN KEY(userid) REFERENCES users(id)
-- );

INSERT INTO 'users' (fullname, username, email, password, secret) VALUES ('Administrador', 'admin', 'admin@admin.com', 'admin', 'secret1');
INSERT INTO 'users' (fullname, username, email, password, secret) VALUES ('Usuário', 'user', 'user@user.com', 'password', 'secret2');
